<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Webhooks\APIResponseWebhook;
use SentDm\Webhooks\WebhookCreateParams;
use SentDm\Webhooks\WebhookListEventsParams;
use SentDm\Webhooks\WebhookListEventsResponse;
use SentDm\Webhooks\WebhookListEventTypesResponse;
use SentDm\Webhooks\WebhookListParams;
use SentDm\Webhooks\WebhookListResponse;
use SentDm\Webhooks\WebhookRotateSecretParams;
use SentDm\Webhooks\WebhookRotateSecretResponse;
use SentDm\Webhooks\WebhookTestParams;
use SentDm\Webhooks\WebhookTestResponse;
use SentDm\Webhooks\WebhookToggleStatusParams;
use SentDm\Webhooks\WebhookUpdateParams;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface WebhooksRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|WebhookCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseWebhook>
     *
     * @throws APIException
     */
    public function create(
        array|WebhookCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseWebhook>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param array<string,mixed>|WebhookUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WebhookListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|WebhookListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListEventTypesResponse>
     *
     * @throws APIException
     */
    public function listEventTypes(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WebhookListEventsParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param array<string,mixed>|WebhookRotateSecretParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param array<string,mixed>|WebhookTestParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param array<string,mixed>|WebhookToggleStatusParams $params
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
    ): BaseResponse;
}
