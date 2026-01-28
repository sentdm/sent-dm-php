<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\NumberLookup\NumberLookupGetResponse;
use SentDm\NumberLookup\NumberLookupRetrieveParams;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface NumberLookupRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|NumberLookupRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<NumberLookupGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        array|NumberLookupRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
