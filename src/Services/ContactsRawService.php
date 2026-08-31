<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Contacts\ContactCreateParams;
use SentDm\Contacts\ContactDeleteParams;
use SentDm\Contacts\ContactGetMessageSummaryResponse;
use SentDm\Contacts\ContactGetResponse;
use SentDm\Contacts\ContactListParams;
use SentDm\Contacts\ContactListResponse;
use SentDm\Contacts\ContactNewResponse;
use SentDm\Contacts\ContactRetrieveMessageSummaryParams;
use SentDm\Contacts\ContactRetrieveParams;
use SentDm\Contacts\ContactUpdateParams;
use SentDm\Contacts\ContactUpdateResponse;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ContactsRawContract;

/**
 * The people you message, and their channel identities.
 *
 * A contact holds one identity per channel — a phone number, a WhatsApp number — so routing can choose between them for the same person. Opt-out is recorded against the contact and honoured on every send, whichever channel it came through.
 *
 * `GET /v3/contacts/{id}/message-summary` is the per-contact view of what you have sent and what happened to it.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class ContactsRawService implements ContactsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Creates a new contact by phone number and associates it with the authenticated customer.
     *
     * @param array{
     *   phoneNumber: string,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ContactCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ContactCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/contacts',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: ContactNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a specific contact by their unique identifier. Returns detailed contact information including phone formats, available channels, and opt-out status.
     *
     * @param string $id Contact ID from route parameter
     * @param array{xProfileID?: string}|ContactRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|ContactRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/contacts/%1$s', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: ContactGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Updates a contact's default channel and/or opt-out status.
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param array{
     *   defaultChannel?: string|null,
     *   optOut?: bool|null,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ContactUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|ContactUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v3/contacts/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: ContactUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a paginated list of contacts for the authenticated customer. Supports filtering by search term, channel, or phone number.
     *
     * @param array{
     *   page: int,
     *   pageSize: int,
     *   channel?: string|null,
     *   phone?: string|null,
     *   search?: string|null,
     *   xProfileID?: string,
     * }|ContactListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ContactListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['page', 'pageSize', 'channel', 'phone', 'search']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/contacts',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['pageSize' => 'page_size']
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: ContactListResponse::class,
        );
    }

    /**
     * @deprecated
     *
     * @api
     *
     * **Deprecated.** Use `PATCH /v3/contacts/{id}` with `{"opt_out": true}` instead, and expect this to be removed in a future release. It still behaves exactly as before, so nothing needs to change today.
     *
     * Opting a contact out stops every send to them, which is what deleting one was mostly used for — and it keeps the record of who they were and that they asked. A delete discards the consent history along with the contact, which is the part you need if anyone ever asks why you stopped, or why you started again.
     *
     * Dissociates a contact from the authenticated customer.
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param array{sandbox?: bool, xProfileID?: string}|ContactDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|ContactDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['xProfileID' => 'x-profile-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/contacts/%1$s', $id],
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
     * Returns aggregate message counts, time bounds, channels used, and per-channel success/fail scores (each as a percentage 0-100 of messages on that channel) for one of your contacts. Successful terminal states: SENT/DELIVERED/READ for outbound, RECEIVED for inbound. Fail: FAILED.
     *
     * @param array{xProfileID?: string}|ContactRetrieveMessageSummaryParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactGetMessageSummaryResponse>
     *
     * @throws APIException
     */
    public function retrieveMessageSummary(
        string $contactID,
        array|ContactRetrieveMessageSummaryParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactRetrieveMessageSummaryParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/contacts/%1$s/message-summary', $contactID],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: ContactGetMessageSummaryResponse::class,
        );
    }
}
