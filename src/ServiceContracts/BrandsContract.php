<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Brands\APIResponseBrandWithKYC;
use SentDm\Brands\BrandData;
use SentDm\Brands\BrandDeleteParams\Body;
use SentDm\Brands\BrandListResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type BodyShape from \SentDm\Brands\BrandDeleteParams\Body
 * @phpstan-import-type BrandDataShape from \SentDm\Brands\BrandData
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface BrandsContract
{
    /**
     * @api
     *
     * @param BrandData|BrandDataShape $brand Body param: Brand and KYC information
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        BrandData|array $brand,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseBrandWithKYC;

    /**
     * @api
     *
     * @param string $brandID Path param: Brand ID from route
     * @param BrandData|BrandDataShape $brand Body param: Brand and KYC information
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $brandID,
        BrandData|array $brand,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseBrandWithKYC;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BrandListResponse;

    /**
     * @api
     *
     * @param string $brandID Brand ID from route parameter
     * @param Body|BodyShape $body Request to delete a brand
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $brandID,
        Body|array $body,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
