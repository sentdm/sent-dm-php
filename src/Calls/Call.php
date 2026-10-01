<?php

declare(strict_types=1);

namespace SentDm\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A call record.
 *
 * @phpstan-import-type CallPartyShape from \SentDm\Calls\CallParty
 * @phpstan-import-type CallTimelineEntryShape from \SentDm\Calls\CallTimelineEntry
 *
 * @phpstan-type CallShape = array{
 *   id?: string|null,
 *   answeredAt?: \DateTimeInterface|null,
 *   direction?: string|null,
 *   durationSeconds?: int|null,
 *   endedAt?: \DateTimeInterface|null,
 *   failureReason?: string|null,
 *   from?: null|CallParty|CallPartyShape,
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
     * When the call was answered (UTC). Null until then, and always null for a call between two of your app users.
     */
    #[Optional('answered_at', nullable: true)]
    public ?\DateTimeInterface $answeredAt;

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
     * Why the call did not complete: callback_timeout, invalid_answer, insufficient_balance, destination_blocked, rejected or no_answer. Null while the call is live, when it completed, and when it failed without a recorded reason.
     */
    #[Optional('failure_reason', nullable: true)]
    public ?string $failureReason;

    /**
     * One end of a call.
     */
    #[Optional]
    public ?CallParty $from;

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
     * initiated, ringing, answered, completed, failed, no_answer or rejected.
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
     * @param list<CallTimelineEntry|CallTimelineEntryShape>|null $timeline
     * @param CallParty|CallPartyShape|null $to
     */
    public static function with(
        ?string $id = null,
        ?\DateTimeInterface $answeredAt = null,
        ?string $direction = null,
        ?int $durationSeconds = null,
        ?\DateTimeInterface $endedAt = null,
        ?string $failureReason = null,
        CallParty|array|null $from = null,
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
        null !== $answeredAt && $self['answeredAt'] = $answeredAt;
        null !== $direction && $self['direction'] = $direction;
        null !== $durationSeconds && $self['durationSeconds'] = $durationSeconds;
        null !== $endedAt && $self['endedAt'] = $endedAt;
        null !== $failureReason && $self['failureReason'] = $failureReason;
        null !== $from && $self['from'] = $from;
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
     * When the call was answered (UTC). Null until then, and always null for a call between two of your app users.
     */
    public function withAnsweredAt(?\DateTimeInterface $answeredAt): self
    {
        $self = clone $this;
        $self['answeredAt'] = $answeredAt;

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
     * Why the call did not complete: callback_timeout, invalid_answer, insufficient_balance, destination_blocked, rejected or no_answer. Null while the call is live, when it completed, and when it failed without a recorded reason.
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
     * initiated, ringing, answered, completed, failed, no_answer or rejected.
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
