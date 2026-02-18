<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Brands;

use SentDm\Brands\Campaigns\APIResponseTcrCampaignWithUseCases;
use SentDm\Brands\Campaigns\CampaignData;
use SentDm\Brands\Campaigns\CampaignDeleteParams\Body;
use SentDm\Brands\Campaigns\CampaignListResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type BodyShape from \SentDm\Brands\Campaigns\CampaignDeleteParams\Body
 * @phpstan-import-type CampaignDataShape from \SentDm\Brands\Campaigns\CampaignData
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface CampaignsContract
{
    /**
     * @api
     *
     * @param string $brandID Path param: Brand ID from route
     * @param CampaignData|CampaignDataShape $campaign Body param: Campaign data
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $brandID,
        CampaignData|array $campaign,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseTcrCampaignWithUseCases;

    /**
     * @api
     *
     * @param string $campaignID Path param: Campaign ID from route
     * @param string $brandID Path param: Brand ID from route
     * @param CampaignData|CampaignDataShape $campaign Body param: Campaign data
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $campaignID,
        string $brandID,
        CampaignData|array $campaign,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseTcrCampaignWithUseCases;

    /**
     * @api
     *
     * @param string $brandID Brand ID from route
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): CampaignListResponse;

    /**
     * @api
     *
     * @param string $campaignID Path param: Campaign ID from route parameter
     * @param string $brandID Path param: Brand ID from route parameter
     * @param Body|BodyShape $body Body param: Request to delete a campaign from a brand
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $campaignID,
        string $brandID,
        Body|array $body,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
