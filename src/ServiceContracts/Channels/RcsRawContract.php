<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\Rcs\APIResponseOfRcsAgent;
use SentDm\Channels\Rcs\RcCreateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface RcsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|RcCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfRcsAgent>
     *
     * @throws APIException
     */
    public function create(
        array|RcCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
