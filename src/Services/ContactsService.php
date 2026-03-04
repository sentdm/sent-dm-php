<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Contacts\APIResponseContact;
use SentDm\Contacts\ContactDeleteParams\Body;
use SentDm\Contacts\ContactListResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ContactsContract;

/**
 * Create, update, and manage customer contact lists.
 *
 * @phpstan-import-type BodyShape from \SentDm\Contacts\ContactDeleteParams\Body
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
     * Creates a new contact by phone number and associates it with the authenticated customer.
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
    ): APIResponseContact {
        $params = Util::removeNulls(
            [
                'phoneNumber' => $phoneNumber,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a specific contact by their unique identifier. Returns detailed contact information including phone formats, available channels, and opt-out status.
     *
     * @param string $id Contact ID from route parameter
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): APIResponseContact {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates a contact's default channel and/or opt-out status. Inherited contacts cannot be updated.
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
    ): APIResponseContact {
        $params = Util::removeNulls(
            [
                'defaultChannel' => $defaultChannel,
                'optOut' => $optOut,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a paginated list of contacts for the authenticated customer. Supports filtering by search term, channel, or phone number.
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
    ): ContactListResponse {
        $params = Util::removeNulls(
            [
                'page' => $page,
                'pageSize' => $pageSize,
                'channel' => $channel,
                'phone' => $phone,
                'search' => $search,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Dissociates a contact from the authenticated customer. Inherited contacts cannot be deleted.
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
    ): mixed {
        $params = Util::removeNulls(['body' => $body]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
