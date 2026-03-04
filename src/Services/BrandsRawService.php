<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Brands\APIResponseBrandWithKYC;
use SentDm\Brands\BrandCreateParams;
use SentDm\Brands\BrandData;
use SentDm\Brands\BrandDeleteParams;
use SentDm\Brands\BrandDeleteParams\Body;
use SentDm\Brands\BrandListResponse;
use SentDm\Brands\BrandUpdateParams;
use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\BrandsRawContract;

/**
 * Register and manage 10DLC brands for SMS compliance.
 *
 * @phpstan-import-type BodyShape from \SentDm\Brands\BrandDeleteParams\Body
 * @phpstan-import-type BrandDataShape from \SentDm\Brands\BrandData
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class BrandsRawService implements BrandsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Creates a new brand and associated information. This endpoint automatically sets inheritTcrBrand=false when a brand is created.
     *
     * @param array{
     *   brand: BrandData|BrandDataShape, testMode?: bool, idempotencyKey?: string
     * }|BrandCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseBrandWithKYC>
     *
     * @throws APIException
     */
    public function create(
        array|BrandCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BrandCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/brands',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseBrandWithKYC::class,
        );
    }

    /**
     * @api
     *
     * Updates an existing brand and its associated information. Cannot update brands that have already been submitted to TCR or inherited brands.
     *
     * @param string $brandID Path param: Brand ID from route
     * @param array{
     *   brand: BrandData|BrandDataShape, testMode?: bool, idempotencyKey?: string
     * }|BrandUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = BrandUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['v3/brands/%1$s', $brandID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseBrandWithKYC::class,
        );
    }

    /**
     * @api
     *
     * Retrieves all brands for the authenticated customer with information in a flattened structure. Includes inherited brands if inheritTcrBrand=true.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BrandListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/brands',
            options: $requestOptions,
            convert: BrandListResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete a brand by ID. The brand must belong to the authenticated customer.
     *
     * @param string $brandID Brand ID from route parameter
     * @param array{body: Body|BodyShape}|BrandDeleteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = BrandDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/brands/%1$s', $brandID],
            headers: ['Content-Type' => '*/*'],
            body: (object) $parsed['body'],
            options: $options,
            convert: null,
        );
    }
}
