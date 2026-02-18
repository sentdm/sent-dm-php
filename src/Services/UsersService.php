<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\UsersContract;
use SentDm\Users\APIResponseOfUser;
use SentDm\Users\UserListResponse;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class UsersService implements UsersContract
{
    /**
     * @api
     */
    public UsersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new UsersRawService($client);
    }

    /**
     * @api
     *
     * Retrieves detailed information about a specific user in an organization or profile. Requires developer role or higher.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): APIResponseOfUser {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($userID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all users who have access to the organization or profile identified by the API key, including their roles and status. Shows invited users (pending acceptance) and active users. Requires developer role or higher.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): UserListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends an invitation to a user to join the organization or profile with a specific role. Requires admin role. The user will receive an invitation email with a token to accept. Invitation tokens expire after 7 days.
     *
     * @param string $email Body param: User email address (required)
     * @param string $name Body param: User full name (required)
     * @param string $role Body param: User role: admin, billing, or developer (required)
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function invite(
        ?string $email = null,
        ?string $name = null,
        ?string $role = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfUser {
        $params = Util::removeNulls(
            [
                'email' => $email,
                'name' => $name,
                'role' => $role,
                'testMode' => $testMode,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->invite(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Removes a user's access to an organization or profile. Requires admin role. You cannot remove yourself or remove the last admin.
     *
     * @param bool $testMode Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $userID User ID from route parameter
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $userID_,
        ?bool $testMode = null,
        ?string $userID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['testMode' => $testMode, 'userID' => $userID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($userID_, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates a user's role in the organization or profile. Requires admin role. You cannot change your own role or demote the last admin.
     *
     * @param string $userID_ Path param
     * @param string $role Body param: User role: admin, billing, or developer (required)
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $userID Body param: User ID from route parameter
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateRole(
        string $userID_,
        ?string $role = null,
        ?bool $testMode = null,
        ?string $userID = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfUser {
        $params = Util::removeNulls(
            [
                'role' => $role,
                'testMode' => $testMode,
                'userID' => $userID,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->updateRole($userID_, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
