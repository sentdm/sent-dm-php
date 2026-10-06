<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of an outbound message lifecycle event. Delivered once per status change, so a single
 * message produces several of these as it moves toward a terminal status.
 *
 * @phpstan-type MessageEventPayloadShape = array{
 *   messageStatus: string,
 *   accountID?: string|null,
 *   agentID?: string|null,
 *   body?: string|null,
 *   channel?: string|null,
 *   messageID?: string|null,
 *   outboundNumber?: string|null,
 *   reason?: string|null,
 *   reasonCode?: string|null,
 *   scheduleReason?: string|null,
 *   scheduledAt?: string|null,
 *   templateID?: string|null,
 *   templateName?: string|null,
 *   updatedAt?: string|null,
 * }
 */
final class MessageEventPayload implements BaseModel
{
    /** @use SdkModel<MessageEventPayloadShape> */
    use SdkModel;

    /**
     * The status the message just reached, for example SENT, DELIVERED, or
     * FAILED. Sent means dispatched and delivered means confirmed, so treat them as
     * distinct outcomes.
     */
    #[Required('message_status')]
    public string $messageStatus;

    /**
     * The account the message belongs to.
     */
    #[Optional('account_id')]
    public ?string $accountID;

    /**
     * The agent attributed to the send, when the send was attributed to one.
     */
    #[Optional('agent_id', nullable: true)]
    public ?string $agentID;

    /**
     * The rendered message body, as plain text. Sent as null when we aren't asserting a
     * body for this event. The field is always present, so read it and check for null rather than
     * checking whether the key exists. Truncated to 3072 characters.
     */
    #[Optional(nullable: true)]
    public ?string $body;

    /**
     * The channel the message went out on, for example sms or whatsapp. A message
     * that falls back to another channel reports the channel actually used.
     */
    #[Optional]
    public ?string $channel;

    /**
     * The message this event describes. Stable across every event in the message's lifecycle, so
     * use it to correlate them.
     */
    #[Optional('message_id')]
    public ?string $messageID;

    /**
     * The recipient's number in E.164 format.
     */
    #[Optional('outbound_number')]
    public ?string $outboundNumber;

    /**
     * A human-readable sentence for ReasonCode, for example "The recipient is not registered on
     * this channel". Omitted whenever reason_code is.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * Why the message reached this status, as a stable platform code such as
     * DELIVERY_007 or BUSINESS_003. Present on
     * message.failed, message.filtered and message.blocked; omitted on every status that
     * needs no explanation. Switch on this rather than on Reason: the code is
     * stable, the wording may be improved. It is the platform's classification of the outcome and never a
     * carrier or vendor code.
     */
    #[Optional('reason_code', nullable: true)]
    public ?string $reasonCode;

    /**
     * message.scheduled only: why the message is held, either because you scheduled it or because
     * the recipient is inside a protected quiet-hours window. Omitted on every other event, including
     * message.cancelled — that is a property of the hold, not of the cancellation, and repeating it
     * there would read as "why was this cancelled", which it does not answer.
     */
    #[Optional('schedule_reason', nullable: true)]
    public ?string $scheduleReason;

    /**
     * message.scheduled and message.cancelled only, in UTC (yyyy-MM-ddTHH:mm:ssZ): on
     * message.scheduled it is when the held message will be released for delivery, on
     * message.cancelled the release instant that was called off — the same instant, before and after.
     * A consumer that recorded a future send from the first event has what it needs to un-record it from the
     * second. Omitted on every other event.
     */
    #[Optional('scheduled_at', nullable: true)]
    public ?string $scheduledAt;

    /**
     * The template the message was sent from, when it was sent from one.
     */
    #[Optional('template_id', nullable: true)]
    public ?string $templateID;

    /**
     * Name of the template the message was sent from. Omitted when the message wasn't
     * template-based.
     */
    #[Optional('template_name', nullable: true)]
    public ?string $templateName;

    /**
     * When the message reached MessageStatus, in UTC
     * (yyyy-MM-ddTHH:mm:ssZ).
     */
    #[Optional('updated_at')]
    public ?string $updatedAt;

