<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentSpeechSpecShape = array{
 *   language?: string|null, setting?: string|null, voice?: string|null
 * }
 */
final class VoiceAgentSpeechSpec implements BaseModel
{
    /** @use SdkModel<VoiceAgentSpeechSpecShape> */
    use SdkModel;

    /**
     * The language spoken and listened for, a BCP 47 tag from GET /v3/voice/voices. Default en-US.
     */
    #[Optional(nullable: true)]
    public ?string $language;

    /**
     * standard, Sent's speech. Other settings are not available yet.
     */
    #[Optional(nullable: true)]
    public ?string $setting;

    /**
     * A voice name from GET /v3/voice/voices. Default: the catalogue's default voice.
     */
    #[Optional(nullable: true)]
    public ?string $voice;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $language = null,
        ?string $setting = null,
        ?string $voice = null
    ): self {
        $self = new self;

        null !== $language && $self['language'] = $language;
        null !== $setting && $self['setting'] = $setting;
        null !== $voice && $self['voice'] = $voice;

        return $self;
    }

    /**
     * The language spoken and listened for, a BCP 47 tag from GET /v3/voice/voices. Default en-US.
     */
    public function withLanguage(?string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * standard, Sent's speech. Other settings are not available yet.
     */
    public function withSetting(?string $setting): self
    {
        $self = clone $this;
        $self['setting'] = $setting;

        return $self;
    }

    /**
     * A voice name from GET /v3/voice/voices. Default: the catalogue's default voice.
     */
    public function withVoice(?string $voice): self
    {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }
}
