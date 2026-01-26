<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Messages\MessageGetResponse;
use SentDm\Messages\MessageRetrieveParams;
use SentDm\Messages\MessageSendQuickMessageParams;
use SentDm\Messages\MessageSendToContactParams;
use SentDm\Messages\MessageSendToPhoneParams;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\MessagesRawContract;

/**
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
     * Retrieves comprehensive details about a specific message using the message ID. Returns complete message data including delivery status, channel information, template details, contact information, and pricing. The customer ID is extracted from the authentication token to ensure the message belongs to the authenticated customer.
     *
     * @param array{xAPIKey: string, xSenderID: string}|MessageRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|MessageRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v2/messages/%1$s', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xAPIKey' => 'x-api-key', 'xSenderID' => 'x-sender-id']
            ),
            options: $options,
            convert: MessageGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Sends a message to a phone number using the default template. This endpoint is rate limited to 5 messages per customer per day. The customer ID is extracted from the authentication token.
     *
     * @param array{
     *   customMessage: string, phoneNumber: string, xAPIKey: string, xSenderID: string
     * }|MessageSendQuickMessageParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function sendQuickMessage(
        array|MessageSendQuickMessageParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageSendQuickMessageParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['xAPIKey' => 'x-api-key', 'xSenderID' => 'x-sender-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v2/messages/quick-message',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Sends a message to a specific contact using a template. The message can be sent via SMS or WhatsApp depending on the contact's capabilities. Optionally specify a webhook URL to receive delivery status updates. The customer ID is extracted from the authentication token.
     *
     * @param array{
     *   contactID: string,
     *   templateID: string,
     *   xAPIKey: string,
     *   xSenderID: string,
     *   templateVariables?: array<string,string>|null,
     * }|MessageSendToContactParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function sendToContact(
        array|MessageSendToContactParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageSendToContactParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['xAPIKey' => 'x-api-key', 'xSenderID' => 'x-sender-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v2/messages/contact',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Sends a message to a phone number using a template. The phone number doesn't need to be a pre-existing contact. The message can be sent via SMS or WhatsApp. Optionally specify a webhook URL to receive delivery status updates. The customer ID is extracted from the authentication token.
     *
     * @param array{
     *   phoneNumber: string,
     *   templateID: string,
     *   xAPIKey: string,
     *   xSenderID: string,
     *   templateVariables?: array<string,string>|null,
     * }|MessageSendToPhoneParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function sendToPhone(
        array|MessageSendToPhoneParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageSendToPhoneParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['xAPIKey' => 'x-api-key', 'xSenderID' => 'x-sender-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v2/messages/phone',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: null,
        );
    }
}
