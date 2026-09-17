<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse\EventData;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfContactWebhookPayload\Payload;

/**
 * The envelope Sent POSTs to a subscribed webhook endpoint. Every event shares this shape and
 * varies only in Payload.
 *
 * @phpstan-import-type PayloadShape from \SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfContactWebhookPayload\Payload
 *
 * @phpstan-type SentDmServicesCommonServicesWebhooksContractsWebhookEventOfContactWebhookPayloadShape = array{
 *   event?: string|null,
 *   field?: string|null,
 *   payload?: null|Payload|PayloadShape,
 *   requestID?: string|null,
 *   timestamp?: string|null,
 * }
 */
final class SentDmServicesCommonServicesWebhooksContractsWebhookEventOfContactWebhookPayload implements BaseModel
{
    /**
     * @use SdkModel<SentDmServicesCommonServicesWebhooksContractsWebhookEventOfContactWebhookPayloadShape>
     */
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
     * Body of a contact.opt_in, contact.opt_out or contact.help event. Delivered
     * when a contact signals a consent change or asks for help.
     *
     * These events state the signal outright, so you do not have to recognise keywords in the
     * text of a message.received event. They also cover cases that produce no inbound message
     * at all, such as a network handling an opt-out on your behalf.
     *
     * Fields are ordered identity → resulting state → provenance → join key. Nothing here
     * restates the envelope: which of the three signals occurred is the envelope's event, and
     * when it was emitted is its timestamp. Retries carry the same X-Webhook-Event-ID
     * header, which is what to deduplicate on.
     */
    #[Optional(nullable: true)]
    public ?Payload $payload;

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
     * @param Payload|PayloadShape|null $payload
     */
    public static function with(
        ?string $event = null,
        ?string $field = null,
        Payload|array|null $payload = null,
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
     * Body of a contact.opt_in, contact.opt_out or contact.help event. Delivered
     * when a contact signals a consent change or asks for help.
     *
     * These events state the signal outright, so you do not have to recognise keywords in the
     * text of a message.received event. They also cover cases that produce no inbound message
     * at all, such as a network handling an opt-out on your behalf.
     *
     * Fields are ordered identity → resulting state → provenance → join key. Nothing here
     * restates the envelope: which of the three signals occurred is the envelope's event, and
     * when it was emitted is its timestamp. Retries carry the same X-Webhook-Event-ID
     * header, which is what to deduplicate on.
     *
     * @param Payload|PayloadShape|null $payload
     */
    public function withPayload(Payload|array|null $payload): self
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
