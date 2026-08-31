<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Conversations\ConversationListMessagesParams;
use SentDm\Conversations\ConversationListMessagesResponse;
use SentDm\Conversations\ConversationListParams;
use SentDm\Conversations\ConversationListResponse;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ConversationsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ConversationListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ConversationListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ConversationListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id path param: Conversation id from the route
     * @param array<string,mixed>|ConversationListMessagesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ConversationListMessagesResponse>
     *
     * @throws APIException
     */
    public function listMessages(
        string $id,
        array|ConversationListMessagesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
