<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One entry of numbers: how many numbers to assign in one area code, or in any area code when
 * AreaCode is omitted.
 *
 * @phpstan-type SMSNumberRequestShape = array{
 *   areaCode?: string|null, quantity?: int|null
 * }
 */
final class SMSNumberRequest implements BaseModel
{
    /** @use SdkModel<SMSNumberRequestShape> */
    use SdkModel;

    /**
     * The area code, e.g. 212, validated against the request's country. Omit it for numbers in any
     * area code.
     */
    #[Optional('area_code', nullable: true)]
    public ?string $areaCode;

    /**
     * How many numbers. At least 1; omitted means 1.
     */
    #[Optional(nullable: true)]
    public ?int $quantity;

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
        ?string $areaCode = null,
        ?int $quantity = null
    ): self {
        $self = new self;

        null !== $areaCode && $self['areaCode'] = $areaCode;
        null !== $quantity && $self['quantity'] = $quantity;

        return $self;
    }

    /**
     * The area code, e.g. 212, validated against the request's country. Omit it for numbers in any
     * area code.
     */
    public function withAreaCode(?string $areaCode): self
    {
        $self = clone $this;
        $self['areaCode'] = $areaCode;

        return $self;
    }

    /**
     * How many numbers. At least 1; omitted means 1.
     */
    public function withQuantity(?int $quantity): self
    {
        $self = clone $this;
        $self['quantity'] = $quantity;

        return $self;
    }
}
