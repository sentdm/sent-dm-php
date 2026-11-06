<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\Whatsapp\APIResponseOfWhatsappChannel;
use SentDm\Channels\Whatsapp\WhatsappCreateParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface WhatsappRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|WhatsappCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfWhatsappChannel>
     *
     * @throws APIException
     */
    public function create(
        array|WhatsappCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
