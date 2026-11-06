<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\SenderProfiles\APIResponseOfSenderProfile;
use SentDm\SenderProfiles\SenderProfile;
use SentDm\SenderProfiles\SenderProfileCreateParams;
use SentDm\SenderProfiles\SenderProfileListParams;
use SentDm\SenderProfiles\SenderProfileUpdateParams;
use SentDm\SenderProfilesPage;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface SenderProfilesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SenderProfileCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSenderProfile>
     *
     * @throws APIException
     */
    public function create(
        array|SenderProfileCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id identifier of the profile, as returned by POST /v3/sender-profiles
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSenderProfile>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param
     * @param array<string,mixed>|SenderProfileUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfSenderProfile>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|SenderProfileUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderProfileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SenderProfilesPage<SenderProfile>>
     *
     * @throws APIException
     */
    public function list(
        array|SenderProfileListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id identifier of the profile
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
