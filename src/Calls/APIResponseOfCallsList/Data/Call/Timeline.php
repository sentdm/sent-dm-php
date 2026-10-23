<?php

declare(strict_types=1);

namespace SentDm\Calls\APIResponseOfCallsList\Data\Call;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * When a call entered a status.
 *
 * @phpstan-type TimelineShape = array{
 *   status?: string|null, timestamp?: \DateTimeInterface|null
 * }
 */
final class Timeline implements BaseModel
{
    /** @use SdkModel<TimelineShape> */
    use SdkModel;

    /**
     * INITIATED, RINGING, ANSWERED, COMPLETED, FAILED, NO_ANSWER or REJECTED.
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
     * INITIATED, RINGING, ANSWERED, COMPLETED, FAILED, NO_ANSWER or REJECTED.
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
