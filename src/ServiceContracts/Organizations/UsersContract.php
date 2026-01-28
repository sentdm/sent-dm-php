<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Organizations;

use SentDm\Core\Exceptions\APIException;
use SentDm\Organizations\Users\CustomerUser;
use SentDm\Organizations\Users\UserListResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface UsersContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        string $customerID,
        RequestOptions|array|null $requestOptions = null,
    ): CustomerUser;

    /**
     * @api
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
    ): UserListResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $userID,
        string $customerID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
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
    ): CustomerUser;

    /**
     * @api
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
    ): CustomerUser;
}
