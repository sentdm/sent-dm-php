<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse\EventData;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayload\Payload;

/**
 * The envelope Sent POSTs to a subscribed webhook endpoint. Every event shares this shape and
 * varies only in Payload.
 *
 * @phpstan-import-type PayloadShape from \SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayload\Payload
 *
 * @phpstan-type SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayloadShape = array{
 *   event?: string|null,
 *   field?: string|null,
 *   payload?: null|Payload|PayloadShape,
 *   requestID?: string|null,
 *   timestamp?: string|null,
 * }
 */
final class SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayload implements BaseModel
{
    /**
     * @use SdkModel<SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayloadShape>
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
     * Body of a link event: something happened to a tracked link Sent published on the customer's
     * behalf. A link points either at a URL the customer supplied or at a file Sent hosts for them;
     * LinkKind says which. Delivered when an eligible request is served, or when a
     * published link reaches the end of its life.
     *
     * A click is a request, not a read receipt. link.clicked means the redirect
     * was served; link.downloaded means bytes went out. Neither proves a person saw anything —
     * messaging providers and link scanners fetch URLs on their own, which is what
     * TrafficClass exists to tell apart. Filter on it before reporting a click-through
     * rate; treat likely_human as a hint, never as delivery confirmation.
     *
     * RecordId identifies the link; the X-Webhook-Event-ID header
     * identifies the delivery. One link is hit many times, so those are the two keys a
     * subscriber needs: group by the first, deduplicate on the second — exactly as on every other
     * family. The payload carries no event identifier of its own, for the same reason none of the
     * others do.
     *
     * Nothing here identifies the visitor. No IP address and no visitor token crosses
     * this boundary. Country, Device and Browser are coarse
     * buckets derived at the edge and are absent whenever the request did not supply enough to derive
     * them.
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
     * Body of a link event: something happened to a tracked link Sent published on the customer's
     * behalf. A link points either at a URL the customer supplied or at a file Sent hosts for them;
     * LinkKind says which. Delivered when an eligible request is served, or when a
     * published link reaches the end of its life.
     *
     * A click is a request, not a read receipt. link.clicked means the redirect
     * was served; link.downloaded means bytes went out. Neither proves a person saw anything —
     * messaging providers and link scanners fetch URLs on their own, which is what
     * TrafficClass exists to tell apart. Filter on it before reporting a click-through
     * rate; treat likely_human as a hint, never as delivery confirmation.
     *
     * RecordId identifies the link; the X-Webhook-Event-ID header
     * identifies the delivery. One link is hit many times, so those are the two keys a
     * subscriber needs: group by the first, deduplicate on the second — exactly as on every other
     * family. The payload carries no event identifier of its own, for the same reason none of the
     * others do.
     *
     * Nothing here identifies the visitor. No IP address and no visitor token crosses
     * this boundary. Country, Device and Browser are coarse
     * buckets derived at the edge and are absent whenever the request did not supply enough to derive
     * them.
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
