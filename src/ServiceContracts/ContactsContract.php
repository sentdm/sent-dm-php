<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Contacts\APIResponseContact;
use SentDm\Contacts\ContactDeleteParams\Body;
use SentDm\Contacts\ContactListResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type BodyShape from \SentDm\Contacts\ContactDeleteParams\Body
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ContactsContract
{
    /**
     * @api
     *
     * @param string $phoneNumber Body param: Phone number of the contact to create
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $phoneNumber = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseContact;

    /**
     * @api
     *
     * @param string $id Contact ID from route parameter
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): APIResponseContact;

    /**
     * @api
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param string|null $defaultChannel Body param: Default messaging channel: "sms" or "whatsapp"
     * @param bool|null $optOut Body param: Whether the contact has opted out of messaging
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?string $defaultChannel = null,
        ?bool $optOut = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseContact;

    /**
     * @api
     *
     * @param int $page Page number (1-indexed)
     * @param string|null $channel Optional channel filter (sms, whatsapp)
     * @param string|null $phone Optional phone number filter (alternative to list view)
     * @param string|null $search Optional search term for filtering contacts
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $page,
        int $pageSize,
        ?string $channel = null,
        ?string $phone = null,
        ?string $search = null,
        RequestOptions|array|null $requestOptions = null,
    ): ContactListResponse;

    /**
     * @api
     *
     * @param string $id Contact ID from route parameter
     * @param Body|BodyShape $body Request to delete/dissociate a contact
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        Body|array $body,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
