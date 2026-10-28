<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Changes the fields you name and answers with the agent as stored, the same shape `GET` returns.
 *
 * A key left out is left alone. A key sent as `null` clears an optional field (`websocket_url` makes the agent dial in, `greeting` and `fallback` go, `speech`, `audio`, `tools`, `limits` and `transcripts` return to their defaults). A key sent with a value replaces that field whole: send the whole `limits` object, not one of its keys. Changing `session_type` drops `speech`, `audio` and `greeting` unless the body sends them, since the other type cannot carry them. The result is checked like a new agent, and a body that changes nothing is `400`.
 *
 * With `sandbox: true` nothing is written: the request is validated against the stored agent and the agent is reported with `200` as it would read after the change.
 *
 * @see SentDm\Services\Voice\AgentsService::update()
 *
 * @phpstan-import-type VoiceAgentAudioSpecShape from \SentDm\Voice\Agents\VoiceAgentAudioSpec
 * @phpstan-import-type VoiceAgentPartySpecShape from \SentDm\Voice\Agents\VoiceAgentPartySpec
 * @phpstan-import-type VoiceAgentLimitsSpecShape from \SentDm\Voice\Agents\VoiceAgentLimitsSpec
 * @phpstan-import-type VoiceAgentSpeechSpecShape from \SentDm\Voice\Agents\VoiceAgentSpeechSpec
 * @phpstan-import-type VoiceAgentTranscriptsSpecShape from \SentDm\Voice\Agents\VoiceAgentTranscriptsSpec
 *
 * @phpstan-type AgentUpdateParamsShape = array{
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
final class AgentUpdateParams implements BaseModel
{
    /** @use SdkModel<AgentUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Audio sessions: { sample_rate }; null restores the default.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentAudioSpec $audio;

    /**
     * A new fallback party, or null for none.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentPartySpec $fallback;

    /**
     * A new greeting, or null for none.
     */
    #[Optional(nullable: true)]
    public ?string $greeting;

    /**
     * The whole limits object; null restores the defaults.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentLimitsSpec $limits;

    /**
     * A new name, 1 to 100 characters.
     */
    #[Optional]
    public ?string $name;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * text or audio. Changing it drops the settings the other type cannot have (speech, audio, greeting) unless the body sends them.
     */
    #[Optional('session_type')]
    public ?string $sessionType;

    /**
     * Text sessions: { setting, voice, language }, replaced whole; null restores the defaults.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentSpeechSpec $speech;

    /**
     * The whole list of tools; null restores the default.
     *
     * @var list<string>|null $tools
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $tools;

    /**
     * The whole transcripts object; null restores the defaults.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentTranscriptsSpec $transcripts;

    /**
     * The whole list of parties; null clears it.
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
     * A new wss:// URL, or null for an agent that dials in.
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
     * Audio sessions: { sample_rate }; null restores the default.
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
     * A new fallback party, or null for none.
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
     * A new greeting, or null for none.
     */
    public function withGreeting(?string $greeting): self
    {
        $self = clone $this;
        $self['greeting'] = $greeting;

        return $self;
    }

    /**
     * The whole limits object; null restores the defaults.
     *
     * @param VoiceAgentLimitsSpec|VoiceAgentLimitsSpecShape|null $limits
     */
    public function withLimits(VoiceAgentLimitsSpec|array|null $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }

    /**
     * A new name, 1 to 100 characters.
     */
    public function withName(string $name): self
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
     * text or audio. Changing it drops the settings the other type cannot have (speech, audio, greeting) unless the body sends them.
     */
    public function withSessionType(string $sessionType): self
    {
        $self = clone $this;
        $self['sessionType'] = $sessionType;

        return $self;
    }

    /**
     * Text sessions: { setting, voice, language }, replaced whole; null restores the defaults.
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
     * The whole list of tools; null restores the default.
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
     * The whole transcripts object; null restores the defaults.
     *
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
     * The whole list of parties; null clears it.
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
     * A new wss:// URL, or null for an agent that dials in.
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
