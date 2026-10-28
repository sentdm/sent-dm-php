<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Voice;

use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
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
 * @phpstan-import-type VoiceAgentAudioSpecShape from \SentDm\Voice\Agents\VoiceAgentAudioSpec
 * @phpstan-import-type VoiceAgentPartySpecShape from \SentDm\Voice\Agents\VoiceAgentPartySpec
 * @phpstan-import-type VoiceAgentLimitsSpecShape from \SentDm\Voice\Agents\VoiceAgentLimitsSpec
 * @phpstan-import-type VoiceAgentSpeechSpecShape from \SentDm\Voice\Agents\VoiceAgentSpeechSpec
 * @phpstan-import-type VoiceAgentTranscriptsSpecShape from \SentDm\Voice\Agents\VoiceAgentTranscriptsSpec
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface AgentsContract
{
    /**
     * @api
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
    ): APIResponseOfVoiceAgent;

    /**
     * @api
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
    ): APIResponseOfVoiceAgent;

    /**
     * @api
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
    ): APIResponseOfVoiceAgent;

    /**
     * @api
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
    ): VoiceAgentsPage;

    /**
     * @api
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
    ): mixed;

    /**
     * @api
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
    ): APIResponseOfVoiceAgentSecret;
}
