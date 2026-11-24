<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels\SMS;

use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\SMS\TenDlc\TenDlcAddCampaignParams;
use SentDm\Channels\SMS\TenDlc\TenDlcListCampaignsParams;
use SentDm\Channels\SMS\TenDlc\TenDlcListCampaignsResponse;
use SentDm\Channels\SMS\TenDlc\TenDlcUpdateCampaignParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface TenDlcRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TenDlcAddCampaignParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelMarket>
     *
     * @throws APIException
     */
    public function addCampaign(
        array|TenDlcAddCampaignParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TenDlcListCampaignsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TenDlcListCampaignsResponse>
     *
     * @throws APIException
     */
    public function listCampaigns(
        array|TenDlcListCampaignsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID Path param: The campaign: its id in the market's compliance.campaigns.
     * @param array<string,mixed>|TenDlcUpdateCampaignParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelMarket>
     *
     * @throws APIException
     */
    public function updateCampaign(
        string $campaignID,
        array|TenDlcUpdateCampaignParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
