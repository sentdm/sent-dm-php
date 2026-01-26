<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Organizations;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Organizations\Users\CustomerUser;
use SentDm\Organizations\Users\UserDeleteParams;
use SentDm\Organizations\Users\UserInviteParams;
use SentDm\Organizations\Users\UserListParams;
use SentDm\Organizations\Users\UserListResponse;
use SentDm\Organizations\Users\UserRetrieveParams;
use SentDm\Organizations\Users\UserUpdateRoleParams;
use SentDm\RequestOptions;

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
     * @return BaseResponse<CustomerUser>
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
        string $customerID,
        array|UserListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $userID,
        array|UserDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserInviteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CustomerUser>
     *
     * @throws APIException
     */
    public function invite(
        string $customerID,
        array|UserInviteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID Path param
     * @param array<string,mixed>|UserUpdateRoleParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CustomerUser>
     *
     * @throws APIException
     */
    public function updateRole(
        string $userID,
        array|UserUpdateRoleParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
