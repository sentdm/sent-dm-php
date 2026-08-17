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
 * @phpstan-import-type InboundMessageEventPayloadShape from \SentDm\Webhooks\InboundMessageEventPayload
 *
 * @phpstan-type InboundMessageEventShape = array{
 *   event?: string|null,
 *   field?: string|null,
 *   payload?: null|InboundMessageEventPayload|InboundMessageEventPayloadShape,
 *   timestamp?: string|null,
 * }
 */
final class InboundMessageEvent implements BaseModel
{
    /** @use SdkModel<InboundMessageEventShape> */
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
     * Body of a message.received event. Delivered when a contact messages one of your numbers.
     */
    #[Optional(nullable: true)]
    public ?InboundMessageEventPayload $payload;

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
     * @param InboundMessageEventPayload|InboundMessageEventPayloadShape|null $payload
     */
    public static function with(
        ?string $event = null,
        ?string $field = null,
        InboundMessageEventPayload|array|null $payload = null,
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
     * Body of a message.received event. Delivered when a contact messages one of your numbers.
     *
     * @param InboundMessageEventPayload|InboundMessageEventPayloadShape|null $payload
     */
    public function withPayload(
        InboundMessageEventPayload|array|null $payload
    ): self {
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
