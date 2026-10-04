<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\Messages\MessageGetActivitiesResponse;
use SentDm\Messages\MessageGetStatusResponse;
use SentDm\Messages\MessageSendParams\Template;
use SentDm\Messages\MessageSendResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type TemplateShape from \SentDm\Messages\MessageSendParams\Template
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface MessagesContract
{
    /**
     * @api
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
    ): MessageGetActivitiesResponse;

    /**
     * @api
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
    ): MessageGetStatusResponse;

    /**
     * @api
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
    ): MessageSendResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function resend(
        string $id,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageSendResponse;
}
