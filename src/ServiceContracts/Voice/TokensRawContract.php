<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Voice;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Voice\Tokens\APIResponseOfVoiceToken;
use SentDm\Voice\Tokens\TokenCreateParams;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface TokensRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TokenCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceToken>
     *
     * @throws APIException
     */
    public function create(
        array|TokenCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
