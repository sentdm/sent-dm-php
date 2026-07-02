<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetStatusResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Represents a status change event in a message's lifecycle (v3).
 *
 * @phpstan-type EventShape = array{
 *   status: string, timestamp: \DateTimeInterface, description?: string|null
 * }
 */
final class Event implements BaseModel
{
    /** @use SdkModel<EventShape> */
    use SdkModel;

    #[Required]
    public string $status;

    #[Required]
    public \DateTimeInterface $timestamp;

    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * `new Event()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Event::with(status: ..., timestamp: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Event)->withStatus(...)->withTimestamp(...)
     * ```
     */
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
        string $status,
        \DateTimeInterface $timestamp,
        ?string $description = null
    ): self {
        $self = new self;

        $self['status'] = $status;
        $self['timestamp'] = $timestamp;

        null !== $description && $self['description'] = $description;

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

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }
}
