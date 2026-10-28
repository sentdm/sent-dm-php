<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Voice;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Voice\Voices\APIResponseOfVoiceCatalogue;
use SentDm\Voice\Voices\VoiceListParams;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface VoicesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|VoiceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceCatalogue>
     *
     * @throws APIException
     */
    public function list(
        array|VoiceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
