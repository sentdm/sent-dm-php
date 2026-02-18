<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Users\APIResponseOfUser;
use SentDm\Users\UserListResponse;

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
        RequestOptions|array|null $requestOptions = null
    ): APIResponseOfUser;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): UserListResponse;

    /**
     * @api
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
    ): APIResponseOfUser;

    /**
     * @api
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
    ): mixed;

    /**
     * @api
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
    ): APIResponseOfUser;
}
