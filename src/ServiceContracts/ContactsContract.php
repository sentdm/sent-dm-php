<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Contacts\APIResponseOfContact;
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
     * @param string $phoneNumber Body param: Phone number of the contact to create
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $phoneNumber = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfContact;

    /**
     * @api
     *
     * @param string $id Contact ID from route parameter
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfContact;

    /**
     * @api
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param array<string,string>|null $channelConsent Body param: Consent status by channel. Keys: "sms", "whatsapp". Values: "opted_in", "opted_out".
     * All entries must have the same status — mixed values (e.g., sms: opted_out + whatsapp: opted_in)
     * are rejected with 400. The provided status is applied to ALL channels regardless of which keys
     * are specified, because consent is global across channels.
     * When provided, takes precedence over the opt_out field.
     * @param string|null $defaultChannel Body param: Default messaging channel: "sms" or "whatsapp"
     * @param bool|null $optOut Body param: Whether the contact has opted out of messaging
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?array $channelConsent = null,
        ?string $defaultChannel = null,
        ?bool $optOut = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfContact;

    /**
     * @api
     *
     * @param int $page Query param: Page number (1-indexed)
     * @param int $pageSize Query param: Number of items per page
     * @param string|null $channel Query param: Optional channel filter (sms, whatsapp)
     * @param string|null $phone Query param: Optional phone number filter (alternative to list view)
     * @param string|null $search Query param: Optional search term for filtering contacts
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
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
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ContactListResponse;

    /**
     * @api
     *
     * @param string $id Path param: Contact ID from route parameter
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
