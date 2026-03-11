<?php

declare(strict_types=1);

namespace SentDm\Numbers\NumberLookupResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The response data (null if error).
 *
 * @phpstan-type DataShape = array{
 *   carrierName?: string|null,
 *   countryCode?: string|null,
 *   isPorted?: bool|null,
 *   isValid?: bool|null,
 *   isVoip?: bool|null,
 *   lineType?: string|null,
 *   mobileCountryCode?: string|null,
 *   mobileNetworkCode?: string|null,
 *   phoneNumber?: string|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    #[Optional('carrier_name', nullable: true)]
    public ?string $carrierName;

    #[Optional('country_code', nullable: true)]
    public ?string $countryCode;

    #[Optional('is_ported', nullable: true)]
    public ?bool $isPorted;

    #[Optional('is_valid')]
    public ?bool $isValid;

    #[Optional('is_voip', nullable: true)]
    public ?bool $isVoip;

    #[Optional('line_type', nullable: true)]
    public ?string $lineType;

    #[Optional('mobile_country_code', nullable: true)]
    public ?string $mobileCountryCode;

    #[Optional('mobile_network_code', nullable: true)]
    public ?string $mobileNetworkCode;

    #[Optional('phone_number')]
    public ?string $phoneNumber;

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
        ?string $countryCode = null,
        ?bool $isPorted = null,
        ?bool $isValid = null,
        ?bool $isVoip = null,
        ?string $lineType = null,
        ?string $mobileCountryCode = null,
        ?string $mobileNetworkCode = null,
        ?string $phoneNumber = null,
    ): self {
        $self = new self;

        null !== $carrierName && $self['carrierName'] = $carrierName;
        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $isPorted && $self['isPorted'] = $isPorted;
        null !== $isValid && $self['isValid'] = $isValid;
        null !== $isVoip && $self['isVoip'] = $isVoip;
        null !== $lineType && $self['lineType'] = $lineType;
        null !== $mobileCountryCode && $self['mobileCountryCode'] = $mobileCountryCode;
        null !== $mobileNetworkCode && $self['mobileNetworkCode'] = $mobileNetworkCode;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withCarrierName(?string $carrierName): self
    {
        $self = clone $this;
        $self['carrierName'] = $carrierName;

        return $self;
    }

    public function withCountryCode(?string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

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
}
