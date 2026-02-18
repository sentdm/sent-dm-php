<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Messages\MessageGetActivitiesResponse;
use SentDm\Messages\MessageGetStatusResponse;
use SentDm\Messages\MessageSendParams;
use SentDm\Messages\MessageSendResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface MessagesRawContract
{
    /**
     * @api
     *
     * @param string $id Message ID from route parameter
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageGetActivitiesResponse>
     *
     * @throws APIException
     */
    public function retrieveActivities(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Message ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageGetStatusResponse>
     *
     * @throws APIException
     */
    public function retrieveStatus(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MessageSendParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageSendResponse>
     *
     * @throws APIException
     */
    public function send(
        array|MessageSendParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
