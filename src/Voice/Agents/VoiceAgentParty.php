<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentPartyShape = array{
 *   kind?: string|null, value?: string|null
 * }
 */
final class VoiceAgentParty implements BaseModel
{
    /** @use SdkModel<VoiceAgentPartyShape> */
    use SdkModel;

    #[Optional]
    public ?string $kind;

    #[Optional]
    public ?string $value;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $kind = null, ?string $value = null): self
    {
        $self = new self;

        null !== $kind && $self['kind'] = $kind;
        null !== $value && $self['value'] = $value;

        return $self;
    }

    public function withKind(string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
