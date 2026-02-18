<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Profiles\APIResponseOfProfileDetail;
use SentDm\Profiles\ProfileCompleteParams;
use SentDm\Profiles\ProfileCreateParams;
use SentDm\Profiles\ProfileDeleteParams;
use SentDm\Profiles\ProfileListResponse;
use SentDm\Profiles\ProfileUpdateParams;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ProfilesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ProfileCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfProfileDetail>
     *
     * @throws APIException
     */
    public function create(
        array|ProfileCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfProfileDetail>
     *
     * @throws APIException
     */
    public function retrieve(
        string $profileID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $profileID_ Path param
     * @param array<string,mixed>|ProfileUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfProfileDetail>
     *
     * @throws APIException
     */
    public function update(
        string $profileID_,
        array|ProfileUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ProfileDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $profileID_,
        array|ProfileDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $profileID Path param: Profile ID from route
     * @param array<string,mixed>|ProfileCompleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function complete(
        string $profileID,
        array|ProfileCompleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
