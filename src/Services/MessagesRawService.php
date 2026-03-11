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
 * Send and track SMS and WhatsApp messages.
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
     * Retrieves the activity log for a specific message. Activities track the message lifecycle including acceptance, processing, sending, delivery, and any errors.
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
     * Retrieves the current status and details of a message by ID. Includes delivery status, timestamps, and error information if applicable.
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
     * Sends a message to one or more recipients using a template. Supports multi-channel broadcast — when multiple channels are specified (e.g. ["sms", "whatsapp"]), a separate message is created for each (recipient, channel) pair. Returns immediately with per-recipient message IDs for async tracking via webhooks or the GET /messages/{id} endpoint.
     *
     * @param array{
     *   channel?: list<string>|null,
     *   sandbox?: bool,
     *   template?: Template|TemplateShape,
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
