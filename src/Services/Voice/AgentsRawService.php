<?php

declare(strict_types=1);

namespace SentDm\Services\Voice;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Voice\AgentsRawContract;
use SentDm\Voice\Agents\AgentCreateParams;
use SentDm\Voice\Agents\AgentDeleteParams;
use SentDm\Voice\Agents\AgentListParams;
use SentDm\Voice\Agents\AgentRetrieveParams;
use SentDm\Voice\Agents\AgentRotateSecretParams;
use SentDm\Voice\Agents\AgentUpdateParams;
use SentDm\Voice\Agents\APIResponseOfVoiceAgent;
use SentDm\Voice\Agents\APIResponseOfVoiceAgentSecret;
use SentDm\Voice\Agents\VoiceAgent;
use SentDm\Voice\Agents\VoiceAgentAudioSpec;
use SentDm\Voice\Agents\VoiceAgentLimitsSpec;
use SentDm\Voice\Agents\VoiceAgentPartySpec;
use SentDm\Voice\Agents\VoiceAgentSpeechSpec;
use SentDm\Voice\Agents\VoiceAgentTranscriptsSpec;
use SentDm\VoiceAgentsPage;

/**
 * Phone calls from the numbers you hold, driven by your own callback URL.
 *
 * `POST /v3/channels/voice` enables a number for calls, with the callback URL Sent asks what to do with each call on it, and `POST /v3/voice/tokens` mints a short-lived token that lets a user of your app place and receive calls as that number. When a call arrives or a caller presses a key, a signed question is POSTed to the callback URL and the answer decides the call; `POST /v3/channels/voice/{number}/test` checks the URL answers the way we need before a real call reaches it, and `POST /v3/channels/voice/{number}/rotate-secret` replaces the signing secret. The call events themselves (`call.completed` and the rest) arrive through your webhooks.
 *
 * Every call is a record under `/v3/voice/calls`: read it, list its recordings once one is ready, hang it up, start or stop recording, and add, mute or remove conference participants while it is live. A leg to a phone number runs for at most what your balance affords at the destination's rate.
 *
 * **Voice agents.** `POST /v3/voice/agents` creates an agent that answers calls through the Sent Voice Gateway: `session_type` says whether Sent carries the call as text (speech recognised and spoken for the agent) or as audio, `websocket_url` is where the gateway dials the agent for each call (leave it out and the agent dials in with your API key), and `tools`, `transfer_targets`, `fallback` and `limits` say what it may do on a call. The agent's `signing_secret` is shown on create and on `POST /v3/voice/agents/{id}/rotate-secret` only. Voices and languages for text sessions come from `GET /v3/voice/voices`. A number takes calls to an agent once it is bound to it on `/v3/channels/voice`.
 *
 * @phpstan-import-type VoiceAgentAudioSpecShape from \SentDm\Voice\Agents\VoiceAgentAudioSpec
 * @phpstan-import-type VoiceAgentPartySpecShape from \SentDm\Voice\Agents\VoiceAgentPartySpec
 * @phpstan-import-type VoiceAgentLimitsSpecShape from \SentDm\Voice\Agents\VoiceAgentLimitsSpec
 * @phpstan-import-type VoiceAgentSpeechSpecShape from \SentDm\Voice\Agents\VoiceAgentSpeechSpec
 * @phpstan-import-type VoiceAgentTranscriptsSpecShape from \SentDm\Voice\Agents\VoiceAgentTranscriptsSpec
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class AgentsRawService implements AgentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Creates an agent that answers phone calls through the Sent Voice Gateway. `session_type` says whether Sent carries the call as text (the caller's speech recognised for the agent, the agent's text spoken) or as audio. With `websocket_url` the gateway dials your agent for each call and signs the handshake with the `signing_secret` this response returns; without it, your agent dials in with your API key and this agent's `id`.
     *
     * `tools`, `transfer_targets`, `fallback` and `limits` say what the agent may do on a call. Voices and languages for text sessions come from `GET /v3/voice/voices`. Calls reach the agent once a number is bound to it on `/v3/channels/voice`.
     *
     * `signing_secret` is shown here and on `POST /v3/voice/agents/{id}/rotate-secret` only; store it now. With `sandbox: true` the request is validated and the agent reported with `202`; nothing is written.
     *
     * @param array{
     *   audio?: VoiceAgentAudioSpec|VoiceAgentAudioSpecShape|null,
     *   fallback?: VoiceAgentPartySpec|VoiceAgentPartySpecShape|null,
     *   greeting?: string|null,
     *   limits?: VoiceAgentLimitsSpec|VoiceAgentLimitsSpecShape|null,
     *   name?: string|null,
     *   sandbox?: bool,
     *   sessionType?: string|null,
     *   speech?: VoiceAgentSpeechSpec|VoiceAgentSpeechSpecShape|null,
     *   tools?: list<string>|null,
     *   transcripts?: VoiceAgentTranscriptsSpec|VoiceAgentTranscriptsSpecShape|null,
     *   transferTargets?: list<VoiceAgentPartySpec|VoiceAgentPartySpecShape>|null,
     *   websocketURL?: string|null,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|AgentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceAgent>
     *
     * @throws APIException
     */
    public function create(
        array|AgentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/voice/agents',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfVoiceAgent::class,
        );
    }

    /**
     * @api
     *
     * The agent as stored, without its signing secret.
     *
     * @param string $id The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param array{xProfileID?: string}|AgentRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = AgentRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/voice/agents/%1$s', $id],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseOfVoiceAgent::class,
        );
    }

    /**
     * @api
     *
     * Changes the fields you name and answers with the agent as stored, the same shape `GET` returns.
     *
     * A key left out is left alone. A key sent as `null` clears an optional field (`websocket_url` makes the agent dial in, `greeting` and `fallback` go, `speech`, `audio`, `tools`, `limits` and `transcripts` return to their defaults). A key sent with a value replaces that field whole: send the whole `limits` object, not one of its keys. Changing `session_type` drops `speech`, `audio` and `greeting` unless the body sends them, since the other type cannot carry them. The result is checked like a new agent, and a body that changes nothing is `400`.
     *
     * With `sandbox: true` nothing is written: the request is validated against the stored agent and the agent is reported with `200` as it would read after the change.
     *
     * @param string $id Path param: The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param array{
     *   audio?: VoiceAgentAudioSpec|VoiceAgentAudioSpecShape|null,
     *   fallback?: VoiceAgentPartySpec|VoiceAgentPartySpecShape|null,
     *   greeting?: string|null,
     *   limits?: VoiceAgentLimitsSpec|VoiceAgentLimitsSpecShape|null,
     *   name?: string,
     *   sandbox?: bool,
     *   sessionType?: string,
     *   speech?: VoiceAgentSpeechSpec|VoiceAgentSpeechSpecShape|null,
     *   tools?: list<string>|null,
     *   transcripts?: VoiceAgentTranscriptsSpec|VoiceAgentTranscriptsSpecShape|null,
     *   transferTargets?: list<VoiceAgentPartySpec|VoiceAgentPartySpecShape>|null,
     *   websocketURL?: string|null,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|AgentUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = AgentUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v3/voice/agents/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfVoiceAgent::class,
        );
    }

    /**
     * @api
     *
     * Your voice agents, newest first. `page` and `page_size` (1 to 100, default 20) page the list. Signing secrets are never listed.
     *
     * @param array{
     *   page?: int, pageSize?: int, xProfileID?: string
     * }|AgentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<VoiceAgentsPage<VoiceAgent>>
     *
     * @throws APIException
     */
    public function list(
        array|AgentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['page', 'pageSize']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/voice/agents',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['pageSize' => 'page_size']
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: VoiceAgent::class,
            page: VoiceAgentsPage::class,
        );
    }

    /**
     * @api
     *
     * Removes the agent. Calls it already took keep their `agent_id`.
     *
     * An agent that one of your voice numbers routes to, or that another of your agents lists in `transfer_targets`, is not deleted: the answer is `409` with a message naming those numbers and agents. Unbind the numbers (`PATCH /v3/channels/voice/{number}` with `"agent_id": null`), take the agent out of the others' `transfer_targets` or delete them, and try again.
     *
     * With `sandbox: true` nothing is written: the agent is looked up and the answer is the one a real delete would give.
     *
     * @param string $id Path param: The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param array{sandbox?: bool, xProfileID?: string}|AgentDeleteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = AgentDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['xProfileID' => 'x-profile-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/voice/agents/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Generates a new `signing_secret` for the agent and returns it. The previous secret stops signing immediately, so update your agent before the next call reaches it.
     *
     * With `sandbox: true` a secret is generated and returned with `202`, and nothing is written.
     *
     * @param string $id Path param: The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param array{
     *   sandbox?: bool, idempotencyKey?: string, xProfileID?: string
     * }|AgentRotateSecretParams $params
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
    ): BaseResponse {
        [$parsed, $options] = AgentRotateSecretParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/voice/agents/%1$s/rotate-secret', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfVoiceAgentSecret::class,
        );
    }
}
