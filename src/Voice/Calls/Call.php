<?php

declare(strict_types=1);

namespace SentDm\Voice\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Voice\Calls\Call\Leg;

/**
 * A call record.
 *
 * @phpstan-import-type CallPartyShape from \SentDm\Voice\Calls\CallParty
 * @phpstan-import-type LegShape from \SentDm\Voice\Calls\Call\Leg
 * @phpstan-import-type CallTimelineEntryShape from \SentDm\Voice\Calls\CallTimelineEntry
 *
 * @phpstan-type CallShape = array{
 *   id?: string|null,
 *   agentID?: string|null,
 *   answeredAt?: \DateTimeInterface|null,
 *   callerIDUsed?: string|null,
 *   connectedNumber?: string|null,
 *   direction?: string|null,
 *   durationSeconds?: int|null,
 *   endedAt?: \DateTimeInterface|null,
 *   failureReason?: string|null,
 *   from?: null|CallParty|CallPartyShape,
 *   legs?: list<Leg|LegShape>|null,
 *   mode?: string|null,
 *   number?: string|null,
 *   price?: float|null,
 *   recordingAvailable?: bool|null,
 *   startedAt?: \DateTimeInterface|null,
 *   status?: string|null,
 *   timeline?: list<CallTimelineEntry|CallTimelineEntryShape>|null,
 *   to?: null|CallParty|CallPartyShape,
 * }
 */
final class Call implements BaseModel
{
    /** @use SdkModel<CallShape> */
    use SdkModel;

    /**
     * The call id, the same one carried by the call.request question and every call webhook.
     */
    #[Optional]
    public ?string $id;

    /**
     * The voice agent that answered the call, such as agent_9f2ab000-0000-4000-8000-000000000001. Null for an inapp call.
     */
    #[Optional('agent_id', nullable: true)]
    public ?string $agentID;

    /**
     * When the call was answered (UTC). Null until then, and always null for a call between two of your app users.
     */
    #[Optional('answered_at', nullable: true)]
    public ?\DateTimeInterface $answeredAt;

    /**
     * The caller id shown on the phone leg, in E.164 format: the one your answer chose, or the owning number when it chose none. Null for a call with no phone leg.
     */
    #[Optional('caller_id_used', nullable: true)]
    public ?string $callerIDUsed;

    /**
     * The phone number the call was connected to, in E.164 format: the number your answer dialed, or the fallback number a call to one of your voice agents reached. Null when the call was not connected to a phone number.
     */
    #[Optional('connected_number', nullable: true)]
    public ?string $connectedNumber;

    /**
     * outbound for a call placed from your app, inbound for a call to one of your numbers.
     */
    #[Optional]
    public ?string $direction;

    /**
     * Billable duration in seconds. Null while the call is live.
     */
    #[Optional('duration_seconds', nullable: true)]
    public ?int $durationSeconds;

    /**
     * When the call ended (UTC). Null while the call is live.
     */
    #[Optional('ended_at', nullable: true)]
    public ?\DateTimeInterface $endedAt;

    /**
     * Why the call did not complete: callback_timeout, invalid_answer, insufficient_balance, destination_blocked, callback_not_configured, rejected, no_answer, or for an agent call agent_busy or agent_unreachable. Null while the call is live, when it completed, and when it failed without a recorded reason.
     */
    #[Optional('failure_reason', nullable: true)]
    public ?string $failureReason;

    /**
     * One end of a call.
     */
    #[Optional]
    public ?CallParty $from;

    /**
     * The legs the price covers, one entry per billed leg, each with its own cost: a call your answer connected to a phone number ran the caller's leg to your number and the leg to the connected number at once, and both are billed. Null until the call has been priced.
     *
     * @var list<Leg>|null $legs
     */
    #[Optional(list: Leg::class, nullable: true)]
    public ?array $legs;

    /**
     * The calling mode: inapp for a call between people in your app and phone numbers, routed by your number's callback URL; agent for a call one of your voice agents answered.
     */
    #[Optional]
    public ?string $mode;

    /**
     * Your number that owns the call, in E.164 format: the dialed number for an inbound call, the caller's bound number for a call placed from your app.
     */
    #[Optional]
    public ?string $number;

    /**
     * What the call cost. Null until it has been priced.
     */
    #[Optional(nullable: true)]
    public ?float $price;

    /**
     * True once a recording of the call is available.
     */
    #[Optional('recording_available')]
    public ?bool $recordingAvailable;

    /**
     * When the call was placed (UTC).
     */
    #[Optional('started_at')]
    public ?\DateTimeInterface $startedAt;

    /**
     * INITIATED, RINGING, ANSWERED, COMPLETED, FAILED, NO_ANSWER or REJECTED.
     */
    #[Optional]
    public ?string $status;

    /**
     * When the call entered each status, oldest first. Only returned when reading one call.
     *
     * @var list<CallTimelineEntry>|null $timeline
     */
    #[Optional(list: CallTimelineEntry::class, nullable: true)]
    public ?array $timeline;

