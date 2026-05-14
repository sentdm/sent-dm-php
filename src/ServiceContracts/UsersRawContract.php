<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Users\APIResponseOfUser;
use SentDm\Users\UserInviteParams;
use SentDm\Users\UserListParams;
use SentDm\Users\UserListResponse;
use SentDm\Users\UserRemoveParams;
use SentDm\Users\UserRetrieveParams;
use SentDm\Users\UserUpdateRoleParams;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface UsersRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfUser>
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        array|UserRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|UserListParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     * @param string $userID Path param
     * @param array<string,mixed>|UserRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        array|UserRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID Path param
     * @param array<string,mixed>|UserUpdateRoleParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfUser>
     *
     * @throws APIException
     */
    public function updateRole(
        string $userID,
        array|UserUpdateRoleParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
