<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\Markets\APIResponseOfListOfChannelMarket;
use SentDm\Channels\Markets\APIResponseOfMarketNumbers;
use SentDm\Channels\Markets\MarketAddNumbersParams;
use SentDm\Channels\Markets\MarketListNumbersParams;
use SentDm\Channels\Markets\MarketListParams;
use SentDm\Channels\Markets\MarketReplaceNumbersParams;
use SentDm\Channels\Markets\MarketRetrieveParams;
use SentDm\Channels\Markets\MarketUpdateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface MarketsRawContract
{
    /**
     * @api
     *
     * @param string $type Path param: Sender type: local, mobile, 10dlc (or ten_dlc), toll_free, short_code, alphanumeric. Matched ignoring case.
     * @param array<string,mixed>|MarketRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelMarket>
     *
     * @throws APIException
     */
    public function retrieve(
        string $type,
        array|MarketRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $type Path param: Sender type, e.g. 10dlc (or ten_dlc), local or alphanumeric. Only 10dlc in us declares a brand.
     * @param array<string,mixed>|MarketUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelMarket>
     *
     * @throws APIException
     */
    public function update(
        string $type,
        array|MarketUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $channel The channel: `sms`. Other channels are `501` until they have markets
     * @param array<string,mixed>|MarketListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfListOfChannelMarket>
     *
     * @throws APIException
     */
    public function list(
        string $channel,
        array|MarketListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`) or `local`
     * @param array<string,mixed>|MarketAddNumbersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelMarket>
     *
     * @throws APIException
     */
    public function addNumbers(
        string $type,
        array|MarketAddNumbersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`), `local`, `mobile`, `toll_free`, `short_code`, `alphanumeric`
     * @param array<string,mixed>|MarketListNumbersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfMarketNumbers>
     *
     * @throws APIException
     */
    public function listNumbers(
        string $type,
        array|MarketListNumbersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`) or `local`
     * @param array<string,mixed>|MarketReplaceNumbersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelMarket>
     *
     * @throws APIException
     */
    public function replaceNumbers(
        string $type,
        array|MarketReplaceNumbersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
