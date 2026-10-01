<?php

declare(strict_types=1);

namespace SentDm\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * When a call entered a status.
 *
 * @phpstan-type CallTimelineEntryShape = array{
 *   status?: string|null, timestamp?: \DateTimeInterface|null
 * }
 */
final class CallTimelineEntry implements BaseModel
{
    /** @use SdkModel<CallTimelineEntryShape> */
    use SdkModel;

    /**
     * initiated, ringing, answered, completed, failed, no_answer or rejected.
     */
    #[Optional]
    public ?string $status;

    /**
     * When the call entered this status (UTC).
     */
    #[Optional]
    public ?\DateTimeInterface $timestamp;

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
        ?string $status = null,
        ?\DateTimeInterface $timestamp = null
    ): self {
        $self = new self;

        null !== $status && $self['status'] = $status;
        null !== $timestamp && $self['timestamp'] = $timestamp;

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
     * When the call entered this status (UTC).
     */
    public function withTimestamp(\DateTimeInterface $timestamp): self
    {
        $self = clone $this;
        $self['timestamp'] = $timestamp;

        return $self;
    }
}
