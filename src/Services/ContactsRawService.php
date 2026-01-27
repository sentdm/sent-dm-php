<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Contacts\ContactListItem;
use SentDm\Contacts\ContactListParams;
use SentDm\Contacts\ContactListResponse;
use SentDm\Contacts\ContactRetrieveByPhoneParams;
use SentDm\Contacts\ContactRetrieveIDParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ContactsRawContract;

/**
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
     * Retrieves a paginated list of contacts for the authenticated customer. Supports server-side pagination with configurable page size. The customer ID is extracted from the authentication token.
     *
     * @param array{page: int, pageSize: int}|ContactListParams $params
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
            path: 'v2/contacts',
            query: $parsed,
            options: $options,
            convert: ContactListResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a contact by their phone number for the authenticated customer. Phone number should be in international format (e.g., +1234567890). The customer ID is extracted from the authentication token.
     *
     * @param array{phoneNumber: string}|ContactRetrieveByPhoneParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactListItem>
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        array|ContactRetrieveByPhoneParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactRetrieveByPhoneParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v2/contacts/phone',
            query: $parsed,
            options: $options,
            convert: ContactListItem::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a specific contact by their unique identifier for the authenticated customer. The customer ID is extracted from the authentication token. Returns detailed contact information including phone number and creation timestamp.
     *
     * @param array{id: string}|ContactRetrieveIDParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactListItem>
     *
     * @throws APIException
     */
    public function retrieveID(
        array|ContactRetrieveIDParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactRetrieveIDParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v2/contacts/id',
            query: $parsed,
            options: $options,
            convert: ContactListItem::class,
        );
    }
}
