<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Calls\APIResponseOfCall;
use SentDm\Calls\APIResponseOfCallRecordings;
use SentDm\Calls\Call;
use SentDm\Calls\CallHangupParams;
use SentDm\Calls\CallListParams;
use SentDm\Calls\CallListRecordingsParams;
use SentDm\Calls\CallRecordParams;
use SentDm\Calls\CallRetrieveParams;
use SentDm\CallsPage;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface CallsRawContract
{
    /**
     * @api
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|CallRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfCall>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|CallRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CallListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CallsPage<Call>>
     *
     * @throws APIException
     */
    public function list(
        array|CallListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|CallHangupParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function hangup(
        string $id,
        array|CallHangupParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|CallListRecordingsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfCallRecordings>
     *
     * @throws APIException
     */
    public function listRecordings(
        string $id,
        array|CallListRecordingsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The call id from the route, as carried by call webhooks and the calls list, for example call_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|CallRecordParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function record(
        string $id,
        array|CallRecordParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
