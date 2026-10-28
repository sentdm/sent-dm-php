<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentTranscriptsSpecShape = array{
 *   retentionDays?: int|null, store?: bool|null
 * }
 */
final class VoiceAgentTranscriptsSpec implements BaseModel
{
    /** @use SdkModel<VoiceAgentTranscriptsSpecShape> */
    use SdkModel;

    /**
     * How long a stored transcript is kept, 1 to 365 days. Default 30.
     */
    #[Optional('retention_days', nullable: true)]
    public ?int $retentionDays;

    /**
     * Whether Sent keeps the call's transcript. Default false. Stored now, applied when transcripts land.
     */
    #[Optional(nullable: true)]
    public ?bool $store;

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
        ?int $retentionDays = null,
        ?bool $store = null
    ): self {
        $self = new self;

        null !== $retentionDays && $self['retentionDays'] = $retentionDays;
        null !== $store && $self['store'] = $store;

        return $self;
    }

    /**
     * How long a stored transcript is kept, 1 to 365 days. Default 30.
     */
    public function withRetentionDays(?int $retentionDays): self
    {
        $self = clone $this;
        $self['retentionDays'] = $retentionDays;

        return $self;
    }

    /**
     * Whether Sent keeps the call's transcript. Default false. Stored now, applied when transcripts land.
     */
    public function withStore(?bool $store): self
    {
        $self = clone $this;
        $self['store'] = $store;

        return $self;
    }
}
