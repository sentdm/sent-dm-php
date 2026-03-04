<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\UsersRawContract;
use SentDm\Users\APIResponseOfUser;
use SentDm\Users\UserInviteParams;
use SentDm\Users\UserListResponse;
use SentDm\Users\UserRemoveParams;
use SentDm\Users\UserUpdateRoleParams;

/**
 * Invite, update, and manage organization users and roles.
 *
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
     * Retrieves detailed information about a specific user in an organization or profile. Requires developer role or higher.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/users/%1$s', $userID],
            options: $requestOptions,
            convert: APIResponseOfUser::class,
        );
    }

    /**
     * @api
     *
     * Retrieves all users who have access to the organization or profile identified by the API key, including their roles and status. Shows invited users (pending acceptance) and active users. Requires developer role or higher.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/users',
            options: $requestOptions,
            convert: UserListResponse::class,
        );
    }

    /**
     * @api
     *
     * Sends an invitation to a user to join the organization or profile with a specific role. Requires admin role. The user will receive an invitation email with a token to accept. Invitation tokens expire after 7 days.
     *
     * @param array{
     *   email?: string,
     *   name?: string,
     *   role?: string,
     *   testMode?: bool,
     *   idempotencyKey?: string,
     * }|UserInviteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfUser>
     *
     * @throws APIException
     */
    public function invite(
        array|UserInviteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserInviteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/users',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfUser::class,
        );
    }

    /**
     * @api
     *
     * Removes a user's access to an organization or profile. Requires admin role. You cannot remove yourself or remove the last admin.
     *
     * @param array{testMode?: bool, userID?: string}|UserRemoveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/users/%1$s', $userID_],
            headers: ['Content-Type' => '*/*'],
            body: (object) $parsed,
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Updates a user's role in the organization or profile. Requires admin role. You cannot change your own role or demote the last admin.
     *
     * @param string $userID_ Path param
     * @param array{
     *   role?: string, testMode?: bool, userID?: string, idempotencyKey?: string
     * }|UserUpdateRoleParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserUpdateRoleParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v3/users/%1$s', $userID_],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfUser::class,
        );
    }
}
