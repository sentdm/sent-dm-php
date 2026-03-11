<?php

declare(strict_types=1);

namespace SentDm\Services\Profiles;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Profiles\Campaigns\APIResponseOfTcrCampaignWithUseCases;
use SentDm\Profiles\Campaigns\CampaignData;
use SentDm\Profiles\Campaigns\CampaignDeleteParams\Body;
use SentDm\Profiles\Campaigns\CampaignListResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Profiles\CampaignsContract;

/**
 * Manage organization profiles.
 *
 * @phpstan-import-type BodyShape from \SentDm\Profiles\Campaigns\CampaignDeleteParams\Body
 * @phpstan-import-type CampaignDataShape from \SentDm\Profiles\Campaigns\CampaignData
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
     * Creates a new campaign scoped under the brand of the specified profile. Each campaign must include at least one use case with sample messages.
     *
     * @param string $profileID Path param: Profile ID from route
     * @param CampaignData|CampaignDataShape $campaign Body param: Campaign data
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $profileID,
        CampaignData|array $campaign,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfTcrCampaignWithUseCases {
        $params = Util::removeNulls(
            [
                'campaign' => $campaign,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($profileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates an existing campaign under the brand of the specified profile. Cannot update campaigns that have already been submitted to TCR.
     *
     * @param string $campaignID Path param: Campaign ID from route
     * @param string $profileID Path param: Profile ID from route
     * @param CampaignData|CampaignDataShape $campaign Body param: Campaign data
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $campaignID,
        string $profileID,
        CampaignData|array $campaign,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfTcrCampaignWithUseCases {
        $params = Util::removeNulls(
            [
                'profileID' => $profileID,
                'campaign' => $campaign,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($campaignID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all campaigns linked to the profile's brand, including use cases and sample messages. Returns inherited campaigns if inherit_tcr_campaign=true.
     *
     * @param string $profileID Profile ID from route
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $profileID,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): CampaignListResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($profileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Deletes a campaign by ID from the brand of the specified profile. The profile must belong to the authenticated organization.
     *
     * @param string $campaignID Path param: Campaign ID from route parameter
     * @param string $profileID Path param: Profile ID from route parameter
     * @param Body|BodyShape $body Body param: Request to delete a campaign from a brand
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $campaignID,
        string $profileID,
        Body|array $body,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            ['profileID' => $profileID, 'body' => $body, 'xProfileID' => $xProfileID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($campaignID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
