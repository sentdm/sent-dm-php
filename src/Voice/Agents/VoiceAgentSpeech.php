<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentSpeechShape = array{
 *   language?: string|null, setting?: string|null, voice?: string|null
 * }
 */
final class VoiceAgentSpeech implements BaseModel
{
    /** @use SdkModel<VoiceAgentSpeechShape> */
    use SdkModel;

    #[Optional]
    public ?string $language;

    #[Optional]
    public ?string $setting;

    #[Optional]
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

    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    public function withSetting(string $setting): self
    {
        $self = clone $this;
        $self['setting'] = $setting;

        return $self;
    }

    public function withVoice(string $voice): self
    {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }
}
