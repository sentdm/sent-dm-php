<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentAudioSpecShape = array{sampleRate?: int|null}
 */
final class VoiceAgentAudioSpec implements BaseModel
{
    /** @use SdkModel<VoiceAgentAudioSpecShape> */
    use SdkModel;

    /**
     * Samples per second of the audio exchanged: 8000, 16000 or 24000. Default 16000.
     */
    #[Optional('sample_rate', nullable: true)]
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

    /**
     * Samples per second of the audio exchanged: 8000, 16000 or 24000. Default 16000.
     */
    public function withSampleRate(?int $sampleRate): self
    {
        $self = clone $this;
        $self['sampleRate'] = $sampleRate;

        return $self;
    }
}
