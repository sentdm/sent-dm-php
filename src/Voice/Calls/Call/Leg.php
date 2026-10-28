<?php

declare(strict_types=1);

namespace SentDm\Voice\Calls\Call;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One leg of a call the price covers.
 *
 * @phpstan-type LegShape = array{
 *   billedMinutes?: int|null,
 *   cost?: float|null,
 *   currency?: string|null,
 *   direction?: string|null,
 *   number?: string|null,
 * }
 */
final class Leg implements BaseModel
{
    /** @use SdkModel<LegShape> */
    use SdkModel;

    /**
     * The whole minutes the leg was billed for.
     */
    #[Optional('billed_minutes')]
    public ?int $billedMinutes;

    /**
     * What the leg cost, in the same unit as the call's price.
     */
    #[Optional]
    public ?float $cost;

    /**
     * The currency of the cost: USD.
     */
    #[Optional]
    public ?string $currency;

    /**
     * inbound for the caller's leg to your number, outbound for a leg placed on your behalf.
     */
    #[Optional]
    public ?string $direction;

    /**
     * The phone number the leg reached, in E.164 format: your number for the inbound leg, the number dialed for an outbound one. Null for a leg to one of your app users or a room.
     */
    #[Optional(nullable: true)]
    public ?string $number;

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
        ?int $billedMinutes = null,
        ?float $cost = null,
        ?string $currency = null,
        ?string $direction = null,
        ?string $number = null,
    ): self {
        $self = new self;

        null !== $billedMinutes && $self['billedMinutes'] = $billedMinutes;
        null !== $cost && $self['cost'] = $cost;
        null !== $currency && $self['currency'] = $currency;
        null !== $direction && $self['direction'] = $direction;
        null !== $number && $self['number'] = $number;

        return $self;
    }

    /**
     * The whole minutes the leg was billed for.
     */
    public function withBilledMinutes(int $billedMinutes): self
    {
        $self = clone $this;
        $self['billedMinutes'] = $billedMinutes;

        return $self;
    }

    /**
     * What the leg cost, in the same unit as the call's price.
     */
    public function withCost(float $cost): self
    {
        $self = clone $this;
        $self['cost'] = $cost;

        return $self;
    }

    /**
     * The currency of the cost: USD.
     */
    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * inbound for the caller's leg to your number, outbound for a leg placed on your behalf.
     */
    public function withDirection(string $direction): self
    {
        $self = clone $this;
        $self['direction'] = $direction;

        return $self;
    }

    /**
     * The phone number the leg reached, in E.164 format: your number for the inbound leg, the number dialed for an outbound one. Null for a leg to one of your app users or a room.
     */
    public function withNumber(?string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }
}
