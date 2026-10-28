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
     * @param string $displayName Body param
     * @param string $endpointURL Body param
     * @param array<string,list<string>>|null $eventFilters Body param
     * @param list<string> $eventTypes Body param
     * @param bool $isInheritable Body param: Also delivers every sender profile's events to this webhook, at the same URL and with the same signing
     * secret, and lets each profile see the webhook and read the events about itself. Off by default: the
     * organization's own events only. Only an organization's version 2 webhook can set it.
     * @param int $retryCount Body param: Delivery retries. Applies to version 1 only: Svix retries a version 2 webhook on its own schedule.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param SenderProfile|SenderProfileShape|null $senderProfile Body param: Request-only: the events an organization webhook's sender profile clones receive, one clone per existing
     * and future profile. A version 1 webhook's responses report it as WebhookSenderProfileV3Response.
     * @param int $timeoutSeconds Body param: Delivery timeout. Applies to version 1 only.
     * @param int|null $webhookVersion body param: Who delivers the webhook: 2, the default, is delivered by Svix and signed with the
     * webhook-id, webhook-timestamp and webhook-signature headers; 1 is the older
     * delivery, signed with the X-Webhook-* headers, which will be retired
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventFilters = null,
        ?array $eventTypes = null,
        ?bool $isInheritable = null,
        ?int $retryCount = null,
        ?bool $sandbox = null,
        SenderProfile|array|null $senderProfile = null,
        ?int $timeoutSeconds = null,
        ?int $webhookVersion = null,
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
     * @param array<string,list<string>>|null $eventFilters Body param
     * @param list<string> $eventTypes Body param
     * @param bool|null $isInheritable Body param: Makes this webhook inheritable by the organization's sender profiles (see create), or stops it being
     * inheritable. Omit or pass null to keep it as it is. Only a version 2 webhook can be inheritable.
     * @param int $retryCount Body param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param \SentDm\Webhooks\WebhookUpdateParams\SenderProfile|SenderProfileShape1|null $senderProfile Body param: Request-only: the events an organization webhook's sender profile clones receive, one clone per existing
     * and future profile. A version 1 webhook's responses report it as WebhookSenderProfileV3Response.
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
        ?array $eventFilters = null,
        ?array $eventTypes = null,
        ?bool $isInheritable = null,
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
        ?bool $sandbox = null,
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
