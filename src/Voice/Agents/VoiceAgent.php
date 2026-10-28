<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A voice agent as stored: what was written with every default filled in, plus the signing secret the one
 * time it is shown (on create, and on rotate). The one shape every read of an agent answers with, on
 * /v3/voice/agents and on the admin API the dashboard uses, so the two cannot drift.
 *
 * @phpstan-import-type VoiceAgentAudioShape from \SentDm\Voice\Agents\VoiceAgentAudio
 * @phpstan-import-type VoiceAgentPartyShape from \SentDm\Voice\Agents\VoiceAgentParty
 * @phpstan-import-type VoiceAgentLimitsShape from \SentDm\Voice\Agents\VoiceAgentLimits
 * @phpstan-import-type VoiceAgentSpeechShape from \SentDm\Voice\Agents\VoiceAgentSpeech
 * @phpstan-import-type VoiceAgentTranscriptsShape from \SentDm\Voice\Agents\VoiceAgentTranscripts
 *
 * @phpstan-type VoiceAgentShape = array{
 *   id?: string|null,
 *   audio?: null|VoiceAgentAudio|VoiceAgentAudioShape,
 *   createdAt?: \DateTimeInterface|null,
 *   fallback?: null|VoiceAgentParty|VoiceAgentPartyShape,
 *   greeting?: string|null,
 *   limits?: null|VoiceAgentLimits|VoiceAgentLimitsShape,
 *   name?: string|null,
 *   sessionType?: string|null,
 *   signingSecret?: string|null,
 *   speech?: null|VoiceAgentSpeech|VoiceAgentSpeechShape,
 *   tools?: list<string>|null,
 *   transcripts?: null|VoiceAgentTranscripts|VoiceAgentTranscriptsShape,
 *   transferTargets?: list<VoiceAgentParty|VoiceAgentPartyShape>|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   websocketURL?: string|null,
 * }
 */
final class VoiceAgent implements BaseModel
{
    /** @use SdkModel<VoiceAgentShape> */
    use SdkModel;

    /**
     * The agent's id, agent_ and a UUID. It is also what the agent connects to the gateway as.
     */
    #[Optional]
    public ?string $id;

    /**
     * Audio sessions: the sample rate in use.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentAudio $audio;

    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    #[Optional(nullable: true)]
    public ?VoiceAgentParty $fallback;

    #[Optional(nullable: true)]
    public ?string $greeting;

    #[Optional]
    public ?VoiceAgentLimits $limits;

    #[Optional]
    public ?string $name;

    /**
     * text or audio.
     */
    #[Optional('session_type')]
    public ?string $sessionType;

    /**
     * The whsec_ secret the gateway signs its handshake to websocket_url with. Present on
     * create and after a rotate-secret; absent on every other read. Store it now.
     */
    #[Optional('signing_secret', nullable: true)]
    public ?string $signingSecret;

    /**
     * Text sessions: the speech setting, voice and language in use.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgentSpeech $speech;

    /** @var list<string>|null $tools */
    #[Optional(list: 'string')]
    public ?array $tools;

    #[Optional]
    public ?VoiceAgentTranscripts $transcripts;

    /** @var list<VoiceAgentParty>|null $transferTargets */
    #[Optional('transfer_targets', list: VoiceAgentParty::class)]
    public ?array $transferTargets;

