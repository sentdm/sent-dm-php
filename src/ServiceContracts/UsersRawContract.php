<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Users\APIResponseOfUser;
use SentDm\Users\UserInviteParams;
use SentDm\Users\UserListResponse;
use SentDm\Users\UserRemoveParams;
use SentDm\Users\UserUpdateRoleParams;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface UsersRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfUser>
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserInviteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfUser>
     *
     * @throws APIException
     */
    public function invite(
        array|UserInviteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function remove(
        string $userID_,
        array|UserRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID_ Path param
     * @param array<string,mixed>|UserUpdateRoleParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfUser>
     *
     * @throws APIException
     */
    public function updateRole(
        string $userID_,
        array|UserUpdateRoleParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
