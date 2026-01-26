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
     * @param int $page Query param: The page number (zero-indexed). Default is 0.
     * @param int $pageSize Query param: The number of items per page. Default is 20.
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $page,
        int $pageSize,
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): ContactListResponse;

    /**
     * @api
     *
     * @param string $phoneNumber Query param: The phone number in international format (e.g., +1234567890)
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): ContactListItem;

    /**
     * @api
     *
     * @param string $id Query param: The unique identifier (GUID) of the resource to retrieve
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveID(
        string $id,
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): ContactListItem;
}
