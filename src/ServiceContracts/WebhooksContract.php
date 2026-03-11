<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Webhooks\APIResponseWebhook;
use SentDm\Webhooks\WebhookListEventsResponse;
use SentDm\Webhooks\WebhookListEventTypesResponse;
use SentDm\Webhooks\WebhookListResponse;
use SentDm\Webhooks\WebhookRotateSecretParams\Body;
use SentDm\Webhooks\WebhookRotateSecretResponse;
use SentDm\Webhooks\WebhookTestResponse;

/**
 * @phpstan-import-type BodyShape from \SentDm\Webhooks\WebhookRotateSecretParams\Body
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface WebhooksContract
{
    /**
     * @api
     *
     * @param string $displayName Body param
     * @param string $endpointURL Body param
     * @param list<string> $eventTypes Body param
     * @param int $retryCount Body param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param int $timeoutSeconds Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventTypes = null,
        ?int $retryCount = null,
        ?bool $sandbox = null,
        ?int $timeoutSeconds = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook;

    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook;

    /**
     * @api
     *
     * @param string $id Path param
     * @param string $displayName Body param
     * @param string $endpointURL Body param
     * @param list<string> $eventTypes Body param
     * @param int $retryCount Body param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param int $timeoutSeconds Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
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
        ?bool $sandbox = null,
        ?int $timeoutSeconds = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook;

    /**
     * @api
     *
     * @param int $page Query param
     * @param int $pageSize Query param
     * @param bool|null $isActive Query param
     * @param string|null $search Query param
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $page,
        int $pageSize,
        ?bool $isActive = null,
        ?string $search = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookListResponse;

    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listEventTypes(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookListEventTypesResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param int $page Query param
     * @param int $pageSize Query param
     * @param string|null $search Query param
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listEvents(
        string $id,
        int $page,
        int $pageSize,
        ?string $search = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookListEventsResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param Body|BodyShape $body Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $id,
        Body|array $body,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookRotateSecretResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param string $eventType Body param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $id,
        ?string $eventType = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookTestResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param bool $isActive Body param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function toggleStatus(
        string $id,
        ?bool $isActive = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook;
}
