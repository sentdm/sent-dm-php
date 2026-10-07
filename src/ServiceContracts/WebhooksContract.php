<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\WebhookEventsPage;
use SentDm\Webhooks\APIResponseWebhook;
use SentDm\Webhooks\WebhookCreateParams\SenderProfile;
use SentDm\Webhooks\WebhookListEventsResponse;
use SentDm\Webhooks\WebhookListEventTypesResponse;
use SentDm\Webhooks\WebhookResponse;
use SentDm\Webhooks\WebhookRotateSecretResponse;
use SentDm\Webhooks\WebhookTestResponse;
use SentDm\WebhooksPage;

/**
 * @phpstan-import-type SenderProfileShape from \SentDm\Webhooks\WebhookCreateParams\SenderProfile
 * @phpstan-import-type SenderProfileShape from \SentDm\Webhooks\WebhookUpdateParams\SenderProfile as SenderProfileShape1
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface WebhooksContract
{
    /**
     * @api
     *
     * @param string $apiKey Body param: API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     * @param string $displayName Body param
     * @param string $endpointURL Body param
     * @param array<string,list<string>>|null $eventFilters Body param
     * @param list<string> $eventTypes Body param
     * @param int $retryCount Body param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param SenderProfile|SenderProfileShape|null $senderProfile Body param: Request-only: the events an organization webhook's sender profile clones receive, one clone per existing
     * and future profile. Responses never return it.
     * @param int $timeoutSeconds Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $apiKey = null,
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventFilters = null,
        ?array $eventTypes = null,
        ?int $retryCount = null,
        ?bool $sandbox = null,
        SenderProfile|array|null $senderProfile = null,
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
     * @param string $apiKey Body param: API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     * @param string $displayName Body param
     * @param string $endpointURL Body param
     * @param array<string,list<string>>|null $eventFilters Body param
     * @param list<string> $eventTypes Body param
     * @param int $retryCount Body param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param \SentDm\Webhooks\WebhookUpdateParams\SenderProfile|SenderProfileShape1|null $senderProfile Body param: Request-only: the events an organization webhook's sender profile clones receive, one clone per existing
     * and future profile. Responses never return it.
     * @param int $timeoutSeconds Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?string $apiKey = null,
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventFilters = null,
        ?array $eventTypes = null,
        ?int $retryCount = null,
        ?bool $sandbox = null,
        \SentDm\Webhooks\WebhookUpdateParams\SenderProfile|array|null $senderProfile = null,
        ?int $timeoutSeconds = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook;

    /**
     * @api
     *
     * @param bool|null $isActive Query param
     * @param int $page Query param
     * @param int $pageSize Query param
     * @param string|null $search Query param
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @return WebhooksPage<WebhookResponse>
     *
     * @throws APIException
     */
    public function list(
        ?bool $isActive = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?string $search = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhooksPage;

    /**
     * @api
     *
     * @param string $id Path param
     * @param string $apiKey Body param: API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        ?string $apiKey = null,
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
     * @return WebhookEventsPage<WebhookListEventsResponse>
     *
     * @throws APIException
     */
    public function listEvents(
        string $id,
        ?int $page = null,
        ?int $pageSize = null,
        ?string $search = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookEventsPage;

    /**
     * @api
     *
     * @param string $id Path param
     * @param string $apiKey Body param: API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $id,
        ?string $apiKey = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookRotateSecretResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param string $apiKey Body param: API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
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
        ?string $apiKey = null,
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
     * @param string $apiKey Body param: API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
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
        ?string $apiKey = null,
        ?bool $isActive = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseWebhook;
}
