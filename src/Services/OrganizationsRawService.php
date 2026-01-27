<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Organizations\OrganizationGetProfilesResponse;
use SentDm\Organizations\OrganizationListResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\OrganizationsRawContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class OrganizationsRawService implements OrganizationsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieves all organizations that the authenticated user has access to, including the sender profiles within each organization that the user can access. Returns organization details with nested profiles filtered by user permissions.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v2/organizations',
            options: $requestOptions,
            convert: OrganizationListResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieves all sender profiles within an organization that the authenticated user has access to. Returns filtered list based on user's permissions.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationGetProfilesResponse>
     *
     * @throws APIException
     */
    public function retrieveProfiles(
        string $orgID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v2/organizations/%1$s/profiles', $orgID],
            options: $requestOptions,
            convert: OrganizationGetProfilesResponse::class,
        );
    }
}
