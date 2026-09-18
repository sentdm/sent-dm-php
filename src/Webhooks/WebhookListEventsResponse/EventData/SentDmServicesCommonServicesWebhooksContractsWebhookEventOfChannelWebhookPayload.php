<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse\EventData;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfChannelWebhookPayload\Payload;

/**
 * The envelope Sent POSTs to a subscribed webhook endpoint. Every event shares this shape and
 * varies only in Payload.
 *
 * @phpstan-import-type PayloadShape from \SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfChannelWebhookPayload\Payload
 *
 * @phpstan-type SentDmServicesCommonServicesWebhooksContractsWebhookEventOfChannelWebhookPayloadShape = array{
 *   event?: string|null,
 *   field?: string|null,
 *   payload?: null|Payload|PayloadShape,
 *   requestID?: string|null,
 *   timestamp?: string|null,
 * }
 */
final class SentDmServicesCommonServicesWebhooksContractsWebhookEventOfChannelWebhookPayload implements BaseModel
{
    /**
     * @use SdkModel<SentDmServicesCommonServicesWebhooksContractsWebhookEventOfChannelWebhookPayloadShape>
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
     * Body of a channel event: where one of the customer's channels stands in provisioning and
     * compliance. Delivered when a milestone moves — a registration filed, a verdict returned, a
     * resubmission asked for, a sender gone live — so a customer's own onboarding UI does not have to
     * poll GET /v3/channels.
     *
     * The subject is one item, never the account. A customer's "SMS channel" has no
     * status; a market does. Country, NumberType and
     * SenderValue name which one, so a customer terminating only to Kosovo never
     * receives an event about US 10DLC.
     *
     * Status is the stable half of the contract. It is the same four-value
     * set GET /v3/channels publishes, computed through the same code, so an event and a read of
     * the same market cannot disagree. A subscriber that reads nothing but the status and the subject
     * fields is a correct subscriber. The sub-type on the envelope names the specific milestone and is
     * additive — that vocabulary comes from registries and carriers, which are parties Sent does not
     * control.
     *
     * Status means provisioning and compliance are complete, not that a send
     * will succeed right now. An account can be suspended, or a destination blocked by a routing
     * rule, without either showing up here. Those are separate surfaces and deliberately not modelled
     * on this payload.
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
     * Body of a channel event: where one of the customer's channels stands in provisioning and
     * compliance. Delivered when a milestone moves — a registration filed, a verdict returned, a
     * resubmission asked for, a sender gone live — so a customer's own onboarding UI does not have to
     * poll GET /v3/channels.
     *
     * The subject is one item, never the account. A customer's "SMS channel" has no
     * status; a market does. Country, NumberType and
     * SenderValue name which one, so a customer terminating only to Kosovo never
     * receives an event about US 10DLC.
     *
     * Status is the stable half of the contract. It is the same four-value
     * set GET /v3/channels publishes, computed through the same code, so an event and a read of
     * the same market cannot disagree. A subscriber that reads nothing but the status and the subject
     * fields is a correct subscriber. The sub-type on the envelope names the specific milestone and is
     * additive — that vocabulary comes from registries and carriers, which are parties Sent does not
     * control.
     *
     * Status means provisioning and compliance are complete, not that a send
     * will succeed right now. An account can be suspended, or a destination blocked by a routing
     * rule, without either showing up here. Those are separate surfaces and deliberately not modelled
     * on this payload.
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
