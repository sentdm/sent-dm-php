<?php

declare(strict_types=1);

namespace SentDm\Lookup\LookupGetPhoneInfoResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The response data (null if error).
 *
 * @phpstan-type DataShape = array{
 *   carrierName?: string|null,
 *   isPorted?: bool|null,
 *   isValid?: bool|null,
 *   isVoip?: bool|null,
 *   lineType?: string|null,
 *   mobileCountryCode?: string|null,
 *   mobileNetworkCode?: string|null,
 *   phoneNumber?: string|null,
 *   provider?: string|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    #[Optional(nullable: true)]
    public ?string $carrierName;

    #[Optional(nullable: true)]
    public ?bool $isPorted;

    #[Optional]
    public ?bool $isValid;

    #[Optional(nullable: true)]
    public ?bool $isVoip;

    #[Optional(nullable: true)]
    public ?string $lineType;

    #[Optional(nullable: true)]
    public ?string $mobileCountryCode;

    #[Optional(nullable: true)]
    public ?string $mobileNetworkCode;

    #[Optional]
    public ?string $phoneNumber;

    #[Optional]
    public ?string $provider;

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
        ?string $carrierName = null,
        ?bool $isPorted = null,
        ?bool $isValid = null,
        ?bool $isVoip = null,
        ?string $lineType = null,
        ?string $mobileCountryCode = null,
        ?string $mobileNetworkCode = null,
        ?string $phoneNumber = null,
        ?string $provider = null,
    ): self {
        $self = new self;

        null !== $carrierName && $self['carrierName'] = $carrierName;
        null !== $isPorted && $self['isPorted'] = $isPorted;
        null !== $isValid && $self['isValid'] = $isValid;
        null !== $isVoip && $self['isVoip'] = $isVoip;
        null !== $lineType && $self['lineType'] = $lineType;
        null !== $mobileCountryCode && $self['mobileCountryCode'] = $mobileCountryCode;
        null !== $mobileNetworkCode && $self['mobileNetworkCode'] = $mobileNetworkCode;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $provider && $self['provider'] = $provider;

        return $self;
    }

    public function withCarrierName(?string $carrierName): self
    {
        $self = clone $this;
        $self['carrierName'] = $carrierName;

        return $self;
    }

    public function withIsPorted(?bool $isPorted): self
    {
        $self = clone $this;
        $self['isPorted'] = $isPorted;

        return $self;
    }

    public function withIsValid(bool $isValid): self
    {
        $self = clone $this;
        $self['isValid'] = $isValid;

        return $self;
    }

    public function withIsVoip(?bool $isVoip): self
    {
        $self = clone $this;
        $self['isVoip'] = $isVoip;

        return $self;
    }

    public function withLineType(?string $lineType): self
    {
        $self = clone $this;
        $self['lineType'] = $lineType;

        return $self;
    }

    public function withMobileCountryCode(?string $mobileCountryCode): self
    {
        $self = clone $this;
        $self['mobileCountryCode'] = $mobileCountryCode;

        return $self;
    }

    public function withMobileNetworkCode(?string $mobileNetworkCode): self
    {
        $self = clone $this;
        $self['mobileNetworkCode'] = $mobileNetworkCode;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withProvider(string $provider): self
    {
        $self = clone $this;
        $self['provider'] = $provider;

        return $self;
    }
}
