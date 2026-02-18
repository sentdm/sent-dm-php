<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetStatusResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Represents a status change event in a message's lifecycle (v3).
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

    #[Optional(nullable: true)]
    public ?string $description;

    #[Optional]
    public ?string $status;

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

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withTimestamp(\DateTimeInterface $timestamp): self
    {
        $self = clone $this;
        $self['timestamp'] = $timestamp;

        return $self;
    }
}
