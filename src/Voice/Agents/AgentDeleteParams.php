<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Removes the agent. Calls it already took keep their `agent_id`.
 *
 * An agent that one of your voice numbers routes to, or that another of your agents lists in `transfer_targets`, is not deleted: the answer is `409` with a message naming those numbers and agents. Unbind the numbers (`PATCH /v3/channels/voice/{number}` with `"agent_id": null`), take the agent out of the others' `transfer_targets` or delete them, and try again.
 *
 * With `sandbox: true` nothing is written: the agent is looked up and the answer is the one a real delete would give.
 *
 * @see SentDm\Services\Voice\AgentsService::delete()
 *
 * @phpstan-type AgentDeleteParamsShape = array{
 *   sandbox?: bool|null, xProfileID?: string|null
 * }
 */
final class AgentDeleteParams implements BaseModel
{
    /** @use SdkModel<AgentDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $xProfileID;

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
        ?bool $sandbox = null,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
