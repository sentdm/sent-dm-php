<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetActivitiesResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A single message activity event for v3 API.
 *
 * The activity list mixes statuses, so unlike a message it is one shape rather than two: a SCHEDULED
 * entry carries scheduled_at, and every other entry has no such key.
 *
 * @phpstan-type ActivityShape = array{
 *   activeContactPrice?: string|null,
 *   description?: string|null,
 *   from?: string|null,
 *   price?: string|null,
 *   reason?: string|null,
 *   reasonCode?: string|null,
 *   scheduledAt?: \DateTimeInterface|null,
 *   status?: string|null,
 *   timestamp?: \DateTimeInterface|null,
 * }
 */
final class Activity implements BaseModel
{
    /** @use SdkModel<ActivityShape> */
    use SdkModel;

    /**
     * Active contact markup applied on top of the channel cost, formatted to 4 decimal places.
     */
    #[Optional('active_contact_price', nullable: true)]
    public ?string $activeContactPrice;

    /**
     * Human-readable description of the activity.
     */
    #[Optional]
    public ?string $description;

    /**
     * Sender phone number for this activity (the customer's sending number for outbound, the external sender for inbound). Null when not reported by the provider.
     */
    #[Optional(nullable: true)]
    public ?string $from;

    /**
     * Channel cost for this activity (e.g., SMS/WhatsApp provider cost), formatted to 4 decimal places.
     */
    #[Optional(nullable: true)]
    public ?string $price;

    /**
     * A human-readable sentence for reason_code, for example "The recipient is not registered on this channel"
     * Omitted whenever reason_code is.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * Why the message reached this status, as a stable platform code such as DELIVERY_007
     * or BUSINESS_003. Present on FAILED, FILTERED and BLOCKED activities;
     * omitted on every status that needs no explanation. Switch on this rather than on reason: the code
     * is stable, the wording may be improved. Same wire name and vocabulary as on the message and the webhook.
     */
    #[Optional('reason_code', nullable: true)]
    public ?string $reasonCode;

    /**
     * SCHEDULED activities only: when the held message will be released for delivery, in UTC. Same wire name
     * as on the send response, the message and the webhook. Omitted on every other activity. A message that quiet
     * hours moved at release has two SCHEDULED entries, each carrying the instant as it stood at that moment.
     */
    #[Optional('scheduled_at', nullable: true)]
    public ?\DateTimeInterface $scheduledAt;

    /**
     * Activity status. Outbound: QUEUED, PROCESSED, ROUTED, SCHEDULED, SENT, DELIVERED, READ, FAILED.
     * Inbound (from contact): RECEIVED (terminal).
     */
    #[Optional]
    public ?string $status;

    /**
     * When this activity occurred.
     */
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
        ?string $activeContactPrice = null,
        ?string $description = null,
        ?string $from = null,
        ?string $price = null,
        ?string $reason = null,
        ?string $reasonCode = null,
        ?\DateTimeInterface $scheduledAt = null,
        ?string $status = null,
        ?\DateTimeInterface $timestamp = null,
    ): self {
        $self = new self;

        null !== $activeContactPrice && $self['activeContactPrice'] = $activeContactPrice;
        null !== $description && $self['description'] = $description;
        null !== $from && $self['from'] = $from;
        null !== $price && $self['price'] = $price;
        null !== $reason && $self['reason'] = $reason;
        null !== $reasonCode && $self['reasonCode'] = $reasonCode;
        null !== $scheduledAt && $self['scheduledAt'] = $scheduledAt;
        null !== $status && $self['status'] = $status;
        null !== $timestamp && $self['timestamp'] = $timestamp;

        return $self;
    }

    /**
     * Active contact markup applied on top of the channel cost, formatted to 4 decimal places.
     */
    public function withActiveContactPrice(?string $activeContactPrice): self
    {
        $self = clone $this;
        $self['activeContactPrice'] = $activeContactPrice;

        return $self;
    }

    /**
     * Human-readable description of the activity.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Sender phone number for this activity (the customer's sending number for outbound, the external sender for inbound). Null when not reported by the provider.
     */
    public function withFrom(?string $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * Channel cost for this activity (e.g., SMS/WhatsApp provider cost), formatted to 4 decimal places.
     */
    public function withPrice(?string $price): self
    {
        $self = clone $this;
        $self['price'] = $price;

        return $self;
    }

    /**
     * A human-readable sentence for reason_code, for example "The recipient is not registered on this channel"
     * Omitted whenever reason_code is.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the message reached this status, as a stable platform code such as DELIVERY_007
     * or BUSINESS_003. Present on FAILED, FILTERED and BLOCKED activities;
     * omitted on every status that needs no explanation. Switch on this rather than on reason: the code
     * is stable, the wording may be improved. Same wire name and vocabulary as on the message and the webhook.
     */
    public function withReasonCode(?string $reasonCode): self
    {
        $self = clone $this;
        $self['reasonCode'] = $reasonCode;

        return $self;
    }

    /**
     * SCHEDULED activities only: when the held message will be released for delivery, in UTC. Same wire name
     * as on the send response, the message and the webhook. Omitted on every other activity. A message that quiet
     * hours moved at release has two SCHEDULED entries, each carrying the instant as it stood at that moment.
     */
    public function withScheduledAt(?\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * Activity status. Outbound: QUEUED, PROCESSED, ROUTED, SCHEDULED, SENT, DELIVERED, READ, FAILED.
     * Inbound (from contact): RECEIVED (terminal).
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When this activity occurred.
     */
    public function withTimestamp(\DateTimeInterface $timestamp): self
    {
        $self = clone $this;
        $self['timestamp'] = $timestamp;

        return $self;
    }
}
