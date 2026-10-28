<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceAgentPartySpecShape = array{
 *   kind?: string|null, value?: string|null
 * }
 */
final class VoiceAgentPartySpec implements BaseModel
{
    /** @use SdkModel<VoiceAgentPartySpecShape> */
    use SdkModel;

    /**
     * number, user or agent.
     */
    #[Optional(nullable: true)]
    public ?string $kind;

    /**
     * The E.164 number, the app user's identity, or the agent id (agent_…).
     */
    #[Optional(nullable: true)]
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
    public static function with(
        ?string $kind = null,
        ?string $value = null
    ): self {
        $self = new self;

        null !== $kind && $self['kind'] = $kind;
        null !== $value && $self['value'] = $value;

        return $self;
    }

    /**
     * number, user or agent.
     */
    public function withKind(?string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    /**
     * The E.164 number, the app user's identity, or the agent id (agent_…).
     */
    public function withValue(?string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
