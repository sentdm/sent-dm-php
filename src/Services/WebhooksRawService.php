<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\WebhooksRawContract;
use SentDm\Webhooks\APIResponseWebhook;
use SentDm\Webhooks\WebhookCreateParams;
use SentDm\Webhooks\WebhookDeleteParams;
use SentDm\Webhooks\WebhookListEventsParams;
use SentDm\Webhooks\WebhookListEventsResponse;
use SentDm\Webhooks\WebhookListEventTypesParams;
use SentDm\Webhooks\WebhookListEventTypesResponse;
use SentDm\Webhooks\WebhookListParams;
use SentDm\Webhooks\WebhookListResponse;
use SentDm\Webhooks\WebhookRetrieveParams;
use SentDm\Webhooks\WebhookRotateSecretParams;
use SentDm\Webhooks\WebhookRotateSecretParams\Body;
use SentDm\Webhooks\WebhookRotateSecretResponse;
use SentDm\Webhooks\WebhookTestParams;
use SentDm\Webhooks\WebhookTestResponse;
use SentDm\Webhooks\WebhookToggleStatusParams;
use SentDm\Webhooks\WebhookUpdateParams;

/**
 * Configure webhook endpoints for real-time event delivery.
 *
 * @phpstan-import-type BodyShape from \SentDm\Webhooks\WebhookRotateSecretParams\Body
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class WebhooksRawService implements WebhooksRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Creates a new webhook endpoint for the authenticated customer.
     *
     * @param array{
     *   displayName?: string,
     *   endpointURL?: string,
     *   eventFilters?: array<string,list<string>>|null,
     *   eventTypes?: list<string>,
     *   retryCount?: int,
     *   sandbox?: bool,
     *   timeoutSeconds?: int,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|WebhookCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseWebhook>
     *
     * @throws APIException
     */
    public function create(
        array|WebhookCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/webhooks',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseWebhook::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a single webhook by ID for the authenticated customer.
     *
     * @param array{xProfileID?: string}|WebhookRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseWebhook>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|WebhookRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/webhooks/%1$s', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseWebhook::class,
        );
    }

    /**
     * @api
     *
     * Updates an existing webhook for the authenticated customer.
     *
     * @param string $id Path param
     * @param array{
     *   displayName?: string,
     *   endpointURL?: string,
     *   eventFilters?: array<string,list<string>>|null,
     *   eventTypes?: list<string>,
     *   retryCount?: int,
     *   sandbox?: bool,
     *   timeoutSeconds?: int,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|WebhookUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseWebhook>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|WebhookUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['v3/webhooks/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseWebhook::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a paginated list of webhooks for the authenticated customer.
     *
     * @param array{
     *   page: int,
     *   pageSize: int,
     *   isActive?: bool|null,
     *   search?: string|null,
     *   xProfileID?: string,
     * }|WebhookListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|WebhookListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['page', 'pageSize', 'isActive', 'search']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/webhooks',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['pageSize' => 'page_size', 'isActive' => 'is_active'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: WebhookListResponse::class,
        );
    }

    /**
     * @api
     *
     * Deletes a webhook for the authenticated customer.
     *
     * @param array{xProfileID?: string}|WebhookDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|WebhookDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/webhooks/%1$s', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Retrieves all available webhook event types that can be subscribed to.
     *
     * @param array{xProfileID?: string}|WebhookListEventTypesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListEventTypesResponse>
     *
     * @throws APIException
     */
    public function listEventTypes(
        array|WebhookListEventTypesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookListEventTypesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/webhooks/event-types',
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: WebhookListEventTypesResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a paginated list of delivery events for the specified webhook.
     *
     * @param string $id Path param
     * @param array{
     *   page: int, pageSize: int, search?: string|null, xProfileID?: string
     * }|WebhookListEventsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListEventsResponse>
     *
     * @throws APIException
     */
    public function listEvents(
        string $id,
        array|WebhookListEventsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookListEventsParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['page', 'pageSize', 'search']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/webhooks/%1$s/events', $id],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['pageSize' => 'page_size']
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: WebhookListEventsResponse::class,
        );
    }

    /**
     * @api
     *
     * Generates a new signing secret for the specified webhook. The old secret is immediately invalidated.
     *
     * @param string $id Path param
     * @param array{
     *   body: Body|BodyShape, idempotencyKey?: string, xProfileID?: string
     * }|WebhookRotateSecretParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookRotateSecretResponse>
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $id,
        array|WebhookRotateSecretParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookRotateSecretParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/webhooks/%1$s/rotate-secret', $id],
            headers: Util::array_transform_keys(
                array_diff_key($parsed, array_flip(['body'])),
                ['idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id'],
            ),
            body: (object) $parsed['body'],
            options: $options,
            convert: WebhookRotateSecretResponse::class,
        );
    }

    /**
     * @api
     *
     * Sends a test event to the specified webhook endpoint to verify connectivity.
     *
     * @param string $id Path param
     * @param array{
     *   eventType?: string,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|WebhookTestParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookTestResponse>
     *
     * @throws APIException
     */
    public function test(
        string $id,
        array|WebhookTestParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookTestParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/webhooks/%1$s/test', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: WebhookTestResponse::class,
        );
    }

    /**
     * @api
     *
     * Activates or deactivates a webhook for the authenticated customer.
     *
     * @param string $id Path param
     * @param array{
     *   isActive?: bool, sandbox?: bool, idempotencyKey?: string, xProfileID?: string
     * }|WebhookToggleStatusParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseWebhook>
     *
     * @throws APIException
     */
    public function toggleStatus(
        string $id,
        array|WebhookToggleStatusParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookToggleStatusParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v3/webhooks/%1$s/toggle-status', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseWebhook::class,
        );
    }
}
