<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetActivitiesResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A single message activity event for v3 API.
 *
 * @phpstan-type ActivityShape = array{
 *   activeContactPrice?: string|null,
 *   description?: string|null,
 *   from?: string|null,
 *   price?: string|null,
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
     * Activity status. Outbound: QUEUED, PROCESSED, ROUTED, SENT, DELIVERED, READ, FAILED.
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
        ?string $status = null,
        ?\DateTimeInterface $timestamp = null,
    ): self {
        $self = new self;

        null !== $activeContactPrice && $self['activeContactPrice'] = $activeContactPrice;
        null !== $description && $self['description'] = $description;
        null !== $from && $self['from'] = $from;
        null !== $price && $self['price'] = $price;
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
     * Activity status. Outbound: QUEUED, PROCESSED, ROUTED, SENT, DELIVERED, READ, FAILED.
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
