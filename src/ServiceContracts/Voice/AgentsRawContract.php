<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Voice;

use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\Voice\Agents\AgentCreateParams;
use SentDm\Voice\Agents\AgentDeleteParams;
use SentDm\Voice\Agents\AgentListParams;
use SentDm\Voice\Agents\AgentRetrieveParams;
use SentDm\Voice\Agents\AgentRotateSecretParams;
use SentDm\Voice\Agents\AgentUpdateParams;
use SentDm\Voice\Agents\APIResponseOfVoiceAgent;
use SentDm\Voice\Agents\APIResponseOfVoiceAgentSecret;
use SentDm\Voice\Agents\VoiceAgent;
use SentDm\VoiceAgentsPage;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface AgentsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AgentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceAgent>
     *
     * @throws APIException
     */
    public function create(
        array|AgentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|AgentRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceAgent>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|AgentRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|AgentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceAgent>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|AgentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AgentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<VoiceAgentsPage<VoiceAgent>>
     *
     * @throws APIException
     */
    public function list(
        array|AgentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|AgentDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|AgentDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param array<string,mixed>|AgentRotateSecretParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceAgentSecret>
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $id,
        array|AgentRotateSecretParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
