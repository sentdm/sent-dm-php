<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;
use SentDm\Messages\MessageSendParams\Channel;
use SentDm\Messages\MessageSendParams\Template;

/**
 * Sends a message to one or more recipients using a template. Supports multi-channel broadcast — when multiple channels are specified (e.g. ["sms", "whatsapp"]), a separate message is created for each (recipient, channel) pair. To choose which of your own numbers a send goes out from, use 'channels': {"sms": [{"from": ["+12125550000", "+14155550000"]}]}. Each channel holds a list of entries, each with 'from' and optionally 'country' and 'strategy'; 'country' and 'strategy' are stored but not acted on yet, so every entry's numbers apply to every recipient on that channel. Every number listed must be an active sender on your account. Like the other account-level preconditions below, that is checked per message rather than when the request is received: the request is still accepted with 202, and each affected message is reported as BLOCKED with error code BUSINESS_029 on GET /messages/{id} and the message.blocked webhook. Each channel's numbers restrict which numbers that channel may use; it does not choose channels — 'channel' does, and the two can be combined. With 'channel' left at auto-detect, a recipient best served by a channel you listed no numbers for still goes out on it. Where several of the listed numbers could serve a recipient, routing prefers the one whose area code matches theirs. Keys: sms, whatsapp, rcs, mms. Returns immediately with per-recipient message IDs for async tracking via webhooks or the GET /messages/{id} endpoint. Sends gated before any delivery attempt do not reject the request — an account-level precondition such as insufficient balance, a template not approved for sending, or free-form content with no open conversation with the contact. The send is accepted with 202 and the affected messages are reported as BLOCKED on GET /messages/{id} and the message.blocked webhook. To send later, set scheduled_at (ISO-8601 with an explicit UTC offset; a value without one is rejected) between 1 minute and 30 days ahead: the response is a ScheduledSendMessageResponse (the same fields plus scheduled_at; status is still QUEUED), each message then moves to SCHEDULED, is held and released at that time (within a few minutes), and a message.scheduled webhook fires once it is held. Balance and template approval are evaluated at release, not at acceptance. Quiet hours are not checked when the request is accepted: if the time falls inside a legally protected quiet-hours window for a recipient, that message is moved to the next allowed time at release and a second message.scheduled webhook reports the new scheduled_at. An account may hold at most 1,000,000 scheduled messages at once (429 LIMIT_001).
 *
 * @see SentDm\Services\MessagesService::send()
 *
 * @phpstan-import-type ChannelShape from \SentDm\Messages\MessageSendParams\Channel
 * @phpstan-import-type TemplateShape from \SentDm\Messages\MessageSendParams\Template
 *
 * @phpstan-type MessageSendParamsShape = array{
 *   channel?: list<string>|null,
 *   channels?: array<string,list<Channel|ChannelShape>>|null,
 *   mediaURLs?: list<string>|null,
 *   sandbox?: bool|null,
 *   scheduledAt?: \DateTimeInterface|null,
 *   subject?: string|null,
 *   template?: null|Template|TemplateShape,
 *   text?: string|null,
 *   to?: list<string>|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class MessageSendParams implements BaseModel
{
    /** @use SdkModel<MessageSendParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Channels to broadcast on, e.g. ["whatsapp", "sms"].
     * Each channel produces a separate message per recipient.
     * "sent" = auto-detect.
     * Defaults to ["sent"] (auto-detect) if omitted.
     *
     * @var list<string>|null $channel
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $channel;

    /**
     * Which of your own numbers to send from, keyed by channel, each channel holding a list of entries:
     * {"sms": [{"country": "US", "from": ["+12125550000", "+14155550000"]}, {"from": ["+447700800001"]}]}.
     * Any real channel may be a key; sent, which is auto-detect rather than a channel, is rejected.
     * country and strategy are accepted and stored but not acted on yet: every entry's
     * numbers apply to every recipient on that channel.
     *
     * This does not choose channels — Channel does, and the two combine:
     * "channel": ["sms"] with an sms list sends on SMS from those numbers. Each list only
     * narrows which of its own channel's routes may win, so with Channel left at
     * auto-detect a recipient best served by a channel with no list still goes out on it. Routing itself
     * is unchanged: the same rules are scored and ranked the same way, with routes pinned to numbers you
     * did not list removed from the running.
     *
     * Every number must be an active sender on your account. The request itself is still
     * accepted (202) if one is not — like every other send-time rule, that is decided per message, so
     * each affected message is recorded BLOCKED with error code BUSINESS_029 and reported on
     * GET /v3/messages and the status webhook.
     *
     * @var array<string,list<Channel>>|null $channels
     */
    #[Optional(map: new ListOf(Channel::class), nullable: true)]
    public ?array $channels;

    /**
     * Attachments for this send, as publicly fetchable https URLs. Used by the MMS channel and ignored
     * by every other one.
     *
     * Supplying these replaces the media on the template's mms body rather than
     * adding to it, so a template can hold a default creative while a caller still sends something
     * recipient-specific.
     *
     * Their presence is also what makes a message eligible for MMS on an auto-detect send: a
     * message with nothing attached is delivered as SMS, because an MMS with no media is a more
     * expensive text message.
     *
     * The recipient's carrier fetches each URL after the send is accepted, so it must stay
     * publicly reachable — a link that expires, or one behind auth, arrives as a failed message.
     *
     * @var list<string>|null $mediaURLs
     */
    #[Optional('media_urls', list: 'string', nullable: true)]
    public ?array $mediaURLs;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * Optional future send time as an ISO-8601 timestamp with an explicit UTC offset, e.g.
     * 2026-10-01T09:00:00+02:00 or 2026-10-01T07:00:00Z. A value without an offset is rejected
     * (400) rather than read in the server's zone. The offset only fixes the instant: it is stored and echoed
     * in UTC as scheduled_at. Omit to send now. Must be at least one minute ahead and at most 30 days
     * ahead. Accepted messages report SCHEDULED and are released for delivery at this time. Quiet hours,
     * balance and template approval are evaluated at release, not at acceptance: a message whose time
     * falls inside a recipient's protected quiet-hours window is moved to the next allowed time and a second
     * message.scheduled webhook reports the new scheduled_at.
     */
    #[Optional('scheduled_at', nullable: true)]
    public ?\DateTimeInterface $scheduledAt;

    /**
     * Subject line for this send, overriding the template's. MMS only; ignored on every other channel.
     * Most handsets render it above the body, some ignore it entirely.
     */
    #[Optional(nullable: true)]
    public ?string $subject;

    /**
     * SDK-style template reference: resolve by ID or by name, with optional parameters.
     */
    #[Optional(nullable: true)]
    public ?Template $template;

    /**
     * Plain-text (free-form) message body. Provide either Template or this.
     */
    #[Optional(nullable: true)]
    public ?string $text;

    /**
     * List of recipient phone numbers in E.164 format (multi-recipient fan-out).
     *
     * @var list<string>|null $to
     */
    #[Optional(list: 'string')]
    public ?array $to;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $channel
     * @param array<string,list<Channel|ChannelShape>>|null $channels
     * @param list<string>|null $mediaURLs
     * @param Template|TemplateShape|null $template
     * @param list<string>|null $to
     */
    public static function with(
        ?array $channel = null,
        ?array $channels = null,
        ?array $mediaURLs = null,
        ?bool $sandbox = null,
        ?\DateTimeInterface $scheduledAt = null,
        ?string $subject = null,
        Template|array|null $template = null,
        ?string $text = null,
        ?array $to = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $channels && $self['channels'] = $channels;
        null !== $mediaURLs && $self['mediaURLs'] = $mediaURLs;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $scheduledAt && $self['scheduledAt'] = $scheduledAt;
        null !== $subject && $self['subject'] = $subject;
        null !== $template && $self['template'] = $template;
        null !== $text && $self['text'] = $text;
        null !== $to && $self['to'] = $to;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Channels to broadcast on, e.g. ["whatsapp", "sms"].
     * Each channel produces a separate message per recipient.
     * "sent" = auto-detect.
     * Defaults to ["sent"] (auto-detect) if omitted.
     *
     * @param list<string>|null $channel
     */
    public function withChannel(?array $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * Which of your own numbers to send from, keyed by channel, each channel holding a list of entries:
     * {"sms": [{"country": "US", "from": ["+12125550000", "+14155550000"]}, {"from": ["+447700800001"]}]}.
     * Any real channel may be a key; sent, which is auto-detect rather than a channel, is rejected.
     * country and strategy are accepted and stored but not acted on yet: every entry's
     * numbers apply to every recipient on that channel.
     *
     * This does not choose channels — Channel does, and the two combine:
     * "channel": ["sms"] with an sms list sends on SMS from those numbers. Each list only
     * narrows which of its own channel's routes may win, so with Channel left at
     * auto-detect a recipient best served by a channel with no list still goes out on it. Routing itself
     * is unchanged: the same rules are scored and ranked the same way, with routes pinned to numbers you
     * did not list removed from the running.
     *
     * Every number must be an active sender on your account. The request itself is still
     * accepted (202) if one is not — like every other send-time rule, that is decided per message, so
     * each affected message is recorded BLOCKED with error code BUSINESS_029 and reported on
     * GET /v3/messages and the status webhook.
     *
     * @param array<string,list<Channel|ChannelShape>>|null $channels
     */
    public function withChannels(?array $channels): self
    {
        $self = clone $this;
        $self['channels'] = $channels;

        return $self;
    }

    /**
     * Attachments for this send, as publicly fetchable https URLs. Used by the MMS channel and ignored
     * by every other one.
     *
     * Supplying these replaces the media on the template's mms body rather than
     * adding to it, so a template can hold a default creative while a caller still sends something
     * recipient-specific.
     *
     * Their presence is also what makes a message eligible for MMS on an auto-detect send: a
     * message with nothing attached is delivered as SMS, because an MMS with no media is a more
     * expensive text message.
     *
     * The recipient's carrier fetches each URL after the send is accepted, so it must stay
     * publicly reachable — a link that expires, or one behind auth, arrives as a failed message.
     *
     * @param list<string>|null $mediaURLs
     */
    public function withMediaURLs(?array $mediaURLs): self
    {
        $self = clone $this;
        $self['mediaURLs'] = $mediaURLs;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    /**
     * Optional future send time as an ISO-8601 timestamp with an explicit UTC offset, e.g.
     * 2026-10-01T09:00:00+02:00 or 2026-10-01T07:00:00Z. A value without an offset is rejected
     * (400) rather than read in the server's zone. The offset only fixes the instant: it is stored and echoed
     * in UTC as scheduled_at. Omit to send now. Must be at least one minute ahead and at most 30 days
     * ahead. Accepted messages report SCHEDULED and are released for delivery at this time. Quiet hours,
     * balance and template approval are evaluated at release, not at acceptance: a message whose time
     * falls inside a recipient's protected quiet-hours window is moved to the next allowed time and a second
     * message.scheduled webhook reports the new scheduled_at.
     */
    public function withScheduledAt(?\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * Subject line for this send, overriding the template's. MMS only; ignored on every other channel.
     * Most handsets render it above the body, some ignore it entirely.
     */
    public function withSubject(?string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }

    /**
     * SDK-style template reference: resolve by ID or by name, with optional parameters.
     *
     * @param Template|TemplateShape|null $template
     */
    public function withTemplate(Template|array|null $template): self
    {
        $self = clone $this;
        $self['template'] = $template;

        return $self;
    }

    /**
     * Plain-text (free-form) message body. Provide either Template or this.
     */
    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * List of recipient phone numbers in E.164 format (multi-recipient fan-out).
     *
     * @param list<string> $to
     */
    public function withTo(array $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
