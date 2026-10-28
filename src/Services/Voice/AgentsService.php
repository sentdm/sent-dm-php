<?php

declare(strict_types=1);

namespace SentDm\Services\Voice;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Voice\AgentsContract;
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
final class AgentsService implements AgentsContract
{
    /**
     * @api
     */
    public AgentsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AgentsRawService($client);
    }

    /**
     * @api
     *
     * Creates an agent that answers phone calls through the Sent Voice Gateway. `session_type` says whether Sent carries the call as text (the caller's speech recognised for the agent, the agent's text spoken) or as audio. With `websocket_url` the gateway dials your agent for each call and signs the handshake with the `signing_secret` this response returns; without it, your agent dials in with your API key and this agent's `id`.
     *
     * `tools`, `transfer_targets`, `fallback` and `limits` say what the agent may do on a call. Voices and languages for text sessions come from `GET /v3/voice/voices`. Calls reach the agent once a number is bound to it on `/v3/channels/voice`.
     *
     * `signing_secret` is shown here and on `POST /v3/voice/agents/{id}/rotate-secret` only; store it now. With `sandbox: true` the request is validated and the agent reported with `202`; nothing is written.
     *
     * @param VoiceAgentAudioSpec|VoiceAgentAudioSpecShape|null $audio body param: Audio sessions only: the sound format
     * @param VoiceAgentPartySpec|VoiceAgentPartySpecShape|null $fallback Body param: Who takes the call when the agent cannot: a phone number (kind: number). Omit it and such a
     * call hangs up.
     * @param string|null $greeting Body param: Text sessions only: what the caller hears as soon as the call is answered, before the agent's first
     * turn. 1 to 4,096 characters. Omit it and the agent speaks first.
     * @param VoiceAgentLimitsSpec|VoiceAgentLimitsSpecShape|null $limits Body param
     * @param string|null $name body param: A name for your own reference, 1 to 100 characters
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $sessionType Body param: text: Sent turns the caller's speech into text and the agent's text into speech, so the agent
     * exchanges text frames. audio: the agent receives and sends the sound itself.
     * @param VoiceAgentSpeechSpec|VoiceAgentSpeechSpecShape|null $speech body param: Text sessions only: how the caller is spoken to and listened to
     * @param list<string>|null $tools Body param: What the agent may do to the call: any of transfer, hangup, send_dtmf and
     * hold. Default ["hangup"]. transfer needs at least one transfer_targets entry.
     * @param VoiceAgentTranscriptsSpec|VoiceAgentTranscriptsSpecShape|null $transcripts Body param
     * @param list<VoiceAgentPartySpec|VoiceAgentPartySpecShape>|null $transferTargets Body param: Where the agent may transfer a call to, up to 20 parties: a phone number (kind: number, E.164),
     * one of your app users (kind: user, the identity) or another of your agents (kind: agent,
     * its id). The agent can only transfer to a party listed here.
     * @param string|null $websocketURL Body param: Where the gateway connects to the agent for each call: an absolute wss:// URL on a public host,
     * at most 2,048 characters. The handshake is signed with the agent's signing_secret. Leave it out
     * and the agent dials in instead, connecting to the gateway with your API key.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        VoiceAgentAudioSpec|array|null $audio = null,
        VoiceAgentPartySpec|array|null $fallback = null,
        ?string $greeting = null,
        VoiceAgentLimitsSpec|array|null $limits = null,
        ?string $name = null,
        ?bool $sandbox = null,
        ?string $sessionType = null,
        VoiceAgentSpeechSpec|array|null $speech = null,
        ?array $tools = null,
        VoiceAgentTranscriptsSpec|array|null $transcripts = null,
        ?array $transferTargets = null,
        ?string $websocketURL = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceAgent {
        $params = Util::removeNulls(
            [
                'audio' => $audio,
                'fallback' => $fallback,
                'greeting' => $greeting,
                'limits' => $limits,
                'name' => $name,
                'sandbox' => $sandbox,
                'sessionType' => $sessionType,
                'speech' => $speech,
                'tools' => $tools,
                'transcripts' => $transcripts,
                'transferTargets' => $transferTargets,
                'websocketURL' => $websocketURL,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The agent as stored, without its signing secret.
     *
     * @param string $id The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceAgent {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param VoiceAgentAudioSpec|VoiceAgentAudioSpecShape|null $audio body param: Audio sessions: { sample_rate }; null restores the default
     * @param VoiceAgentPartySpec|VoiceAgentPartySpecShape|null $fallback body param: A new fallback party, or null for none
     * @param string|null $greeting body param: A new greeting, or null for none
     * @param VoiceAgentLimitsSpec|VoiceAgentLimitsSpecShape|null $limits body param: The whole limits object; null restores the defaults
     * @param string $name body param: A new name, 1 to 100 characters
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $sessionType Body param: text or audio. Changing it drops the settings the other type cannot have (speech, audio, greeting) unless the body sends them.
     * @param VoiceAgentSpeechSpec|VoiceAgentSpeechSpecShape|null $speech body param: Text sessions: { setting, voice, language }, replaced whole; null restores the defaults
     * @param list<string>|null $tools body param: The whole list of tools; null restores the default
     * @param VoiceAgentTranscriptsSpec|VoiceAgentTranscriptsSpecShape|null $transcripts body param: The whole transcripts object; null restores the defaults
     * @param list<VoiceAgentPartySpec|VoiceAgentPartySpecShape>|null $transferTargets body param: The whole list of parties; null clears it
     * @param string|null $websocketURL body param: A new wss:// URL, or null for an agent that dials in
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        VoiceAgentAudioSpec|array|null $audio = null,
        VoiceAgentPartySpec|array|null $fallback = null,
        ?string $greeting = null,
        VoiceAgentLimitsSpec|array|null $limits = null,
        ?string $name = null,
        ?bool $sandbox = null,
        ?string $sessionType = null,
        VoiceAgentSpeechSpec|array|null $speech = null,
        ?array $tools = null,
        VoiceAgentTranscriptsSpec|array|null $transcripts = null,
        ?array $transferTargets = null,
        ?string $websocketURL = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceAgent {
        $params = Util::removeNulls(
            [
                'audio' => $audio,
                'fallback' => $fallback,
                'greeting' => $greeting,
                'limits' => $limits,
                'name' => $name,
                'sandbox' => $sandbox,
                'sessionType' => $sessionType,
                'speech' => $speech,
                'tools' => $tools,
                'transcripts' => $transcripts,
                'transferTargets' => $transferTargets,
                'websocketURL' => $websocketURL,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Your voice agents, newest first. `page` and `page_size` (1 to 100, default 20) page the list. Signing secrets are never listed.
     *
     * @param int $page Query param: Page number, from 1
     * @param int $pageSize Query param
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @return VoiceAgentsPage<VoiceAgent>
     *
     * @throws APIException
     */
    public function list(
        ?int $page = null,
        ?int $pageSize = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): VoiceAgentsPage {
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
     * Removes the agent. Calls it already took keep their `agent_id`.
     *
     * An agent that one of your voice numbers routes to, or that another of your agents lists in `transfer_targets`, is not deleted: the answer is `409` with a message naming those numbers and agents. Unbind the numbers (`PATCH /v3/channels/voice/{number}` with `"agent_id": null`), take the agent out of the others' `transfer_targets` or delete them, and try again.
     *
     * With `sandbox: true` nothing is written: the agent is looked up and the answer is the one a real delete would give.
     *
     * @param string $id Path param: The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            ['sandbox' => $sandbox, 'xProfileID' => $xProfileID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Generates a new `signing_secret` for the agent and returns it. The previous secret stops signing immediately, so update your agent before the next call reaches it.
     *
     * With `sandbox: true` a secret is generated and returned with `202`, and nothing is written.
     *
     * @param string $id Path param: The agent id, such as agent_9f2ab000-0000-4000-8000-000000000001
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $id,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceAgentSecret {
        $params = Util::removeNulls(
            [
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->rotateSecret($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
