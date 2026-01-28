<?php

declare(strict_types=1);

namespace SentDm\Services\Organizations;

use SentDm\Client;
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
use SentDm\ServiceContracts\Organizations\UsersRawContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class UsersRawService implements UsersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieves a specific user by their ID. Requires appropriate permissions. The customerId can be either an organization ID or a profile ID.
     *
     * @param array{customerID: string}|UserRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $customerID = $parsed['customerID'];
        unset($parsed['customerID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v2/organizations/%1$s/users/%2$s', $customerID, $userID],
            options: $options,
            convert: CustomerUser::class,
        );
    }

    /**
     * @api
     *
     * Retrieves all users associated with an organization or sender profile. Requires appropriate permissions. Supports pagination.
     *
     * @param array{page: int, pageSize: int}|UserListParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v2/organizations/%1$s/users', $customerID],
            query: $parsed,
            options: $options,
            convert: UserListResponse::class,
        );
    }

    /**
     * @api
     *
     * Removes a user from an organization or sender profile. Requires admin permissions. This action permanently deletes the user association.
     *
     * @param array{customerID: string}|UserDeleteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $customerID = $parsed['customerID'];
        unset($parsed['customerID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v2/organizations/%1$s/users/%2$s', $customerID, $userID],
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Invites a user to an organization or sender profile with a specified role. Requires appropriate permissions. The customerId can be either an organization ID or a profile ID.
     *
     * @param array{
     *   email?: string, invitedBy?: string|null, name?: string, role?: string
     * }|UserInviteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserInviteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v2/organizations/%1$s/users', $customerID],
            body: (object) $parsed,
            options: $options,
            convert: CustomerUser::class,
        );
    }

    /**
     * @api
     *
     * Updates a user's role within an organization or sender profile. Requires admin permissions. Valid roles are: admin, billing, developer.
     *
     * @param string $userID Path param
     * @param array{customerID: string, role?: string}|UserUpdateRoleParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserUpdateRoleParams::parseRequest(
            $params,
            $requestOptions,
        );
        $customerID = $parsed['customerID'];
        unset($parsed['customerID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['v2/organizations/%1$s/users/%2$s', $customerID, $userID],
            body: (object) array_diff_key($parsed, array_flip(['customerID'])),
            options: $options,
            convert: CustomerUser::class,
        );
    }
}
