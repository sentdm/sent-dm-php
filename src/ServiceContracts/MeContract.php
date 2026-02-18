<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\Me\MeGetResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface MeContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): MeGetResponse;
}
