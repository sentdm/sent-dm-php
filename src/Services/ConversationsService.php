<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Conversations\ConversationListMessagesResponse;
use SentDm\Conversations\ConversationListResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ConversationsContract;

/**
 * Inbound and outbound messages, grouped by the person they are with.
 *
 * A conversation is the thread for one contact across every channel — a reply by SMS and one by WhatsApp belong to the same conversation, because they are the same person talking to you.
 *
 * Read-only. Sending is **Messages**; a reply arrives here and through your webhooks.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class ConversationsService implements ConversationsContract
{
    /**
     * @api
     */
    public ConversationsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ConversationsRawService($client);
    }

    /**
     * @api
     *
     * Retrieves a paginated list of the authenticated customer's messages across all conversations, ordered by created date (most recent first).
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
    ): ConversationListResponse {
        $params = Util::removeNulls(
            ['page' => $page, 'pageSize' => $pageSize, 'xProfileID' => $xProfileID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves a paginated list of the messages in a single conversation (scoped to the authenticated customer), ordered by created date (most recent first).
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
    ): ConversationListMessagesResponse {
        $params = Util::removeNulls(
            ['page' => $page, 'pageSize' => $pageSize, 'xProfileID' => $xProfileID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listMessages($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
