<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Brands\APIResponseBrandWithKYC;
use SentDm\Brands\BrandCreateParams;
use SentDm\Brands\BrandDeleteParams;
use SentDm\Brands\BrandListResponse;
use SentDm\Brands\BrandUpdateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface BrandsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|BrandCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseBrandWithKYC>
     *
     * @throws APIException
     */
    public function create(
        array|BrandCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $brandID Path param: Brand ID from route
     * @param array<string,mixed>|BrandUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseBrandWithKYC>
     *
     * @throws APIException
     */
    public function update(
        string $brandID,
        array|BrandUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $brandID Brand ID from route parameter
     * @param array<string,mixed>|BrandDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $brandID,
        array|BrandDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
