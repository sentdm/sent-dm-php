<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Contacts\APIResponseOfContact;
use SentDm\Contacts\ContactCreateParams;
use SentDm\Contacts\ContactDeleteParams;
use SentDm\Contacts\ContactDeleteParams\Body;
use SentDm\Contacts\ContactListParams;
use SentDm\Contacts\ContactListResponse;
use SentDm\Contacts\ContactRetrieveParams;
use SentDm\Contacts\ContactUpdateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ContactsRawContract;

/**
 * Create, update, and manage customer contact lists.
 *
 * @phpstan-import-type BodyShape from \SentDm\Contacts\ContactDeleteParams\Body
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
     *   phoneNumber?: string,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ContactCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfContact>
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
            convert: APIResponseOfContact::class,
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
     * @return BaseResponse<APIResponseOfContact>
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
            convert: APIResponseOfContact::class,
        );
    }

    /**
     * @api
     *
     * Updates a contact's default channel and/or opt-out status. Inherited contacts cannot be updated.
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param array{
     *   channelConsent?: array<string,string>|null,
     *   defaultChannel?: string|null,
     *   optOut?: bool|null,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ContactUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfContact>
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
            convert: APIResponseOfContact::class,
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
     * @api
     *
     * Dissociates a contact from the authenticated customer. Inherited contacts cannot be deleted.
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param array{
     *   body: Body|BodyShape, xProfileID?: string
     * }|ContactDeleteParams $params
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/contacts/%1$s', $id],
            headers: Util::array_transform_keys(
                array_diff_key($parsed, array_flip(['body'])),
                ['xProfileID' => 'x-profile-id'],
            ),
            body: (object) $parsed['body'],
            options: $options,
            convert: null,
        );
    }
}
