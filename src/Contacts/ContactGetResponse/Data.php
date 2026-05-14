<?php

declare(strict_types=1);

namespace SentDm\Contacts\ContactGetResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Contact response for v3 API
 * Uses snake_case for JSON property names.
 *
 * @phpstan-type DataShape = array{
 *   id?: string|null,
 *   availableChannels?: string|null,
 *   countryCode?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   defaultChannel?: string|null,
 *   formatE164?: string|null,
 *   formatInternational?: string|null,
 *   formatNational?: string|null,
 *   formatRfc?: string|null,
 *   isInherited?: bool|null,
 *   optOut?: bool|null,
 *   phoneNumber?: string|null,
 *   regionCode?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Unique identifier for the contact.
     */
    #[Optional]
    public ?string $id;

    /**
     * Comma-separated list of available messaging channels (e.g., "sms,whatsapp").
     */
    #[Optional('available_channels')]
    public ?string $availableChannels;

    /**
     * Country calling code (e.g., 1 for US/Canada).
     */
    #[Optional('country_code')]
    public ?string $countryCode;

    /**
     * When the contact was created.
     */
    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * Default messaging channel to use (e.g., "sms" or "whatsapp").
     */
    #[Optional('default_channel')]
    public ?string $defaultChannel;

    /**
     * Phone number in E.164 format (e.g., +1234567890).
     */
    #[Optional('format_e164')]
    public ?string $formatE164;

    /**
     * Phone number in international format (e.g., +1 234-567-890).
     */
    #[Optional('format_international')]
    public ?string $formatInternational;

    /**
     * Phone number in national format (e.g., (234) 567-890).
     */
    #[Optional('format_national')]
    public ?string $formatNational;

    /**
     * Phone number in RFC 3966 format (e.g., tel:+1-234-567-890).
     */
    #[Optional('format_rfc')]
    public ?string $formatRfc;

    /**
     * Whether this is an inherited contact (read-only).
     */
    #[Optional('is_inherited')]
    public ?bool $isInherited;

    /**
     * Whether the contact has opted out of messaging. Single source of truth — opt-out is
     * per-contact, not per-channel.
     */
    #[Optional('opt_out')]
    public ?bool $optOut;

    /**
     * Phone number in original format.
     */
    #[Optional('phone_number')]
    public ?string $phoneNumber;

    /**
     * ISO 3166-1 alpha-2 country code (e.g., US, CA, GB).
     */
    #[Optional('region_code')]
    public ?string $regionCode;

    /**
     * When the contact was last updated.
     */
    #[Optional('updated_at', nullable: true)]
    public ?\DateTimeInterface $updatedAt;

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
        ?\DateTimeInterface $createdAt = null,
        ?string $defaultChannel = null,
        ?string $formatE164 = null,
        ?string $formatInternational = null,
        ?string $formatNational = null,
        ?string $formatRfc = null,
        ?bool $isInherited = null,
        ?bool $optOut = null,
        ?string $phoneNumber = null,
        ?string $regionCode = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $availableChannels && $self['availableChannels'] = $availableChannels;
        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $defaultChannel && $self['defaultChannel'] = $defaultChannel;
        null !== $formatE164 && $self['formatE164'] = $formatE164;
        null !== $formatInternational && $self['formatInternational'] = $formatInternational;
        null !== $formatNational && $self['formatNational'] = $formatNational;
        null !== $formatRfc && $self['formatRfc'] = $formatRfc;
        null !== $isInherited && $self['isInherited'] = $isInherited;
        null !== $optOut && $self['optOut'] = $optOut;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $regionCode && $self['regionCode'] = $regionCode;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Unique identifier for the contact.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Comma-separated list of available messaging channels (e.g., "sms,whatsapp").
     */
    public function withAvailableChannels(string $availableChannels): self
    {
        $self = clone $this;
        $self['availableChannels'] = $availableChannels;

        return $self;
    }

    /**
     * Country calling code (e.g., 1 for US/Canada).
     */
    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    /**
     * When the contact was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Default messaging channel to use (e.g., "sms" or "whatsapp").
     */
    public function withDefaultChannel(string $defaultChannel): self
    {
        $self = clone $this;
        $self['defaultChannel'] = $defaultChannel;

        return $self;
    }

    /**
     * Phone number in E.164 format (e.g., +1234567890).
     */
    public function withFormatE164(string $formatE164): self
    {
        $self = clone $this;
        $self['formatE164'] = $formatE164;

        return $self;
    }

    /**
     * Phone number in international format (e.g., +1 234-567-890).
     */
    public function withFormatInternational(string $formatInternational): self
    {
        $self = clone $this;
        $self['formatInternational'] = $formatInternational;

        return $self;
    }

    /**
     * Phone number in national format (e.g., (234) 567-890).
     */
    public function withFormatNational(string $formatNational): self
    {
        $self = clone $this;
        $self['formatNational'] = $formatNational;

        return $self;
    }

    /**
     * Phone number in RFC 3966 format (e.g., tel:+1-234-567-890).
     */
    public function withFormatRfc(string $formatRfc): self
    {
        $self = clone $this;
        $self['formatRfc'] = $formatRfc;

        return $self;
    }

    /**
     * Whether this is an inherited contact (read-only).
     */
    public function withIsInherited(bool $isInherited): self
    {
        $self = clone $this;
        $self['isInherited'] = $isInherited;

        return $self;
    }

    /**
     * Whether the contact has opted out of messaging. Single source of truth — opt-out is
     * per-contact, not per-channel.
     */
    public function withOptOut(bool $optOut): self
    {
        $self = clone $this;
        $self['optOut'] = $optOut;

        return $self;
    }

    /**
     * Phone number in original format.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * ISO 3166-1 alpha-2 country code (e.g., US, CA, GB).
     */
    public function withRegionCode(string $regionCode): self
    {
        $self = clone $this;
        $self['regionCode'] = $regionCode;

        return $self;
    }

    /**
     * When the contact was last updated.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
