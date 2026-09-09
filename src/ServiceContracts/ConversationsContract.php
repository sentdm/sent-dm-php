<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Conversations\APIResponseOfConversationMessagesList;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ConversationsContract
{
    /**
     * @api
     *
     * @param int $page Query param
     * @param int $pageSize Query param
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $page,
        int $pageSize,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfConversationMessagesList;

    /**
     * @api
     *
     * @param string $id path param: Conversation id from the route
     * @param int $page Query param
     * @param int $pageSize Query param
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listMessages(
        string $id,
        int $page,
        int $pageSize,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfConversationMessagesList;
}
