<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentAudioShape = array{sampleRate?: int|null}
 */
final class VoiceAgentAudio implements BaseModel
{
    /** @use SdkModel<VoiceAgentAudioShape> */
    use SdkModel;

    #[Optional('sample_rate')]
    public ?int $sampleRate;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $sampleRate = null): self
    {
        $self = new self;

        null !== $sampleRate && $self['sampleRate'] = $sampleRate;

        return $self;
    }

    public function withSampleRate(int $sampleRate): self
    {
        $self = clone $this;
        $self['sampleRate'] = $sampleRate;

        return $self;
    }
}
