<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Messages\MessageGetActivitiesResponse;
use SentDm\Messages\MessageGetStatusResponse;
use SentDm\Messages\MessageSendParams\Template;
use SentDm\Messages\MessageSendResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\MessagesContract;

/**
 * Send a message and follow what happened to it.
 *
 * One endpoint sends on any channel: pass `channel: "sent"` and we pick between SMS, WhatsApp and RCS per recipient using your routing rules, or name a channel to pin it. A send is accepted asynchronously — `POST /v3/messages` returns an id, and delivery is reported through `GET /v3/messages/{id}`, its activities, or a webhook.
 *
 * **A message needs a sender.** What you can send, where, and at what cost is decided by the markets under **Channels** — so a recipient in a country you hold no sender for is refused here rather than queued.
 *
 * **A message can be resent on its id.** `POST /v3/messages/{id}/resend` puts a finished message — typically one BLOCKED for insufficient balance — back through the send pipeline. It is a new attempt, not a free retry: every policy runs again, the message is billed again, and its status webhooks fire again. A FILTERED message is never resendable.
 *
 * @phpstan-import-type TemplateShape from \SentDm\Messages\MessageSendParams\Template
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class MessagesService implements MessagesContract
{
    /**
     * @api
     */
    public MessagesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MessagesRawService($client);
    }

    /**
     * @api
     *
     * Retrieves the activity log for a specific message. Activities track the message lifecycle including acceptance, processing, sending, delivery, and any errors. A SCHEDULED entry carries scheduled_at, the release instant in UTC as it stood at that moment. Other entries have no scheduled_at key.
     *
     * @param string $id Message ID from route parameter
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveActivities(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageGetActivitiesResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveActivities($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves the current status and details of a message by ID. Includes delivery status, timestamps, and error information if applicable. A message that is or was held for a later time (a send you scheduled with scheduled_at, or a quiet-hours hold) is returned as a ScheduledMessageResponse: the same fields plus scheduled_at, the release instant in UTC. A message sent immediately has no scheduled_at key.
     *
     * @param string $id Message ID
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveStatus(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageGetStatusResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveStatus($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends a message to one or more recipients using a template. Supports multi-channel broadcast — when multiple channels are specified (e.g. ["sms", "whatsapp"]), a separate message is created for each (recipient, channel) pair. Returns immediately with per-recipient message IDs for async tracking via webhooks or the GET /messages/{id} endpoint. Sends gated before any delivery attempt do not reject the request — an account-level precondition such as insufficient balance, a template not approved for sending, or free-form content with no open conversation with the contact. The send is accepted with 202 and the affected messages are reported as BLOCKED on GET /messages/{id} and the message.blocked webhook. To send later, set scheduled_at (ISO-8601 with an explicit UTC offset; a value without one is rejected) between 1 minute and 30 days ahead: the response is a ScheduledSendMessageResponse (the same fields plus scheduled_at; status is still QUEUED), each message then moves to SCHEDULED, is held and released at that time (within a few minutes), and a message.scheduled webhook fires once it is held. Balance and template approval are evaluated at release, not at acceptance. Quiet hours are not checked when the request is accepted: if the time falls inside a legally protected quiet-hours window for a recipient, that message is moved to the next allowed time at release and a second message.scheduled webhook reports the new scheduled_at. An account may hold at most 1,000,000 scheduled messages at once (429 LIMIT_001).
     *
     * @param list<string>|null $channel Body param: Channels to broadcast on, e.g. ["whatsapp", "sms"].
     * Each channel produces a separate message per recipient.
     * "sent" = auto-detect.
     * Defaults to ["sent"] (auto-detect) if omitted.
     * @param list<string>|null $mediaURLs Body param: Attachments for this send, as publicly fetchable https URLs. Used by the MMS channel and ignored
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
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param \DateTimeInterface|null $scheduledAt Body param: Optional future send time as an ISO-8601 timestamp with an explicit UTC offset, e.g.
     * 2026-10-01T09:00:00+02:00 or 2026-10-01T07:00:00Z. A value without an offset is rejected
     * (400) rather than read in the server's zone. The offset only fixes the instant: it is stored and echoed
     * in UTC as scheduled_at. Omit to send now. Must be at least one minute ahead and at most 30 days
     * ahead. Accepted messages report SCHEDULED and are released for delivery at this time. Quiet hours,
     * balance and template approval are evaluated at release, not at acceptance: a message whose time
     * falls inside a recipient's protected quiet-hours window is moved to the next allowed time and a second
     * message.scheduled webhook reports the new scheduled_at.
     * @param string|null $subject Body param: Subject line for this send, overriding the template's. MMS only; ignored on every other channel.
     * Most handsets render it above the body, some ignore it entirely.
     * @param Template|TemplateShape|null $template body param: SDK-style template reference: resolve by ID or by name, with optional parameters
     * @param string|null $text Body param: Plain-text (free-form) message body. Provide either Template or this.
     * @param list<string> $to Body param: List of recipient phone numbers in E.164 format (multi-recipient fan-out)
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function send(
        ?array $channel = null,
        ?array $mediaURLs = null,
        ?bool $sandbox = null,
        ?\DateTimeInterface $scheduledAt = null,
        ?string $subject = null,
        Template|array|null $template = null,
        ?string $text = null,
        ?array $to = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageSendResponse {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'mediaURLs' => $mediaURLs,
                'sandbox' => $sandbox,
                'scheduledAt' => $scheduledAt,
                'subject' => $subject,
                'template' => $template,
                'text' => $text,
                'to' => $to,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->send(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
