<?php

declare(strict_types=1);

namespace SentDm\Calls\Participants;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A participant to add to a call.
 *
 * @phpstan-type CallParticipantTargetShape = array{
 *   kind?: string|null, value?: string|null
 * }
 */
final class CallParticipantTarget implements BaseModel
{
    /** @use SdkModel<CallParticipantTargetShape> */
    use SdkModel;

    /**
     * user for one of your app users, number for a phone number.
     */
    #[Optional]
    public ?string $kind;

    /**
     * The app user's identity, or the phone number in E.164 format.
     */
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

    /**
     * user for one of your app users, number for a phone number.
     */
    public function withKind(string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    /**
     * The app user's identity, or the phone number in E.164 format.
     */
    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
