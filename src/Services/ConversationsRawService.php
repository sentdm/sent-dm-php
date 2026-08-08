<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Conversations\APIResponseOfConversationMessagesList;
use SentDm\Conversations\ConversationListMessagesParams;
use SentDm\Conversations\ConversationListParams;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ConversationsRawContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class ConversationsRawService implements ConversationsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieves a paginated list of the authenticated customer's messages across all conversations, ordered by created date (most recent first).
     *
     * @param array{
     *   page: int, pageSize: int, xProfileID?: string
     * }|ConversationListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfConversationMessagesList>
     *
     * @throws APIException
     */
    public function list(
        array|ConversationListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ConversationListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['page', 'pageSize']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/conversations',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['pageSize' => 'page_size']
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseOfConversationMessagesList::class,
        );
    }

    /**
     * @api
     *
     * Retrieves a paginated list of the messages in a single conversation (scoped to the authenticated customer), ordered by created date (most recent first).
     *
     * @param string $id path param: Conversation id from the route
     * @param array{
     *   page: int, pageSize: int, xProfileID?: string
     * }|ConversationListMessagesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfConversationMessagesList>
     *
     * @throws APIException
     */
    public function listMessages(
        string $id,
        array|ConversationListMessagesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ConversationListMessagesParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['page', 'pageSize']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/conversations/%1$s', $id],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['pageSize' => 'page_size']
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseOfConversationMessagesList::class,
        );
    }
}
