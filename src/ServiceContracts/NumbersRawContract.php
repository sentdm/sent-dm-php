<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Numbers\NumberLookupParams;
use SentDm\Numbers\NumberLookupResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface NumbersRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|NumberLookupParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<NumberLookupResponse>
     *
     * @throws APIException
     */
    public function lookup(
        string $phoneNumber,
        array|NumberLookupParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