    #[Optional('updated_at', nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Where the gateway dials the agent; null when the agent dials in with your API key.
     */
    #[Optional('websocket_url', nullable: true)]
    public ?string $websocketURL;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param VoiceAgentAudio|VoiceAgentAudioShape|null $audio
     * @param VoiceAgentParty|VoiceAgentPartyShape|null $fallback
     * @param VoiceAgentLimits|VoiceAgentLimitsShape|null $limits
     * @param VoiceAgentSpeech|VoiceAgentSpeechShape|null $speech
     * @param list<string>|null $tools
     * @param VoiceAgentTranscripts|VoiceAgentTranscriptsShape|null $transcripts
     * @param list<VoiceAgentParty|VoiceAgentPartyShape>|null $transferTargets
     */
    public static function with(
        ?string $id = null,
        VoiceAgentAudio|array|null $audio = null,
        ?\DateTimeInterface $createdAt = null,
        VoiceAgentParty|array|null $fallback = null,
        ?string $greeting = null,
        VoiceAgentLimits|array|null $limits = null,
        ?string $name = null,
        ?string $sessionType = null,
        ?string $signingSecret = null,
        VoiceAgentSpeech|array|null $speech = null,
        ?array $tools = null,
        VoiceAgentTranscripts|array|null $transcripts = null,
        ?array $transferTargets = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $websocketURL = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $audio && $self['audio'] = $audio;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $fallback && $self['fallback'] = $fallback;
        null !== $greeting && $self['greeting'] = $greeting;
        null !== $limits && $self['limits'] = $limits;
        null !== $name && $self['name'] = $name;
        null !== $sessionType && $self['sessionType'] = $sessionType;
        null !== $signingSecret && $self['signingSecret'] = $signingSecret;
        null !== $speech && $self['speech'] = $speech;
        null !== $tools && $self['tools'] = $tools;
        null !== $transcripts && $self['transcripts'] = $transcripts;
        null !== $transferTargets && $self['transferTargets'] = $transferTargets;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $websocketURL && $self['websocketURL'] = $websocketURL;

        return $self;
    }

    /**
     * The agent's id, agent_ and a UUID. It is also what the agent connects to the gateway as.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Audio sessions: the sample rate in use.
     *
     * @param VoiceAgentAudio|VoiceAgentAudioShape|null $audio
     */
    public function withAudio(VoiceAgentAudio|array|null $audio): self
    {
        $self = clone $this;
        $self['audio'] = $audio;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * @param VoiceAgentParty|VoiceAgentPartyShape|null $fallback
     */
    public function withFallback(VoiceAgentParty|array|null $fallback): self
    {
        $self = clone $this;
        $self['fallback'] = $fallback;

        return $self;
    }

    public function withGreeting(?string $greeting): self
    {
        $self = clone $this;
        $self['greeting'] = $greeting;

        return $self;
    }

    /**
     * @param VoiceAgentLimits|VoiceAgentLimitsShape $limits
     */
    public function withLimits(VoiceAgentLimits|array $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * text or audio.
     */
    public function withSessionType(string $sessionType): self
    {
        $self = clone $this;
        $self['sessionType'] = $sessionType;

        return $self;
    }

    /**
     * The whsec_ secret the gateway signs its handshake to websocket_url with. Present on
     * create and after a rotate-secret; absent on every other read. Store it now.
     */
    public function withSigningSecret(?string $signingSecret): self
    {
        $self = clone $this;
        $self['signingSecret'] = $signingSecret;

        return $self;
    }

    /**
     * Text sessions: the speech setting, voice and language in use.
     *
     * @param VoiceAgentSpeech|VoiceAgentSpeechShape|null $speech
     */
    public function withSpeech(VoiceAgentSpeech|array|null $speech): self
    {
        $self = clone $this;
        $self['speech'] = $speech;

        return $self;
    }

    /**
     * @param list<string> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param VoiceAgentTranscripts|VoiceAgentTranscriptsShape $transcripts
     */
    public function withTranscripts(
        VoiceAgentTranscripts|array $transcripts
    ): self {
        $self = clone $this;
        $self['transcripts'] = $transcripts;

        return $self;
    }

    /**
     * @param list<VoiceAgentParty|VoiceAgentPartyShape> $transferTargets
     */
    public function withTransferTargets(array $transferTargets): self
    {
        $self = clone $this;
        $self['transferTargets'] = $transferTargets;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Where the gateway dials the agent; null when the agent dials in with your API key.
     */
    public function withWebsocketURL(?string $websocketURL): self
    {
        $self = clone $this;
        $self['websocketURL'] = $websocketURL;

        return $self;
    }
}
