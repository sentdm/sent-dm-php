<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\NumberLookup\NumberLookupGetResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface NumberLookupContract
{
    /**
     * @api
     *
     * @param string $phoneNumber Query param
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $phoneNumber,
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): NumberLookupGetResponse;
}
