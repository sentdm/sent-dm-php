<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Brands\APIResponseBrandWithKYC;
use SentDm\Brands\BrandData;
use SentDm\Brands\BrandDeleteParams\Body;
use SentDm\Brands\BrandListResponse;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\BrandsContract;
use SentDm\Services\Brands\CampaignsService;

/**
 * Register and manage 10DLC brands for SMS compliance.
 *
 * @phpstan-import-type BodyShape from \SentDm\Brands\BrandDeleteParams\Body
 * @phpstan-import-type BrandDataShape from \SentDm\Brands\BrandData
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class BrandsService implements BrandsContract
{
    /**
     * @api
     */
    public BrandsRawService $raw;

    /**
     * @api
     */
    public CampaignsService $campaigns;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BrandsRawService($client);
        $this->campaigns = new CampaignsService($client);
    }

    /**
     * @api
     *
     * Creates a new brand and associated information. This endpoint automatically sets inheritTcrBrand=false when a brand is created.
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
    ): APIResponseBrandWithKYC {
        $params = Util::removeNulls(
            [
                'brand' => $brand,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates an existing brand and its associated information. Cannot update brands that have already been submitted to TCR or inherited brands.
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
    ): APIResponseBrandWithKYC {
        $params = Util::removeNulls(
            [
                'brand' => $brand,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($brandID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all brands for the authenticated customer with information in a flattened structure. Includes inherited brands if inheritTcrBrand=true.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BrandListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a brand by ID. The brand must belong to the authenticated customer.
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
    ): mixed {
        $params = Util::removeNulls(['body' => $body]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($brandID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
