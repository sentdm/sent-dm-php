<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The envelope Sent POSTs to a subscribed webhook endpoint. Every event shares this shape and
 * varies only in Payload.
 *
 * @phpstan-import-type MessageEventPayloadShape from \SentDm\Webhooks\MessageEventPayload
 *
 * @phpstan-type MessageEventShape = array{
 *   event?: string|null,
 *   field?: string|null,
 *   payload?: null|MessageEventPayload|MessageEventPayloadShape,
 *   timestamp?: string|null,
 * }
 */
final class MessageEvent implements BaseModel
{
    /** @use SdkModel<MessageEventShape> */
    use SdkModel;

    /**
     * The specific event within the family, for example message.delivered or
     * message.received. Absent on events that have no subtype, so treat it as optional.
     */
    #[Optional(nullable: true)]
    public ?string $event;

    /**
     * The event family, for example message or templates. Route on this first, then
     * on event for the specific change.
     */
    #[Optional]
    public ?string $field;

    /**
     * Body of an outbound message lifecycle event. Delivered once per status change, so a single
     * message produces several of these as it moves toward a terminal status.
     */
    #[Optional(nullable: true)]
    public ?MessageEventPayload $payload;

    /**
     * When Sent emitted the event, in UTC (yyyy-MM-ddTHH:mm:ssZ). This is the emission
     * time, not the time the underlying change happened. Use the timestamp inside the payload for
     * the latter.
     */
    #[Optional]
    public ?string $timestamp;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MessageEventPayload|MessageEventPayloadShape|null $payload
     */
    public static function with(
        ?string $event = null,
        ?string $field = null,
        MessageEventPayload|array|null $payload = null,
        ?string $timestamp = null,
    ): self {
        $self = new self;

        null !== $event && $self['event'] = $event;
        null !== $field && $self['field'] = $field;
        null !== $payload && $self['payload'] = $payload;
        null !== $timestamp && $self['timestamp'] = $timestamp;

        return $self;
    }

    /**
     * The specific event within the family, for example message.delivered or
     * message.received. Absent on events that have no subtype, so treat it as optional.
     */
    public function withEvent(?string $event): self
    {
        $self = clone $this;
        $self['event'] = $event;

        return $self;
    }

    /**
     * The event family, for example message or templates. Route on this first, then
     * on event for the specific change.
     */
    public function withField(string $field): self
    {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }

    /**
     * Body of an outbound message lifecycle event. Delivered once per status change, so a single
     * message produces several of these as it moves toward a terminal status.
     *
     * @param MessageEventPayload|MessageEventPayloadShape|null $payload
     */
    public function withPayload(MessageEventPayload|array|null $payload): self
    {
        $self = clone $this;
        $self['payload'] = $payload;

        return $self;
    }

    /**
     * When Sent emitted the event, in UTC (yyyy-MM-ddTHH:mm:ssZ). This is the emission
     * time, not the time the underlying change happened. Use the timestamp inside the payload for
     * the latter.
     */
    public function withTimestamp(string $timestamp): self
    {
        $self = clone $this;
        $self['timestamp'] = $timestamp;

        return $self;
    }
}
