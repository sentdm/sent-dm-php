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
 * @phpstan-import-type AgentEventPayloadShape from \SentDm\Webhooks\AgentEventPayload
 *
 * @phpstan-type AgentEventShape = array{
 *   event?: string|null,
 *   field?: string|null,
 *   payload?: null|AgentEventPayload|AgentEventPayloadShape,
 *   requestID?: string|null,
 *   timestamp?: string|null,
 * }
 */
final class AgentEvent implements BaseModel
{
    /** @use SdkModel<AgentEventShape> */
    use SdkModel;

    /**
     * The specific event within the family, for example message.delivered,
     * message.received or contact.opt_out. Absent on events that have no subtype, so
     * treat it as optional.
     */
    #[Optional(nullable: true)]
    public ?string $event;

    /**
     * The event family, for example message, templates or contact. Route on
     * this first, then on event for the specific change.
     */
    #[Optional]
    public ?string $field;

    /**
     * Body of an agent.* webhook (Sent Agents). The event is the agent service's own record,
     * forwarded without renaming: EventId is its id, so a subscriber can dedupe a redelivery.
     */
    #[Optional(nullable: true)]
    public ?AgentEventPayload $payload;

    /**
     * The event-specific body.
     */
    #[Optional('request_id', nullable: true)]
    public ?string $requestID;

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
     * @param AgentEventPayload|AgentEventPayloadShape|null $payload
     */
    public static function with(
        ?string $event = null,
        ?string $field = null,
        AgentEventPayload|array|null $payload = null,
        ?string $requestID = null,
        ?string $timestamp = null,
    ): self {
        $self = new self;

        null !== $event && $self['event'] = $event;
        null !== $field && $self['field'] = $field;
        null !== $payload && $self['payload'] = $payload;
        null !== $requestID && $self['requestID'] = $requestID;
        null !== $timestamp && $self['timestamp'] = $timestamp;

        return $self;
    }

    /**
     * The specific event within the family, for example message.delivered,
     * message.received or contact.opt_out. Absent on events that have no subtype, so
     * treat it as optional.
     */
    public function withEvent(?string $event): self
    {
        $self = clone $this;
        $self['event'] = $event;

        return $self;
    }

    /**
     * The event family, for example message, templates or contact. Route on
     * this first, then on event for the specific change.
     */
    public function withField(string $field): self
    {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }

    /**
     * Body of an agent.* webhook (Sent Agents). The event is the agent service's own record,
     * forwarded without renaming: EventId is its id, so a subscriber can dedupe a redelivery.
     *
     * @param AgentEventPayload|AgentEventPayloadShape|null $payload
     */
    public function withPayload(AgentEventPayload|array|null $payload): self
    {
        $self = clone $this;
        $self['payload'] = $payload;

        return $self;
    }

    /**
     * The event-specific body.
     */
    public function withRequestID(?string $requestID): self
    {
        $self = clone $this;
        $self['requestID'] = $requestID;

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
