<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels\SMS;

use SentDm\Channels\SMS\APIResponseOfSMSMarket;
use SentDm\Channels\SMS\TenDlc\APIResponseOfSuppliedCompliance;
use SentDm\Channels\SMS\TenDlc\TenDlcAddCampaignParams;
use SentDm\Channels\SMS\TenDlc\TenDlcAddNumbersParams;
use SentDm\Channels\SMS\TenDlc\TenDlcRetrieveComplianceParams;
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
     * @return BaseResponse<APIResponseOfSMSMarket>
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
     * @param array<string,mixed>|TenDlcAddNumbersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSMSMarket>
     *
     * @throws APIException
     */
    public function addNumbers(
        array|TenDlcAddNumbersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TenDlcRetrieveComplianceParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSuppliedCompliance>
     *
     * @throws APIException
     */
    public function retrieveCompliance(
        array|TenDlcRetrieveComplianceParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $campaignID Path param: The campaign: its id in the market's compliance.campaigns.
     * @param array<string,mixed>|TenDlcUpdateCampaignParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSMSMarket>
     *
     * @throws APIException
     */
    public function updateCampaign(
        string $campaignID,
        array|TenDlcUpdateCampaignParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
