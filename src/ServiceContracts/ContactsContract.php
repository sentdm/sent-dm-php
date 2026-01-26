<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Contacts\ContactListItem;
use SentDm\Contacts\ContactListResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ContactsContract
{
    /**
     * @api
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
    ): ContactListResponse;

    /**
     * @api
     *
     * @param string $phoneNumber The phone number in international format (e.g., +1234567890)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): ContactListItem;

    /**
     * @api
     *
     * @param string $id The unique identifier (GUID) of the resource to retrieve
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveID(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): ContactListItem;
}
