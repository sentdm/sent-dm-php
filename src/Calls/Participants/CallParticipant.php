<?php

declare(strict_types=1);

namespace SentDm\Calls\Participants;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A participant of a conference call.
 *
 * @phpstan-type CallParticipantShape = array{
 *   id?: string|null,
 *   durationSeconds?: int|null,
 *   kind?: string|null,
 *   muted?: bool|null,
 *   value?: string|null,
 * }
 */
final class CallParticipant implements BaseModel
{
    /** @use SdkModel<CallParticipantShape> */
    use SdkModel;

    /**
     * The participant's own call id: what the mute and remove endpoints take, and what GET /v3/calls/{id} accepts.
     */
    #[Optional]
    public ?string $id;

    /**
     * How long the participant has been connected to the room, in seconds.
     */
    #[Optional('duration_seconds')]
    public ?int $durationSeconds;

    /**
     * user for one of your app users, number for a phone number, anonymous for a caller who withheld their number.
     */
    #[Optional]
    public ?string $kind;

    /**
     * True while the room mutes this participant.
     */
    #[Optional]
    public ?bool $muted;

    /**
     * The app user's identity or the phone number in E.164 format. Null when the kind is anonymous.
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
        ?string $id = null,
        ?int $durationSeconds = null,
        ?string $kind = null,
        ?bool $muted = null,
        ?string $value = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $durationSeconds && $self['durationSeconds'] = $durationSeconds;
        null !== $kind && $self['kind'] = $kind;
        null !== $muted && $self['muted'] = $muted;
        null !== $value && $self['value'] = $value;

        return $self;
    }

    /**
     * The participant's own call id: what the mute and remove endpoints take, and what GET /v3/calls/{id} accepts.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * How long the participant has been connected to the room, in seconds.
     */
    public function withDurationSeconds(int $durationSeconds): self
    {
        $self = clone $this;
        $self['durationSeconds'] = $durationSeconds;

        return $self;
    }

    /**
     * user for one of your app users, number for a phone number, anonymous for a caller who withheld their number.
     */
    public function withKind(string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    /**
     * True while the room mutes this participant.
     */
    public function withMuted(bool $muted): self
    {
        $self = clone $this;
        $self['muted'] = $muted;

        return $self;
    }

    /**
     * The app user's identity or the phone number in E.164 format. Null when the kind is anonymous.
     */
    public function withValue(?string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
