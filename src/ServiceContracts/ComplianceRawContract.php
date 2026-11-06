<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Compliance\APIResponseOfComplianceRequirements;
use SentDm\Compliance\ComplianceRetrieveRequirementsParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ComplianceRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ComplianceRetrieveRequirementsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfComplianceRequirements>
     *
     * @throws APIException
     */
    public function retrieveRequirements(
        array|ComplianceRetrieveRequirementsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
