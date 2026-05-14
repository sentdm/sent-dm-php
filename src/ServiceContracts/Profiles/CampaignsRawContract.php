<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Profiles;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Profiles\Campaigns\CampaignCreateParams;
use SentDm\Profiles\Campaigns\CampaignDeleteParams;
use SentDm\Profiles\Campaigns\CampaignListParams;
use SentDm\Profiles\Campaigns\CampaignListResponse;
use SentDm\Profiles\Campaigns\CampaignNewResponse;
use SentDm\Profiles\Campaigns\CampaignUpdateParams;
use SentDm\Profiles\Campaigns\CampaignUpdateResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface CampaignsRawContract
{
    /**
     * @api
     *
     * @param string $profileID Path param: Profile ID from route
     * @param array<string,mixed>|CampaignCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $profileID,
        array|CampaignCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID Path param: Campaign ID from route
     * @param array<string,mixed>|CampaignUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $campaignID,
        array|CampaignUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $profileID Profile ID from route
     * @param array<string,mixed>|CampaignListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $profileID,
        array|CampaignListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID Path param: Campaign ID from route parameter
     * @param array<string,mixed>|CampaignDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $campaignID,
        array|CampaignDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
