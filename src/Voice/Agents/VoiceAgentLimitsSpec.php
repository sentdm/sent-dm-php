<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentLimitsSpecShape = array{
 *   allowedCountries?: list<string>|null,
 *   maxCallSeconds?: int|null,
 *   maxConcurrentCalls?: int|null,
 * }
 */
final class VoiceAgentLimitsSpec implements BaseModel
{
    /** @use SdkModel<VoiceAgentLimitsSpecShape> */
    use SdkModel;

    /**
     * ISO 3166-1 alpha-2 codes of the countries the agent may call or transfer to. Omit it to allow every country. Stored now, applied when the agent places calls.
     *
     * @var list<string>|null $allowedCountries
     */
    #[Optional('allowed_countries', list: 'string', nullable: true)]
    public ?array $allowedCountries;

    /**
     * The longest a call may last, 60 to 14,400 seconds. Default 3,600.
     */
    #[Optional('max_call_seconds', nullable: true)]
    public ?int $maxCallSeconds;

    /**
     * How many calls the agent may have going at once, from 1. Default 10.
     */
    #[Optional('max_concurrent_calls', nullable: true)]
    public ?int $maxConcurrentCalls;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $allowedCountries
     */
    public static function with(
        ?array $allowedCountries = null,
        ?int $maxCallSeconds = null,
        ?int $maxConcurrentCalls = null,
    ): self {
        $self = new self;

        null !== $allowedCountries && $self['allowedCountries'] = $allowedCountries;
        null !== $maxCallSeconds && $self['maxCallSeconds'] = $maxCallSeconds;
        null !== $maxConcurrentCalls && $self['maxConcurrentCalls'] = $maxConcurrentCalls;

        return $self;
    }

    /**
     * ISO 3166-1 alpha-2 codes of the countries the agent may call or transfer to. Omit it to allow every country. Stored now, applied when the agent places calls.
     *
     * @param list<string>|null $allowedCountries
     */
    public function withAllowedCountries(?array $allowedCountries): self
    {
        $self = clone $this;
        $self['allowedCountries'] = $allowedCountries;

        return $self;
    }

    /**
     * The longest a call may last, 60 to 14,400 seconds. Default 3,600.
     */
    public function withMaxCallSeconds(?int $maxCallSeconds): self
    {
        $self = clone $this;
        $self['maxCallSeconds'] = $maxCallSeconds;

        return $self;
    }

    /**
     * How many calls the agent may have going at once, from 1. Default 10.
     */
    public function withMaxConcurrentCalls(?int $maxConcurrentCalls): self
    {
        $self = clone $this;
        $self['maxConcurrentCalls'] = $maxConcurrentCalls;

        return $self;
    }
}
