<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Profiles\ProfileCompleteParams;
use SentDm\Profiles\ProfileCompleteResponse;
use SentDm\Profiles\ProfileCreateParams;
use SentDm\Profiles\ProfileDeleteParams;
use SentDm\Profiles\ProfileGetResponse;
use SentDm\Profiles\ProfileListParams;
use SentDm\Profiles\ProfileListResponse;
use SentDm\Profiles\ProfileNewResponse;
use SentDm\Profiles\ProfileRetrieveParams;
use SentDm\Profiles\ProfileUpdateParams;
use SentDm\Profiles\ProfileUpdateResponse;
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
     * @return BaseResponse<ProfileNewResponse>
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
     * @param array<string,mixed>|ProfileRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $profileID,
        array|ProfileRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $profileID Path param
     * @param array<string,mixed>|ProfileUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $profileID,
        array|ProfileUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ProfileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ProfileListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $profileID Path param
     * @param array<string,mixed>|ProfileDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $profileID,
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
     * @return BaseResponse<ProfileCompleteResponse>
     *
     * @throws APIException
     */
    public function complete(
        string $profileID,
        array|ProfileCompleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
