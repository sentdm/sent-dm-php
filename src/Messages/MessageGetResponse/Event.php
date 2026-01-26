<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Represents a status change event in a message's lifecycle
 * Follows industry standards (Twilio, SendGrid, Mailgun pattern).
 *
 * @phpstan-type EventShape = array{
 *   description?: string|null,
 *   status?: string|null,
 *   timestamp?: \DateTimeInterface|null,
 * }
 */
final class Event implements BaseModel
{
    /** @use SdkModel<EventShape> */
    use SdkModel;

    /**
     * Optional human-readable description of the event
     * Useful for error messages or additional context.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * The status of the message at this point in time
     * Examples: "queued", "sent", "delivered", "read", "failed".
     */
    #[Optional]
    public ?string $status;

    /**
     * When this status change occurred (ISO 8601 format).
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
        ?string $description = null,
        ?string $status = null,
        ?\DateTimeInterface $timestamp = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $status && $self['status'] = $status;
        null !== $timestamp && $self['timestamp'] = $timestamp;

        return $self;
    }

    /**
     * Optional human-readable description of the event
     * Useful for error messages or additional context.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The status of the message at this point in time
     * Examples: "queued", "sent", "delivered", "read", "failed".
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When this status change occurred (ISO 8601 format).
     */
    public function withTimestamp(\DateTimeInterface $timestamp): self
    {
        $self = clone $this;
        $self['timestamp'] = $timestamp;

        return $self;
    }
}
