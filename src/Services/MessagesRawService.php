<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Messages\MessageGetActivitiesResponse;
use SentDm\Messages\MessageGetStatusResponse;
use SentDm\Messages\MessageRetrieveActivitiesParams;
use SentDm\Messages\MessageRetrieveStatusParams;
use SentDm\Messages\MessageSendParams;
use SentDm\Messages\MessageSendParams\Template;
use SentDm\Messages\MessageSendResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\MessagesRawContract;

/**
 * Send a message and follow what happened to it.
 *
 * One endpoint sends on any channel: pass `channel: "sent"` and we pick between SMS, WhatsApp and RCS per recipient using your routing rules, or name a channel to pin it. A send is accepted asynchronously — `POST /v3/messages` returns an id, and delivery is reported through `GET /v3/messages/{id}`, its activities, or a webhook.
 *
 * **A message needs a sender.** What you can send, where, and at what cost is decided by the markets under **Channels** — so a recipient in a country you hold no sender for is refused here rather than queued.
 *
 * **A message can be resent on its id.** `POST /v3/messages/{id}/resend` puts a finished message — typically one BLOCKED for insufficient balance — back through the send pipeline. It is a new attempt, not a free retry: every policy runs again, the message is billed again, and its status webhooks fire again. A FILTERED message is never resendable.
 *
 * **A scheduled message can be called off.** `POST /v3/messages/{id}/cancel` cancels a send you scheduled with `scheduled_at`, as long as it has not been released yet. Cancelling is free, fires `message.cancelled`, and is final — a cancelled message cannot be resent.
 *
 * @phpstan-import-type TemplateShape from \SentDm\Messages\MessageSendParams\Template
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class MessagesRawService implements MessagesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieves the activity log for a specific message. Activities track the message lifecycle including acceptance, processing, sending, delivery, and any errors. A SCHEDULED entry carries scheduled_at, the release instant in UTC as it stood at that moment. Other entries have no scheduled_at key.
     *
     * @param string $id Message ID from route parameter
     * @param array{xProfileID?: string}|MessageRetrieveActivitiesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageGetActivitiesResponse>
     *
     * @throws APIException
     */
    public function retrieveActivities(
        string $id,
        array|MessageRetrieveActivitiesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageRetrieveActivitiesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/messages/%1$s/activities', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: MessageGetActivitiesResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieves the current status and details of a message by ID. Includes delivery status, timestamps, and error information if applicable. A message that is or was held for a later time (a send you scheduled with scheduled_at, a quiet-hours hold, or a message you cancelled while it was held) is returned as a ScheduledMessageResponse: the same fields plus scheduled_at, the instant it is held for in UTC — or, on a CANCELLED message, the instant that was called off. A message sent immediately has no scheduled_at key.
     *
     * @param string $id Message ID
     * @param array{xProfileID?: string}|MessageRetrieveStatusParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageGetStatusResponse>
     *
     * @throws APIException
     */
    public function retrieveStatus(
        string $id,
        array|MessageRetrieveStatusParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageRetrieveStatusParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/messages/%1$s', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: MessageGetStatusResponse::class,
        );
    }

    /**
     * @api
     *
     * Sends a message to one or more recipients using a template. Supports multi-channel broadcast — when multiple channels are specified (e.g. ["sms", "whatsapp"]), a separate message is created for each (recipient, channel) pair. Returns immediately with per-recipient message IDs for async tracking via webhooks or the GET /messages/{id} endpoint. Sends gated before any delivery attempt do not reject the request — an account-level precondition such as insufficient balance, a template not approved for sending, or free-form content with no open conversation with the contact. The send is accepted with 202 and the affected messages are reported as BLOCKED on GET /messages/{id} and the message.blocked webhook. To send later, set scheduled_at (ISO-8601 with an explicit UTC offset; a value without one is rejected) between 1 minute and 30 days ahead: the response is a ScheduledSendMessageResponse (the same fields plus scheduled_at; status is still QUEUED), each message then moves to SCHEDULED, is held and released at that time (within a few minutes), and a message.scheduled webhook fires once it is held. Balance and template approval are evaluated at release, not at acceptance. Quiet hours are not checked when the request is accepted: if the time falls inside a legally protected quiet-hours window for a recipient, that message is moved to the next allowed time at release and a second message.scheduled webhook reports the new scheduled_at. An account may hold at most 1,000,000 scheduled messages at once (429 LIMIT_001).
     *
     * @param array{
     *   channel?: list<string>|null,
     *   mediaURLs?: list<string>|null,
     *   sandbox?: bool,
     *   scheduledAt?: \DateTimeInterface|null,
     *   subject?: string|null,
     *   template?: Template|TemplateShape|null,
     *   text?: string|null,
     *   to?: list<string>,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|MessageSendParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageSendResponse>
     *
     * @throws APIException
     */
    public function send(
        array|MessageSendParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageSendParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/messages',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: MessageSendResponse::class,
        );
    }
}
