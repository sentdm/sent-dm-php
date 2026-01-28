<?php

declare(strict_types=1);

namespace SentDm\Services\Organizations;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Organizations\Users\CustomerUser;
use SentDm\Organizations\Users\UserListResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Organizations\UsersContract;

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
     * Retrieves a specific user by their ID. Requires appropriate permissions. The customerId can be either an organization ID or a profile ID.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        string $customerID,
        RequestOptions|array|null $requestOptions = null,
    ): CustomerUser {
        $params = Util::removeNulls(['customerID' => $customerID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all users associated with an organization or sender profile. Requires appropriate permissions. Supports pagination.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $customerID,
        int $page,
        int $pageSize,
        RequestOptions|array|null $requestOptions = null,
    ): UserListResponse {
        $params = Util::removeNulls(['page' => $page, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($customerID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Removes a user from an organization or sender profile. Requires admin permissions. This action permanently deletes the user association.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $userID,
        string $customerID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['customerID' => $customerID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Invites a user to an organization or sender profile with a specified role. Requires appropriate permissions. The customerId can be either an organization ID or a profile ID.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function invite(
        string $customerID,
        ?string $email = null,
        ?string $invitedBy = null,
        ?string $name = null,
        ?string $role = null,
        RequestOptions|array|null $requestOptions = null,
    ): CustomerUser {
        $params = Util::removeNulls(
            [
                'email' => $email,
                'invitedBy' => $invitedBy,
                'name' => $name,
                'role' => $role,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->invite($customerID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Updates a user's role within an organization or sender profile. Requires admin permissions. Valid roles are: admin, billing, developer.
     *
     * @param string $userID Path param
     * @param string $customerID Path param
     * @param string $role Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateRole(
        string $userID,
        string $customerID,
        ?string $role = null,
        RequestOptions|array|null $requestOptions = null,
    ): CustomerUser {
        $params = Util::removeNulls(['customerID' => $customerID, 'role' => $role]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->updateRole($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
