<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates an agent that answers phone calls through the Sent Voice Gateway. `session_type` says whether Sent carries the call as text (the caller's speech recognised for the agent, the agent's text spoken) or as audio. With `websocket_url` the gateway dials your agent for each call and signs the handshake with the `signing_secret` this response returns; without it, your agent dials in with your API key and this agent's `id`.
 *
 * `tools`, `transfer_targets`, `fallback` and `limits` say what the agent may do on a call. Voices and languages for text sessions come from `GET /v3/voice/voices`. Calls reach the agent once a number is bound to it on `/v3/channels/voice`.
 *
 * `signing_secret` is shown here and on `POST /v3/voice/agents/{id}/rotate-secret` only; store it now. With `sandbox: true` the request is validated and the agent reported with `202`; nothing is written.
 *
 * @see SentDm\Services\Voice\AgentsService::create()
 *
 * @phpstan-import-type VoiceAgentAudioSpecShape from \SentDm\Voice\Agents\VoiceAgentAudioSpec
 * @phpstan-import-type VoiceAgentPartySpecShape from \SentDm\Voice\Agents\VoiceAgentPartySpec
 * @phpstan-import-type VoiceAgentLimitsSpecShape from \SentDm\Voice\Agents\VoiceAgentLimitsSpec
 * @phpstan-import-type VoiceAgentSpeechSpecShape from \SentDm\Voice\Agents\VoiceAgentSpeechSpec
 * @phpstan-import-type VoiceAgentTranscriptsSpecShape from \SentDm\Voice\Agents\VoiceAgentTranscriptsSpec
 *
 * @phpstan-type AgentCreateParamsShape = array{
 *   audio?: null|VoiceAgentAudioSpec|VoiceAgentAudioSpecShape,
 *   fallback?: null|VoiceAgentPartySpec|VoiceAgentPartySpecShape,
 *   greeting?: string|null,
 *   limits?: null|VoiceAgentLimitsSpec|VoiceAgentLimitsSpecShape,
 *   name?: string|null,
 *   sandbox?: bool|null,
 *   sessionType?: string|null,
 *   speech?: null|VoiceAgentSpeechSpec|VoiceAgentSpeechSpecShape,
 *   tools?: list<string>|null,
 *   transcripts?: null|VoiceAgentTranscriptsSpec|VoiceAgentTranscriptsSpecShape,
 *   transferTargets?: list<VoiceAgentPartySpec|VoiceAgentPartySpecShape>|null,
 *   websocketURL?: string|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class AgentCreateParams implements BaseModel
{
    /** @use SdkModel<AgentCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Audio sessions only: the sound format.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentAudioSpec $audio;

    /**
     * Who takes the call when the agent cannot: a phone number (kind: number). Omit it and such a
     * call hangs up.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentPartySpec $fallback;

    /**
     * Text sessions only: what the caller hears as soon as the call is answered, before the agent's first
     * turn. 1 to 4,096 characters. Omit it and the agent speaks first.
     */
    #[Optional(nullable: true)]
    public ?string $greeting;

    #[Optional(nullable: true)]
    public ?VoiceAgentLimitsSpec $limits;

    /**
     * A name for your own reference, 1 to 100 characters.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * text: Sent turns the caller's speech into text and the agent's text into speech, so the agent
     * exchanges text frames. audio: the agent receives and sends the sound itself.
     */
    #[Optional('session_type', nullable: true)]
    public ?string $sessionType;

    /**
     * Text sessions only: how the caller is spoken to and listened to.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentSpeechSpec $speech;

    /**
     * What the agent may do to the call: any of transfer, hangup, send_dtmf and
     * hold. Default ["hangup"]. transfer needs at least one transfer_targets entry.
     *
     * @var list<string>|null $tools
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $tools;

    #[Optional(nullable: true)]
    public ?VoiceAgentTranscriptsSpec $transcripts;

    /**
     * Where the agent may transfer a call to, up to 20 parties: a phone number (kind: number, E.164),
     * one of your app users (kind: user, the identity) or another of your agents (kind: agent,
     * its id). The agent can only transfer to a party listed here.
     *
     * @var list<VoiceAgentPartySpec>|null $transferTargets
     */
    #[Optional(
        'transfer_targets',
        list: VoiceAgentPartySpec::class,
        nullable: true
    )]
    public ?array $transferTargets;

    /**
     * Where the gateway connects to the agent for each call: an absolute wss:// URL on a public host,
     * at most 2,048 characters. The handshake is signed with the agent's signing_secret. Leave it out
     * and the agent dials in instead, connecting to the gateway with your API key.
     */
    #[Optional('websocket_url', nullable: true)]
    public ?string $websocketURL;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param VoiceAgentAudioSpec|VoiceAgentAudioSpecShape|null $audio
     * @param VoiceAgentPartySpec|VoiceAgentPartySpecShape|null $fallback
     * @param VoiceAgentLimitsSpec|VoiceAgentLimitsSpecShape|null $limits
     * @param VoiceAgentSpeechSpec|VoiceAgentSpeechSpecShape|null $speech
     * @param list<string>|null $tools
     * @param VoiceAgentTranscriptsSpec|VoiceAgentTranscriptsSpecShape|null $transcripts
     * @param list<VoiceAgentPartySpec|VoiceAgentPartySpecShape>|null $transferTargets
     */
    public static function with(
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
    ): self {
        $self = new self;

        null !== $audio && $self['audio'] = $audio;
        null !== $fallback && $self['fallback'] = $fallback;
        null !== $greeting && $self['greeting'] = $greeting;
        null !== $limits && $self['limits'] = $limits;
        null !== $name && $self['name'] = $name;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $sessionType && $self['sessionType'] = $sessionType;
        null !== $speech && $self['speech'] = $speech;
        null !== $tools && $self['tools'] = $tools;
        null !== $transcripts && $self['transcripts'] = $transcripts;
        null !== $transferTargets && $self['transferTargets'] = $transferTargets;
        null !== $websocketURL && $self['websocketURL'] = $websocketURL;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Audio sessions only: the sound format.
     *
     * @param VoiceAgentAudioSpec|VoiceAgentAudioSpecShape|null $audio
     */
    public function withAudio(VoiceAgentAudioSpec|array|null $audio): self
    {
        $self = clone $this;
        $self['audio'] = $audio;

        return $self;
    }

    /**
     * Who takes the call when the agent cannot: a phone number (kind: number). Omit it and such a
     * call hangs up.
     *
     * @param VoiceAgentPartySpec|VoiceAgentPartySpecShape|null $fallback
     */
    public function withFallback(VoiceAgentPartySpec|array|null $fallback): self
    {
        $self = clone $this;
        $self['fallback'] = $fallback;

        return $self;
    }

    /**
     * Text sessions only: what the caller hears as soon as the call is answered, before the agent's first
     * turn. 1 to 4,096 characters. Omit it and the agent speaks first.
     */
    public function withGreeting(?string $greeting): self
    {
        $self = clone $this;
        $self['greeting'] = $greeting;

        return $self;
    }

    /**
     * @param VoiceAgentLimitsSpec|VoiceAgentLimitsSpecShape|null $limits
     */
    public function withLimits(VoiceAgentLimitsSpec|array|null $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }

    /**
     * A name for your own reference, 1 to 100 characters.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    /**
     * text: Sent turns the caller's speech into text and the agent's text into speech, so the agent
     * exchanges text frames. audio: the agent receives and sends the sound itself.
     */
    public function withSessionType(?string $sessionType): self
    {
        $self = clone $this;
        $self['sessionType'] = $sessionType;

        return $self;
    }

    /**
     * Text sessions only: how the caller is spoken to and listened to.
     *
     * @param VoiceAgentSpeechSpec|VoiceAgentSpeechSpecShape|null $speech
     */
    public function withSpeech(VoiceAgentSpeechSpec|array|null $speech): self
    {
        $self = clone $this;
        $self['speech'] = $speech;

        return $self;
    }

    /**
     * What the agent may do to the call: any of transfer, hangup, send_dtmf and
     * hold. Default ["hangup"]. transfer needs at least one transfer_targets entry.
     *
     * @param list<string>|null $tools
     */
    public function withTools(?array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param VoiceAgentTranscriptsSpec|VoiceAgentTranscriptsSpecShape|null $transcripts
     */
    public function withTranscripts(
        VoiceAgentTranscriptsSpec|array|null $transcripts
    ): self {
        $self = clone $this;
        $self['transcripts'] = $transcripts;

        return $self;
    }

    /**
     * Where the agent may transfer a call to, up to 20 parties: a phone number (kind: number, E.164),
     * one of your app users (kind: user, the identity) or another of your agents (kind: agent,
     * its id). The agent can only transfer to a party listed here.
     *
     * @param list<VoiceAgentPartySpec|VoiceAgentPartySpecShape>|null $transferTargets
     */
    public function withTransferTargets(?array $transferTargets): self
    {
        $self = clone $this;
        $self['transferTargets'] = $transferTargets;

        return $self;
    }

    /**
     * Where the gateway connects to the agent for each call: an absolute wss:// URL on a public host,
     * at most 2,048 characters. The handshake is signed with the agent's signing_secret. Leave it out
     * and the agent dials in instead, connecting to the gateway with your API key.
     */
    public function withWebsocketURL(?string $websocketURL): self
    {
        $self = clone $this;
        $self['websocketURL'] = $websocketURL;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
