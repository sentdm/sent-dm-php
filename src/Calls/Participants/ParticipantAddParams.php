<?php

declare(strict_types=1);

namespace SentDm\Calls\Participants;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Dials one of your app users or a phone number into a call that is in a conference room, and answers with the participant's own call record. The participant is a call of their own: it has its own id, can be looked up and hung up, and is billed and reported through call.completed and call.failed like any other call. Every participant needs a positive balance. A phone participant is called from caller_id, which must be one of your numbers, or from the call's owning number when omitted, and needs a destination you may call. Only a call your answer connected to a conference can take participants: a call connected to a user or a number answers 409.
 *
 * @see SentDm\Services\Calls\ParticipantsService::add()
 *
 * @phpstan-import-type CallParticipantTargetShape from \SentDm\Calls\Participants\CallParticipantTarget
 *
 * @phpstan-type ParticipantAddParamsShape = array{
 *   callerID?: string|null,
 *   sandbox?: bool|null,
 *   to?: null|CallParticipantTarget|CallParticipantTargetShape,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class ParticipantAddParams implements BaseModel
{
    /** @use SdkModel<ParticipantAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The number shown to a phone participant as the caller, in E.164 format. Must be one of your numbers. The call's owning number when omitted.
     */
    #[Optional('caller_id', nullable: true)]
    public ?string $callerID;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * A participant to add to a call.
     */
    #[Optional]
    public ?CallParticipantTarget $to;

    #[Optional]
    public ?string $idempotencyKey;

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
     *
     * @param CallParticipantTarget|CallParticipantTargetShape|null $to
     */
    public static function with(
        ?string $callerID = null,
        ?bool $sandbox = null,
        CallParticipantTarget|array|null $to = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $callerID && $self['callerID'] = $callerID;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $to && $self['to'] = $to;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * The number shown to a phone participant as the caller, in E.164 format. Must be one of your numbers. The call's owning number when omitted.
     */
    public function withCallerID(?string $callerID): self
    {
        $self = clone $this;
        $self['callerID'] = $callerID;

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

    /**
     * A participant to add to a call.
     *
     * @param CallParticipantTarget|CallParticipantTargetShape $to
     */
    public function withTo(CallParticipantTarget|array $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