    /**
     * One end of a call.
     */
    #[Optional]
    public ?CallParty $to;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param CallParty|CallPartyShape|null $from
     * @param list<Leg|LegShape>|null $legs
     * @param list<CallTimelineEntry|CallTimelineEntryShape>|null $timeline
     * @param CallParty|CallPartyShape|null $to
     */
    public static function with(
        ?string $id = null,
        ?string $agentID = null,
        ?\DateTimeInterface $answeredAt = null,
        ?string $callerIDUsed = null,
        ?string $connectedNumber = null,
        ?string $direction = null,
        ?int $durationSeconds = null,
        ?\DateTimeInterface $endedAt = null,
        ?string $failureReason = null,
        CallParty|array|null $from = null,
        ?array $legs = null,
        ?string $mode = null,
        ?string $number = null,
        ?float $price = null,
        ?bool $recordingAvailable = null,
        ?\DateTimeInterface $startedAt = null,
        ?string $status = null,
        ?array $timeline = null,
        CallParty|array|null $to = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $agentID && $self['agentID'] = $agentID;
        null !== $answeredAt && $self['answeredAt'] = $answeredAt;
        null !== $callerIDUsed && $self['callerIDUsed'] = $callerIDUsed;
        null !== $connectedNumber && $self['connectedNumber'] = $connectedNumber;
        null !== $direction && $self['direction'] = $direction;
        null !== $durationSeconds && $self['durationSeconds'] = $durationSeconds;
        null !== $endedAt && $self['endedAt'] = $endedAt;
        null !== $failureReason && $self['failureReason'] = $failureReason;
        null !== $from && $self['from'] = $from;
        null !== $legs && $self['legs'] = $legs;
        null !== $mode && $self['mode'] = $mode;
        null !== $number && $self['number'] = $number;
        null !== $price && $self['price'] = $price;
        null !== $recordingAvailable && $self['recordingAvailable'] = $recordingAvailable;
        null !== $startedAt && $self['startedAt'] = $startedAt;
        null !== $status && $self['status'] = $status;
        null !== $timeline && $self['timeline'] = $timeline;
        null !== $to && $self['to'] = $to;

        return $self;
    }

    /**
     * The call id, the same one carried by the call.request question and every call webhook.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The voice agent that answered the call, such as agent_9f2ab000-0000-4000-8000-000000000001. Null for an inapp call.
     */
    public function withAgentID(?string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * When the call was answered (UTC). Null until then, and always null for a call between two of your app users.
     */
    public function withAnsweredAt(?\DateTimeInterface $answeredAt): self
    {
        $self = clone $this;
        $self['answeredAt'] = $answeredAt;

        return $self;
    }

    /**
     * The caller id shown on the phone leg, in E.164 format: the one your answer chose, or the owning number when it chose none. Null for a call with no phone leg.
     */
    public function withCallerIDUsed(?string $callerIDUsed): self
    {
        $self = clone $this;
        $self['callerIDUsed'] = $callerIDUsed;

        return $self;
    }

    /**
     * The phone number the call was connected to, in E.164 format: the number your answer dialed, or the fallback number a call to one of your voice agents reached. Null when the call was not connected to a phone number.
     */
    public function withConnectedNumber(?string $connectedNumber): self
    {
        $self = clone $this;
        $self['connectedNumber'] = $connectedNumber;

        return $self;
    }

    /**
     * outbound for a call placed from your app, inbound for a call to one of your numbers.
     */
    public function withDirection(string $direction): self
    {
        $self = clone $this;
        $self['direction'] = $direction;

        return $self;
    }

    /**
     * Billable duration in seconds. Null while the call is live.
     */
    public function withDurationSeconds(?int $durationSeconds): self
    {
        $self = clone $this;
        $self['durationSeconds'] = $durationSeconds;

        return $self;
    }

    /**
     * When the call ended (UTC). Null while the call is live.
     */
    public function withEndedAt(?\DateTimeInterface $endedAt): self
    {
        $self = clone $this;
        $self['endedAt'] = $endedAt;

        return $self;
    }

    /**
     * Why the call did not complete: callback_timeout, invalid_answer, insufficient_balance, destination_blocked, callback_not_configured, rejected, no_answer, or for an agent call agent_busy or agent_unreachable. Null while the call is live, when it completed, and when it failed without a recorded reason.
     */
    public function withFailureReason(?string $failureReason): self
    {
        $self = clone $this;
        $self['failureReason'] = $failureReason;

        return $self;
    }

    /**
     * One end of a call.
     *
     * @param CallParty|CallPartyShape $from
     */
    public function withFrom(CallParty|array $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * The legs the price covers, one entry per billed leg, each with its own cost: a call your answer connected to a phone number ran the caller's leg to your number and the leg to the connected number at once, and both are billed. Null until the call has been priced.
     *
     * @param list<Leg|LegShape>|null $legs
     */
    public function withLegs(?array $legs): self
    {
        $self = clone $this;
        $self['legs'] = $legs;

        return $self;
    }

    /**
     * The calling mode: inapp for a call between people in your app and phone numbers, routed by your number's callback URL; agent for a call one of your voice agents answered.
     */
    public function withMode(string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * Your number that owns the call, in E.164 format: the dialed number for an inbound call, the caller's bound number for a call placed from your app.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * What the call cost. Null until it has been priced.
     */
    public function withPrice(?float $price): self
    {
        $self = clone $this;
        $self['price'] = $price;

        return $self;
    }

    /**
     * True once a recording of the call is available.
     */
    public function withRecordingAvailable(bool $recordingAvailable): self
    {
        $self = clone $this;
        $self['recordingAvailable'] = $recordingAvailable;

        return $self;
    }

    /**
     * When the call was placed (UTC).
     */
    public function withStartedAt(\DateTimeInterface $startedAt): self
    {
        $self = clone $this;
        $self['startedAt'] = $startedAt;

        return $self;
    }

    /**
     * INITIATED, RINGING, ANSWERED, COMPLETED, FAILED, NO_ANSWER or REJECTED.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When the call entered each status, oldest first. Only returned when reading one call.
     *
     * @param list<CallTimelineEntry|CallTimelineEntryShape>|null $timeline
     */
    public function withTimeline(?array $timeline): self
    {
        $self = clone $this;
        $self['timeline'] = $timeline;

        return $self;
    }

    /**
     * One end of a call.
     *
     * @param CallParty|CallPartyShape $to
     */
    public function withTo(CallParty|array $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }
}
