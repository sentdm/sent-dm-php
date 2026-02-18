<?php

declare(strict_types=1);

namespace SentDm\Services\Brands;

use SentDm\Brands\Campaigns\APIResponseTcrCampaignWithUseCases;
use SentDm\Brands\Campaigns\CampaignData;
use SentDm\Brands\Campaigns\CampaignDeleteParams\Body;
use SentDm\Brands\Campaigns\CampaignListResponse;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Brands\CampaignsContract;

/**
 * @phpstan-import-type BodyShape from \SentDm\Brands\Campaigns\CampaignDeleteParams\Body
 * @phpstan-import-type CampaignDataShape from \SentDm\Brands\Campaigns\CampaignData
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class CampaignsService implements CampaignsContract
{
    /**
     * @api
     */
    public CampaignsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CampaignsRawService($client);
    }

    /**
     * @api
     *
     * Creates a new campaign scoped under a specific brand. The campaign is linked to the specified brand. Each campaign must include at least one use case with sample messages.
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
    ): APIResponseTcrCampaignWithUseCases {
        $params = Util::removeNulls(
            [
                'campaign' => $campaign,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($brandID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates an existing campaign scoped under a specific brand. Cannot update campaigns that have already been submitted to TCR.
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
    ): APIResponseTcrCampaignWithUseCases {
        $params = Util::removeNulls(
            [
                'brandID' => $brandID,
                'campaign' => $campaign,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($campaignID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all campaigns linked to a specific brand, including their use cases and sample messages.
     *
     * @param string $brandID Brand ID from route
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): CampaignListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($brandID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Deletes a campaign by ID within a specific brand. The brand must belong to the authenticated customer.
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
    ): mixed {
        $params = Util::removeNulls(['brandID' => $brandID, 'body' => $body]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($campaignID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
