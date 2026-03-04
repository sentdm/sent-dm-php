<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\WebhooksContract;
use SentDm\Webhooks\APIResponseWebhook;
use SentDm\Webhooks\WebhookListEventsResponse;
use SentDm\Webhooks\WebhookListEventTypesResponse;
use SentDm\Webhooks\WebhookListResponse;
use SentDm\Webhooks\WebhookRotateSecretParams\Body;
use SentDm\Webhooks\WebhookRotateSecretResponse;
use SentDm\Webhooks\WebhookTestResponse;

/**
 * Configure webhook endpoints for real-time event delivery.
 *
 * @phpstan-import-type BodyShape from \SentDm\Webhooks\WebhookRotateSecretParams\Body
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class WebhooksService implements WebhooksContract
{
    /**
     * @api
     */
    public WebhooksRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WebhooksRawService($client);
    }

    /**
     * @api
     *
     * Creates a new webhook endpoint for the authenticated customer.
     *
     * @param string $displayName Body param
     * @param string $endpointURL Body param
     * @param list<string> $eventTypes Body param
     * @param int $retryCount Body param
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param int $timeoutSeconds Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventTypes = null,
        ?int $retryCount = null,
        ?bool $testMode = null,
        ?int $timeoutSeconds = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook {
        $params = Util::removeNulls(
            [
                'displayName' => $displayName,
                'endpointURL' => $endpointURL,
                'eventTypes' => $eventTypes,
                'retryCount' => $retryCount,
                'testMode' => $testMode,
                'timeoutSeconds' => $timeoutSeconds,
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
     * Retrieves a single webhook by ID for the authenticated customer.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): APIResponseWebhook {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates an existing webhook for the authenticated customer.
     *
     * @param string $id Path param
     * @param string $displayName Body param
     * @param string $endpointURL Body param
     * @param list<string> $eventTypes Body param
     * @param int $retryCount Body param
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param int $timeoutSeconds Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventTypes = null,
        ?int $retryCount = null,
        ?bool $testMode = null,
        ?int $timeoutSeconds = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook {
        $params = Util::removeNulls(
            [
                'displayName' => $displayName,
                'endpointURL' => $endpointURL,
                'eventTypes' => $eventTypes,
                'retryCount' => $retryCount,
                'testMode' => $testMode,
                'timeoutSeconds' => $timeoutSeconds,
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
     * Retrieves a paginated list of webhooks for the authenticated customer.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $page,
        int $pageSize,
        ?bool $isActive = null,
        ?string $search = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookListResponse {
        $params = Util::removeNulls(
            [
                'page' => $page,
                'pageSize' => $pageSize,
                'isActive' => $isActive,
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
     * Deletes a webhook for the authenticated customer.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all available webhook event types that can be subscribed to.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listEventTypes(
        RequestOptions|array|null $requestOptions = null
    ): WebhookListEventTypesResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listEventTypes(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a paginated list of delivery events for the specified webhook.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listEvents(
        string $id,
        int $page,
        int $pageSize,
        ?string $search = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookListEventsResponse {
        $params = Util::removeNulls(
            ['page' => $page, 'pageSize' => $pageSize, 'search' => $search]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listEvents($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Generates a new signing secret for the specified webhook. The old secret is immediately invalidated.
     *
     * @param string $id Path param
     * @param Body|BodyShape $body Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $id,
        Body|array $body,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookRotateSecretResponse {
        $params = Util::removeNulls(
            ['body' => $body, 'idempotencyKey' => $idempotencyKey]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->rotateSecret($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends a test event to the specified webhook endpoint to verify connectivity.
     *
     * @param string $id Path param
     * @param string $eventType Body param
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $id,
        ?string $eventType = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookTestResponse {
        $params = Util::removeNulls(
            [
                'eventType' => $eventType,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->test($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Activates or deactivates a webhook for the authenticated customer.
     *
     * @param string $id Path param
     * @param bool $isActive Body param
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function toggleStatus(
        string $id,
        ?bool $isActive = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook {
        $params = Util::removeNulls(
            [
                'isActive' => $isActive,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->toggleStatus($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
