<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\SMS\SMSCreateParams;
use SentDm\Channels\SMS\SMSNewResponse;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface SMSRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SMSCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SMSNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|SMSCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
