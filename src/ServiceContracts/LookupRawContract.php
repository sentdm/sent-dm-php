<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Lookup\LookupGetPhoneInfoResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface LookupRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LookupGetPhoneInfoResponse>
     *
     * @throws APIException
     */
    public function retrievePhoneInfo(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
