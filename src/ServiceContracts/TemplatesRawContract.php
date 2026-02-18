<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Templates\APIResponseTemplate;
use SentDm\Templates\TemplateCreateParams;
use SentDm\Templates\TemplateDeleteParams;
use SentDm\Templates\TemplateListParams;
use SentDm\Templates\TemplateListResponse;
use SentDm\Templates\TemplateUpdateParams;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface TemplatesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TemplateCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTemplate>
     *
     * @throws APIException
     */
    public function create(
        array|TemplateCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Template ID from route parameter
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTemplate>
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
     * @param string $id Path param: Template ID from route parameter
     * @param array<string,mixed>|TemplateUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTemplate>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|TemplateUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TemplateListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TemplateListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|TemplateListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Template ID from route parameter
     * @param array<string,mixed>|TemplateDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|TemplateDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
