<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentLimitsShape = array{
 *   allowedCountries?: list<string>|null,
 *   maxCallSeconds?: int|null,
 *   maxConcurrentCalls?: int|null,
 * }
 */
final class VoiceAgentLimits implements BaseModel
{
    /** @use SdkModel<VoiceAgentLimitsShape> */
    use SdkModel;

    /** @var list<string>|null $allowedCountries */
    #[Optional('allowed_countries', list: 'string', nullable: true)]
    public ?array $allowedCountries;

    #[Optional('max_call_seconds')]
    public ?int $maxCallSeconds;

    #[Optional('max_concurrent_calls')]
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
     * @param list<string>|null $allowedCountries
     */
    public function withAllowedCountries(?array $allowedCountries): self
    {
        $self = clone $this;
        $self['allowedCountries'] = $allowedCountries;

        return $self;
    }

    public function withMaxCallSeconds(int $maxCallSeconds): self
    {
        $self = clone $this;
        $self['maxCallSeconds'] = $maxCallSeconds;

        return $self;
    }

    public function withMaxConcurrentCalls(int $maxConcurrentCalls): self
    {
        $self = clone $this;
        $self['maxConcurrentCalls'] = $maxConcurrentCalls;

        return $self;
    }
}
