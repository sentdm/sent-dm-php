<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\WebhooksContract;
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
 * Delivery reports and inbound messages, pushed to you.
 *
 * Subscribe an endpoint to the event types you care about — `GET /v3/webhooks/event-types` lists them — and we POST each one as it happens, retrying on failure. Polling `GET /v3/messages/{id}` works and does not scale.
 *
 * **Verify the signature.** Every delivery is signed with your endpoint's secret; an unverified endpoint is one anybody can post to. `rotate-secret` replaces it, `test` sends a specimen event, and `GET /v3/webhooks/{id}/events` shows what we tried to deliver and what your endpoint answered — which is the first place to look when something appears to be missing.
 *
 * @phpstan-import-type SenderProfileShape from \SentDm\Webhooks\WebhookCreateParams\SenderProfile
 * @phpstan-import-type SenderProfileShape from \SentDm\Webhooks\WebhookUpdateParams\SenderProfile as SenderProfileShape1
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
     * Creates a new webhook endpoint for the authenticated customer. A webhook is version 2 unless the request sets webhook_version to 1: Svix delivers it, signed with the webhook-id, webhook-timestamp and webhook-signature headers, and retries it on its own schedule, so retry_count and timeout_seconds apply to version 1 only. sender_profile applies to version 1 only and is ignored on version 2; is_inheritable applies to version 2 only. A version 1 webhook's response returns its sender_profile selection, with an empty event_types when it is not cloned onto sender profiles; a version 2 webhook's response leaves sender_profile out.
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
    ): APIResponseWebhook {
        $params = Util::removeNulls(
            [
                'displayName' => $displayName,
                'endpointURL' => $endpointURL,
                'eventFilters' => $eventFilters,
                'eventTypes' => $eventTypes,
                'isInheritable' => $isInheritable,
                'retryCount' => $retryCount,
                'sandbox' => $sandbox,
                'senderProfile' => $senderProfile,
                'timeoutSeconds' => $timeoutSeconds,
                'webhookVersion' => $webhookVersion,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a single webhook by ID for the authenticated customer. A version 1 webhook includes its sender_profile selection.
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
    ): APIResponseWebhook {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates an existing webhook for the authenticated customer. Its version does not change. sender_profile applies to a version 1 webhook and is_inheritable to a version 2 one; retry_count and timeout_seconds apply to version 1 only. A version 1 webhook's response returns its sender_profile selection as saved; a version 2 webhook's response leaves sender_profile out.
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
    ): APIResponseWebhook {
        $params = Util::removeNulls(
            [
                'displayName' => $displayName,
                'endpointURL' => $endpointURL,
                'eventFilters' => $eventFilters,
                'eventTypes' => $eventTypes,
                'isInheritable' => $isInheritable,
                'retryCount' => $retryCount,
                'sandbox' => $sandbox,
                'senderProfile' => $senderProfile,
                'timeoutSeconds' => $timeoutSeconds,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a paginated list of webhooks for the authenticated customer. Each version 1 webhook includes its sender_profile selection.
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
    ): WebhooksPage {
        $params = Util::removeNulls(
            [
                'isActive' => $isActive,
                'page' => $page,
                'pageSize' => $pageSize,
                'search' => $search,
                'xProfileID' => $xProfileID,
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
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all available webhook event types that can be subscribed to.
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listEventTypes(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null
    ): WebhookListEventTypesResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listEventTypes(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a paginated list of delivery events for the specified webhook, newest first. If the webhook is cloned onto your sender profiles (version 1) or inheritable by them (version 2, is_inheritable), the list includes their events; read payload.account_id to tell whose event it is. A sender profile may read its organization's inheritable webhook too, and gets the events about itself.
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
    ): WebhookEventsPage {
        $params = Util::removeNulls(
            [
                'page' => $page,
                'pageSize' => $pageSize,
                'search' => $search,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listEvents($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Generates a new signing secret for the specified webhook. A version 1 webhook's old secret stops verifying at once. A version 2 webhook's deliveries are signed with the new secret at once, and with the old one as well for the next 24 hours, so a receiver can switch over without rejecting any; after that the old secret no longer verifies.
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
    ): WebhookRotateSecretResponse {
        $params = Util::removeNulls(
            [
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->rotateSecret($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends a test event to the specified webhook endpoint to verify connectivity. A version 1 webhook is tested at once and the answer says whether it was delivered; a version 2 webhook's test is queued with Svix, which delivers it right after, and the answer says it was queued.
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
    ): WebhookTestResponse {
        $params = Util::removeNulls(
            [
                'eventType' => $eventType,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
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
    ): APIResponseWebhook {
        $params = Util::removeNulls(
            [
                'isActive' => $isActive,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->toggleStatus($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
