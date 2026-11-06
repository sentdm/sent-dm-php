<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Channels\APIResponseOfChannelsState;
use SentDm\Channels\ChannelListParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ChannelsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ChannelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelsState>
     *
     * @throws APIException
     */
    public function list(
        array|ChannelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
