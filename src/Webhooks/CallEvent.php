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
 * @phpstan-import-type CallEventPayloadShape from \SentDm\Webhooks\CallEventPayload
 *
 * @phpstan-type CallEventShape = array{
 *   event?: string|null,
 *   field?: string|null,
 *   payload?: null|CallEventPayload|CallEventPayloadShape,
 *   requestID?: string|null,
 *   timestamp?: string|null,
 * }
 */
final class CallEvent implements BaseModel
{
    /** @use SdkModel<CallEventShape> */
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
     * Body of a call.initiated, call.answered, call.completed, call.failed
     * or call.recording_ready event. Which of them occurred is the envelope's event.
     *
     * Shaped like the message, inbound, template and channel payloads: account_id names the
     * account the event is about, channel names the channel, and updated_at is when the change
     * happened on the call, in the same yyyy-MM-ddTHH:mm:ssZ form. duration_seconds and
     * price are added on call.completed, reason on call.failed and
     * recording_id on call.recording_ready; each is omitted rather than sent as null when it
     * does not apply.
     *
     * Casing is snake_case because these ride the same webhook stream customers already parse
     * message_id from; the question/answer contract is a separate surface and stays camelCase.
     * Nothing here is provider-shaped: no provider call id, no namespaced identity.
     */
    #[Optional(nullable: true)]
    public ?CallEventPayload $payload;

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
     * @param CallEventPayload|CallEventPayloadShape|null $payload
     */
    public static function with(
        ?string $event = null,
        ?string $field = null,
        CallEventPayload|array|null $payload = null,
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
     * Body of a call.initiated, call.answered, call.completed, call.failed
     * or call.recording_ready event. Which of them occurred is the envelope's event.
     *
     * Shaped like the message, inbound, template and channel payloads: account_id names the
     * account the event is about, channel names the channel, and updated_at is when the change
     * happened on the call, in the same yyyy-MM-ddTHH:mm:ssZ form. duration_seconds and
     * price are added on call.completed, reason on call.failed and
     * recording_id on call.recording_ready; each is omitted rather than sent as null when it
     * does not apply.
     *
     * Casing is snake_case because these ride the same webhook stream customers already parse
     * message_id from; the question/answer contract is a separate surface and stays camelCase.
     * Nothing here is provider-shaped: no provider call id, no namespaced identity.
     *
     * @param CallEventPayload|CallEventPayloadShape|null $payload
     */
    public function withPayload(CallEventPayload|array|null $payload): self
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
