<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\SMS\APIResponseOfListOfSMSMarket;
use SentDm\Channels\SMS\APIResponseOfSMSMarket;
use SentDm\Channels\SMS\SMSCreateParams;
use SentDm\Channels\SMS\SMSListParams;
use SentDm\Channels\SMS\SMSRetrieveParams;
use SentDm\Channels\SMS\SMSUpdateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface SMSRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SMSCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSMSMarket>
     *
     * @throws APIException
     */
    public function create(
        array|SMSCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $type Path param: Sender type: local, mobile, 10dlc (or ten_dlc), toll_free, short_code, alphanumeric. Matched ignoring case.
     * @param array<string,mixed>|SMSRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSMSMarket>
     *
     * @throws APIException
     */
    public function retrieve(
        string $type,
        array|SMSRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $type Path param: Sender type, e.g. 10dlc (or ten_dlc), local or alphanumeric. Only 10dlc in us declares compliance values.
     * @param array<string,mixed>|SMSUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSMSMarket>
     *
     * @throws APIException
     */
    public function update(
        string $type,
        array|SMSUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SMSListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfListOfSMSMarket>
     *
     * @throws APIException
     */
    public function list(
        array|SMSListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
