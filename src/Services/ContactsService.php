<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Contacts\ContactListItem;
use SentDm\Contacts\ContactListResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ContactsContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class ContactsService implements ContactsContract
{
    /**
     * @api
     */
    public ContactsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ContactsRawService($client);
    }

    /**
     * @api
     *
     * Retrieves a paginated list of contacts for the authenticated customer. Supports server-side pagination with configurable page size. The customer ID is extracted from the authentication token.
     *
     * @param int $page The page number (zero-indexed). Default is 0.
     * @param int $pageSize The number of items per page. Default is 20.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $page,
        int $pageSize,
        RequestOptions|array|null $requestOptions = null
    ): ContactListResponse {
        $params = Util::removeNulls(['page' => $page, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a contact by their phone number for the authenticated customer. Phone number should be in international format (e.g., +1234567890). The customer ID is extracted from the authentication token.
     *
     * @param string $phoneNumber The phone number in international format (e.g., +1234567890)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): ContactListItem {
        $params = Util::removeNulls(['phoneNumber' => $phoneNumber]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveByPhone(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a specific contact by their unique identifier for the authenticated customer. The customer ID is extracted from the authentication token. Returns detailed contact information including phone number and creation timestamp.
     *
     * @param string $id The unique identifier (GUID) of the resource to retrieve
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveID(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): ContactListItem {
        $params = Util::removeNulls(['id' => $id]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveID(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
