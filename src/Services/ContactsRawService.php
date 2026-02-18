<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Contacts\APIResponseContact;
use SentDm\Contacts\ContactCreateParams;
use SentDm\Contacts\ContactDeleteParams;
use SentDm\Contacts\ContactDeleteParams\Body;
use SentDm\Contacts\ContactListParams;
use SentDm\Contacts\ContactListResponse;
use SentDm\Contacts\ContactUpdateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ContactsRawContract;

/**
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
     *   phoneNumber?: string, testMode?: bool, idempotencyKey?: string
     * }|ContactCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseContact>
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
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

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
            convert: APIResponseContact::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a specific contact by their unique identifier. Returns detailed contact information including phone formats, available channels, and opt-out status.
     *
     * @param string $id Contact ID from route parameter
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseContact>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/contacts/%1$s', $id],
            options: $requestOptions,
            convert: APIResponseContact::class,
        );
    }

    /**
     * @api
     *
     * Updates a contact's default channel and/or opt-out status. Inherited contacts cannot be updated.
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param array{
     *   defaultChannel?: string|null,
     *   optOut?: bool|null,
     *   testMode?: bool,
     *   idempotencyKey?: string,
     * }|ContactUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseContact>
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
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

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
            convert: APIResponseContact::class,
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/contacts',
            query: $parsed,
            options: $options,
            convert: ContactListResponse::class,
        );
    }

    /**
     * @api
     *
     * Dissociates a contact from the authenticated customer. Inherited contacts cannot be deleted.
     *
     * @param string $id Contact ID from route parameter
     * @param array{body: Body|BodyShape}|ContactDeleteParams $params
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
            headers: ['Content-Type' => '*/*'],
            body: (object) $parsed['body'],
            options: $options,
            convert: null,
        );
    }
}