    /**
     * `new MessageEventPayload()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageEventPayload::with(messageStatus: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageEventPayload)->withMessageStatus(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $messageStatus,
        ?string $accountID = null,
        ?string $agentID = null,
        ?string $body = null,
        ?string $channel = null,
        ?string $messageID = null,
        ?string $outboundNumber = null,
        ?string $reason = null,
        ?string $reasonCode = null,
        ?string $scheduleReason = null,
        ?string $scheduledAt = null,
        ?string $templateID = null,
        ?string $templateName = null,
        ?string $updatedAt = null,
    ): self {
        $self = new self;

        $self['messageStatus'] = $messageStatus;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $agentID && $self['agentID'] = $agentID;
        null !== $body && $self['body'] = $body;
        null !== $channel && $self['channel'] = $channel;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $outboundNumber && $self['outboundNumber'] = $outboundNumber;
        null !== $reason && $self['reason'] = $reason;
        null !== $reasonCode && $self['reasonCode'] = $reasonCode;
        null !== $scheduleReason && $self['scheduleReason'] = $scheduleReason;
        null !== $scheduledAt && $self['scheduledAt'] = $scheduledAt;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateName && $self['templateName'] = $templateName;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The status the message just reached, for example SENT, DELIVERED, or
     * FAILED. Sent means dispatched and delivered means confirmed, so treat them as
     * distinct outcomes.
     */
    public function withMessageStatus(string $messageStatus): self
    {
        $self = clone $this;
        $self['messageStatus'] = $messageStatus;

        return $self;
    }

    /**
     * The account the message belongs to.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * The agent attributed to the send, when the send was attributed to one.
     */
    public function withAgentID(?string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * The rendered message body, as plain text. Sent as null when we aren't asserting a
     * body for this event. The field is always present, so read it and check for null rather than
     * checking whether the key exists. Truncated to 3072 characters.
     */
    public function withBody(?string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * The channel the message went out on, for example sms or whatsapp. A message
     * that falls back to another channel reports the channel actually used.
     */
    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * The message this event describes. Stable across every event in the message's lifecycle, so
     * use it to correlate them.
     */
    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    /**
     * The recipient's number in E.164 format.
     */
    public function withOutboundNumber(string $outboundNumber): self
    {
        $self = clone $this;
        $self['outboundNumber'] = $outboundNumber;

        return $self;
    }

    /**
     * A human-readable sentence for ReasonCode, for example "The recipient is not registered on
     * this channel". Omitted whenever reason_code is.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the message reached this status, as a stable platform code such as
     * DELIVERY_007 or BUSINESS_003. Present on
     * message.failed, message.filtered and message.blocked; omitted on every status that
     * needs no explanation. Switch on this rather than on Reason: the code is
     * stable, the wording may be improved. It is the platform's classification of the outcome and never a
     * carrier or vendor code.
     */
    public function withReasonCode(?string $reasonCode): self
    {
        $self = clone $this;
        $self['reasonCode'] = $reasonCode;

        return $self;
    }

    /**
     * message.scheduled only: why the message is held, either because you scheduled it or because
     * the recipient is inside a protected quiet-hours window. Omitted on every other event, including
     * message.cancelled — that is a property of the hold, not of the cancellation, and repeating it
     * there would read as "why was this cancelled", which it does not answer.
     */
    public function withScheduleReason(?string $scheduleReason): self
    {
        $self = clone $this;
        $self['scheduleReason'] = $scheduleReason;

        return $self;
    }

    /**
     * message.scheduled and message.cancelled only, in UTC (yyyy-MM-ddTHH:mm:ssZ): on
     * message.scheduled it is when the held message will be released for delivery, on
     * message.cancelled the release instant that was called off — the same instant, before and after.
     * A consumer that recorded a future send from the first event has what it needs to un-record it from the
     * second. Omitted on every other event.
     */
    public function withScheduledAt(?string $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * The template the message was sent from, when it was sent from one.
     */
    public function withTemplateID(?string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

        return $self;
    }

    /**
     * Name of the template the message was sent from. Omitted when the message wasn't
     * template-based.
     */
    public function withTemplateName(?string $templateName): self
    {
        $self = clone $this;
        $self['templateName'] = $templateName;

        return $self;
    }

    /**
     * When the message reached MessageStatus, in UTC
     * (yyyy-MM-ddTHH:mm:ssZ).
     */
    public function withUpdatedAt(string $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
