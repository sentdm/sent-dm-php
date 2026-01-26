<?php

declare(strict_types=1);

namespace SentDm\NumberLookup;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Response containing phone number lookup data.
 *
 * @phpstan-type NumberLookupGetResponseShape = array{
 *   countryCode?: string|null,
 *   formatE164?: string|null,
 *   formatInternational?: string|null,
 *   formatNational?: string|null,
 *   formatRfc?: string|null,
 *   numberType?: string|null,
 *   phoneNumber?: string|null,
 *   phoneTimezones?: string|null,
 *   regionCode?: string|null,
 * }
 */
final class NumberLookupGetResponse implements BaseModel
{
    /** @use SdkModel<NumberLookupGetResponseShape> */
    use SdkModel;

    /**
     * The country calling code (e.g., 1 for US/Canada).
     */
    #[Optional]
    public ?string $countryCode;

    /**
     * The phone number formatted in E.164 standard (e.g., +1234567890).
     */
    #[Optional]
    public ?string $formatE164;

    /**
     * The phone number formatted for international dialing (e.g., +1 234-567-890).
     */
    #[Optional]
    public ?string $formatInternational;

    /**
     * The phone number formatted for national dialing (e.g., (234) 567-890).
     */
    #[Optional]
    public ?string $formatNational;

    /**
     * The phone number formatted according to RFC 3966 (e.g., tel:+1-234-567-890).
     */
    #[Optional]
    public ?string $formatRfc;

    /**
     * The type of phone number (e.g., mobile, fixed_line, voip).
     */
    #[Optional]
    public ?string $numberType;

    /**
     * The phone number in its original format.
     */
    #[Optional]
    public ?string $phoneNumber;

    /**
     * The timezones associated with the phone number.
     */
    #[Optional]
    public ?string $phoneTimezones;

    /**
     * The ISO 3166-1 alpha-2 country code (e.g., US, CA, GB).
     */
    #[Optional]
    public ?string $regionCode;

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
        ?string $countryCode = null,
        ?string $formatE164 = null,
        ?string $formatInternational = null,
        ?string $formatNational = null,
        ?string $formatRfc = null,
        ?string $numberType = null,
        ?string $phoneNumber = null,
        ?string $phoneTimezones = null,
        ?string $regionCode = null,
    ): self {
        $self = new self;

        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $formatE164 && $self['formatE164'] = $formatE164;
        null !== $formatInternational && $self['formatInternational'] = $formatInternational;
        null !== $formatNational && $self['formatNational'] = $formatNational;
        null !== $formatRfc && $self['formatRfc'] = $formatRfc;
        null !== $numberType && $self['numberType'] = $numberType;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $phoneTimezones && $self['phoneTimezones'] = $phoneTimezones;
        null !== $regionCode && $self['regionCode'] = $regionCode;

        return $self;
    }

    /**
     * The country calling code (e.g., 1 for US/Canada).
     */
    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    /**
     * The phone number formatted in E.164 standard (e.g., +1234567890).
     */
    public function withFormatE164(string $formatE164): self
    {
        $self = clone $this;
        $self['formatE164'] = $formatE164;

        return $self;
    }

    /**
     * The phone number formatted for international dialing (e.g., +1 234-567-890).
     */
    public function withFormatInternational(string $formatInternational): self
    {
        $self = clone $this;
        $self['formatInternational'] = $formatInternational;

        return $self;
    }

    /**
     * The phone number formatted for national dialing (e.g., (234) 567-890).
     */
    public function withFormatNational(string $formatNational): self
    {
        $self = clone $this;
        $self['formatNational'] = $formatNational;

        return $self;
    }

    /**
     * The phone number formatted according to RFC 3966 (e.g., tel:+1-234-567-890).
     */
    public function withFormatRfc(string $formatRfc): self
    {
        $self = clone $this;
        $self['formatRfc'] = $formatRfc;

        return $self;
    }

    /**
     * The type of phone number (e.g., mobile, fixed_line, voip).
     */
    public function withNumberType(string $numberType): self
    {
        $self = clone $this;
        $self['numberType'] = $numberType;

        return $self;
    }

    /**
     * The phone number in its original format.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * The timezones associated with the phone number.
     */
    public function withPhoneTimezones(string $phoneTimezones): self
    {
        $self = clone $this;
        $self['phoneTimezones'] = $phoneTimezones;

        return $self;
    }

    /**
     * The ISO 3166-1 alpha-2 country code (e.g., US, CA, GB).
     */
    public function withRegionCode(string $regionCode): self
    {
        $self = clone $this;
        $self['regionCode'] = $regionCode;

        return $self;
    }
}
