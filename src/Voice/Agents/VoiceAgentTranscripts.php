<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentTranscriptsShape = array{
 *   retentionDays?: int|null, store?: bool|null
 * }
 */
final class VoiceAgentTranscripts implements BaseModel
{
    /** @use SdkModel<VoiceAgentTranscriptsShape> */
    use SdkModel;

    #[Optional('retention_days')]
    public ?int $retentionDays;

    #[Optional]
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

    public function withRetentionDays(int $retentionDays): self
    {
        $self = clone $this;
        $self['retentionDays'] = $retentionDays;

        return $self;
    }

    public function withStore(bool $store): self
    {
        $self = clone $this;
        $self['store'] = $store;

        return $self;
    }
}
