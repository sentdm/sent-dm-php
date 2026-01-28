<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Represents a contact in the customer's contact list.
 *
 * @phpstan-type ContactListItemShape = array{
 *   id?: string|null,
 *   availableChannels?: string|null,
 *   countryCode?: string|null,
 *   defaultChannel?: string|null,
 *   formatE164?: string|null,
 *   formatInternational?: string|null,
 *   formatNational?: string|null,
 *   formatRfc?: string|null,
 *   phoneNumber?: string|null,
 *   regionCode?: string|null,
 * }
 */
final class ContactListItem implements BaseModel
{
    /** @use SdkModel<ContactListItemShape> */
    use SdkModel;

    /**
     * The unique identifier of the contact.
     */
    #[Optional]
    public ?string $id;

    /**
     * Comma-separated list of available messaging channels for this contact (e.g., "sms,whatsapp").
     */
    #[Optional]
    public ?string $availableChannels;

    /**
     * The country calling code (e.g., 1 for US/Canada).
     */
    #[Optional]
    public ?string $countryCode;

    /**
     * The default messaging channel to use for this contact (e.g., "sms" or "whatsapp").
     */
    #[Optional]
    public ?string $defaultChannel;

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
     * The phone number in its original format.
     */
    #[Optional]
    public ?string $phoneNumber;

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
        ?string $id = null,
        ?string $availableChannels = null,
        ?string $countryCode = null,
        ?string $defaultChannel = null,
        ?string $formatE164 = null,
        ?string $formatInternational = null,
        ?string $formatNational = null,
        ?string $formatRfc = null,
        ?string $phoneNumber = null,
        ?string $regionCode = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $availableChannels && $self['availableChannels'] = $availableChannels;
        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $defaultChannel && $self['defaultChannel'] = $defaultChannel;
        null !== $formatE164 && $self['formatE164'] = $formatE164;
        null !== $formatInternational && $self['formatInternational'] = $formatInternational;
        null !== $formatNational && $self['formatNational'] = $formatNational;
        null !== $formatRfc && $self['formatRfc'] = $formatRfc;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $regionCode && $self['regionCode'] = $regionCode;

        return $self;
    }

    /**
     * The unique identifier of the contact.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Comma-separated list of available messaging channels for this contact (e.g., "sms,whatsapp").
     */
    public function withAvailableChannels(string $availableChannels): self
    {
        $self = clone $this;
        $self['availableChannels'] = $availableChannels;

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
     * The default messaging channel to use for this contact (e.g., "sms" or "whatsapp").
     */
    public function withDefaultChannel(string $defaultChannel): self
    {
        $self = clone $this;
        $self['defaultChannel'] = $defaultChannel;

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
     * The phone number in its original format.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

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
