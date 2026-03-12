<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Profiles;

use SentDm\Core\Exceptions\APIException;
use SentDm\Profiles\Campaigns\APIResponseOfTcrCampaignWithUseCases;
use SentDm\Profiles\Campaigns\CampaignData;
use SentDm\Profiles\Campaigns\CampaignDeleteParams\Body;
use SentDm\Profiles\Campaigns\CampaignListResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type BodyShape from \SentDm\Profiles\Campaigns\CampaignDeleteParams\Body
 * @phpstan-import-type CampaignDataShape from \SentDm\Profiles\Campaigns\CampaignData
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface CampaignsContract
{
    /**
     * @api
     *
     * @param string $profileID Path param: Profile ID from route
     * @param CampaignData|CampaignDataShape $campaign Body param: Campaign data for create or update operation
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
    ): APIResponseOfTcrCampaignWithUseCases;

    /**
     * @api
     *
     * @param string $campaignID Path param: Campaign ID from route
     * @param string $profileID Path param: Profile ID from route
     * @param CampaignData|CampaignDataShape $campaign Body param: Campaign data for create or update operation
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
    ): APIResponseOfTcrCampaignWithUseCases;

    /**
     * @api
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
    ): CampaignListResponse;

    /**
     * @api
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
    ): mixed;
}
