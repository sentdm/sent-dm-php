<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Organizations\OrganizationGetProfilesResponse;
use SentDm\Organizations\OrganizationListResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\OrganizationsContract;
use SentDm\Services\Organizations\UsersService;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class OrganizationsService implements OrganizationsContract
{
    /**
     * @api
     */
    public OrganizationsRawService $raw;

    /**
     * @api
     */
    public UsersService $users;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new OrganizationsRawService($client);
        $this->users = new UsersService($client);
    }

    /**
     * @api
     *
     * Retrieves all organizations that the authenticated user has access to, including the sender profiles within each organization that the user can access. Returns organization details with nested profiles filtered by user permissions.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): OrganizationListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all sender profiles within an organization that the authenticated user has access to. Returns filtered list based on user's permissions.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveProfiles(
        string $orgID,
        RequestOptions|array|null $requestOptions = null
    ): OrganizationGetProfilesResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveProfiles($orgID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
