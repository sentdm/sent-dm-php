<?php

declare(strict_types=1);

namespace SentDm\Conversations\ConversationMessagesList\Message;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Represents a status change event in a message's lifecycle (v3).
 *
 * @phpstan-type EventShape = array{
 *   status: string,
 *   timestamp: \DateTimeInterface,
 *   description?: string|null,
 *   reason?: string|null,
 *   reasonCode?: string|null,
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
     * A human-readable sentence for reason_code. Omitted whenever reason_code is.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * Why the message reached this status, as a stable platform code such as DELIVERY_007.
     * Present on FAILED, FILTERED and BLOCKED events; omitted on every status that needs no
     * explanation. Same wire name and vocabulary as on the activities list and the webhook.
     */
    #[Optional('reason_code', nullable: true)]
    public ?string $reasonCode;

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
        ?string $description = null,
        ?string $reason = null,
        ?string $reasonCode = null,
    ): self {
        $self = new self;

        $self['status'] = $status;
        $self['timestamp'] = $timestamp;

        null !== $description && $self['description'] = $description;
        null !== $reason && $self['reason'] = $reason;
        null !== $reasonCode && $self['reasonCode'] = $reasonCode;

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

    /**
     * A human-readable sentence for reason_code. Omitted whenever reason_code is.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the message reached this status, as a stable platform code such as DELIVERY_007.
     * Present on FAILED, FILTERED and BLOCKED events; omitted on every status that needs no
     * explanation. Same wire name and vocabulary as on the activities list and the webhook.
     */
    public function withReasonCode(?string $reasonCode): self
    {
        $self = clone $this;
        $self['reasonCode'] = $reasonCode;

        return $self;
    }
}
