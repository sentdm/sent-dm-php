<?php

declare(strict_types=1);

namespace SentDm\Calls\Participants;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Lists who is in the conference room one of your live calls is in: each participant's own call id, who they are, whether the room mutes them, and how long they have been connected. The call itself is one of the participants. Use a participant's id to mute or remove them; it is also a call id, so GET /v3/calls/{id} accepts it. A call that has ended answers 409, as does a call that is not in a conference.
 *
 * @see SentDm\Services\Calls\ParticipantsService::list()
 *
 * @phpstan-type ParticipantListParamsShape = array{xProfileID?: string|null}
 */
final class ParticipantListParams implements BaseModel
{
    /** @use SdkModel<ParticipantListParamsShape> */
    use SdkModel;
    use SdkParams;

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
    public static function with(?string $xProfileID = null): self
    {
        $self = new self;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
