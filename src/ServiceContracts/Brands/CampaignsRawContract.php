<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Brands;

use SentDm\Brands\Campaigns\APIResponseTcrCampaignWithUseCases;
use SentDm\Brands\Campaigns\CampaignCreateParams;
use SentDm\Brands\Campaigns\CampaignDeleteParams;
use SentDm\Brands\Campaigns\CampaignListResponse;
use SentDm\Brands\Campaigns\CampaignUpdateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface CampaignsRawContract
{
    /**
     * @api
     *
     * @param string $brandID Path param: Brand ID from route
     * @param array<string,mixed>|CampaignCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTcrCampaignWithUseCases>
     *
     * @throws APIException
     */
    public function create(
        string $brandID,
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
     * @return BaseResponse<APIResponseTcrCampaignWithUseCases>
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
     * @param string $brandID Brand ID from route
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
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
