<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Organizations\OrganizationGetProfilesResponse;
use SentDm\Organizations\OrganizationListResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface OrganizationsRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
