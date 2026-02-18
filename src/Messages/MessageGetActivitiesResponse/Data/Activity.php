<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetActivitiesResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A single message activity event for v3 API.
 *
 * @phpstan-type ActivityShape = array{
 *   content?: string|null,
 *   description?: string|null,
 *   status?: string|null,
 *   timestamp?: \DateTimeInterface|null,
 * }
 */
final class Activity implements BaseModel
{
    /** @use SdkModel<ActivityShape> */
    use SdkModel;

    /**
     * Additional content or payload for the activity (e.g., channel response).
     */
    #[Optional(nullable: true)]
    public ?string $content;

    /**
     * Human-readable description of the activity.
     */
    #[Optional]
    public ?string $description;

    /**
     * Activity status (e.g., ACCEPTED, PROCESSED, SENT, DELIVERED, FAILED).
     */
    #[Optional]
    public ?string $status;

    /**
     * When this activity occurred.
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
        ?string $content = null,
        ?string $description = null,
        ?string $status = null,
        ?\DateTimeInterface $timestamp = null,
    ): self {
        $self = new self;

        null !== $content && $self['content'] = $content;
        null !== $description && $self['description'] = $description;
        null !== $status && $self['status'] = $status;
        null !== $timestamp && $self['timestamp'] = $timestamp;

        return $self;
    }

    /**
     * Additional content or payload for the activity (e.g., channel response).
     */
    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Human-readable description of the activity.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Activity status (e.g., ACCEPTED, PROCESSED, SENT, DELIVERED, FAILED).
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When this activity occurred.
     */
    public function withTimestamp(\DateTimeInterface $timestamp): self
    {
        $self = clone $this;
        $self['timestamp'] = $timestamp;

        return $self;
    }
}
