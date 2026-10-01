<?php

declare(strict_types=1);

namespace SentDm\Calls\Participants;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Removes one participant from the conference room a live call is in, named by the participant's own call id from the participants list. Their leg ends and is reported through call.completed like any other call; everyone else stays connected. A participant who is not in this call's room answers 404. A call that has ended answers 409, as does a call that is not in a conference.
 *
 * @see SentDm\Services\Calls\ParticipantsService::remove()
 *
 * @phpstan-type ParticipantRemoveParamsShape = array{
 *   id: string, sandbox?: bool|null, xProfileID?: string|null
 * }
 */
final class ParticipantRemoveParams implements BaseModel
{
    /** @use SdkModel<ParticipantRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $id;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new ParticipantRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ParticipantRemoveParams::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ParticipantRemoveParams)->withID(...)
     * ```
     */
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
        string $id,
        ?bool $sandbox = null,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
