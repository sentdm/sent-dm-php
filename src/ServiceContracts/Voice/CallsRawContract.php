<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Voice;

use SentDm\CallsPage;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Voice\Calls\APIResponseOfCall;
use SentDm\Voice\Calls\APIResponseOfCallRecordings;
use SentDm\Voice\Calls\Call;
use SentDm\Voice\Calls\CallHangupParams;
use SentDm\Voice\Calls\CallListParams;
use SentDm\Voice\Calls\CallListRecordingsParams;
use SentDm\Voice\Calls\CallRecordParams;
use SentDm\Voice\Calls\CallRetrieveParams;

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
