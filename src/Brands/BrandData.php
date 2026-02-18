<?php

declare(strict_types=1);

namespace SentDm\Brands;

use SentDm\Brands\BrandData\EntityType;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Brand and KYC data.
 *
 * @phpstan-import-type DestinationCountryShape from \SentDm\Brands\DestinationCountry
 *
 * @phpstan-type BrandDataShape = array{
 *   brandRelationship: TcrBrandRelationship|value-of<TcrBrandRelationship>,
 *   contactName: string,
 *   vertical: TcrVertical|value-of<TcrVertical>,
 *   brandName?: string|null,
 *   businessLegalName?: string|null,
 *   businessName?: string|null,
 *   businessRole?: string|null,
 *   businessURL?: string|null,
 *   city?: string|null,
 *   contactEmail?: string|null,
 *   contactPhone?: string|null,
 *   contactPhoneCountryCode?: string|null,
 *   country?: string|null,
 *   countryOfRegistration?: string|null,
 *   destinationCountries?: list<DestinationCountry|DestinationCountryShape>|null,
 *   entityType?: null|EntityType|value-of<EntityType>,
 *   expectedMessagingVolume?: string|null,
 *   isTcrApplication?: bool|null,
 *   notes?: string|null,
 *   phoneNumberPrefix?: string|null,
 *   postalCode?: string|null,
 *   primaryUseCase?: string|null,
 *   state?: string|null,
 *   street?: string|null,
 *   taxID?: string|null,
 *   taxIDType?: string|null,
 * }
 */
final class BrandData implements BaseModel
{
    /** @use SdkModel<BrandDataShape> */
    use SdkModel;

    /**
     * Brand relationship level with TCR (required for TCR).
     *
     * @var value-of<TcrBrandRelationship> $brandRelationship
     */
    #[Required(enum: TcrBrandRelationship::class)]
    public string $brandRelationship;

    /**
     * Primary contact name (required).
     */
    #[Required]
    public string $contactName;

    /**
     * Business vertical/industry category (required for TCR).
     *
     * @var value-of<TcrVertical> $vertical
     */
    #[Required(enum: TcrVertical::class)]
    public string $vertical;

    /**
     * Brand name for KYC submission.
     */
    #[Optional(nullable: true)]
    public ?string $brandName;

    /**
     * Legal business name.
     */
    #[Optional(nullable: true)]
    public ?string $businessLegalName;

    /**
     * Business/brand name.
     */
    #[Optional(nullable: true)]
    public ?string $businessName;

    /**
     * Contact's role in the business.
     */
    #[Optional(nullable: true)]
    public ?string $businessRole;

    /**
     * Business website URL.
     */
    #[Optional('businessUrl', nullable: true)]
    public ?string $businessURL;

    /**
     * City.
     */
    #[Optional(nullable: true)]
    public ?string $city;

    /**
     * Contact email address.
     */
    #[Optional(nullable: true)]
    public ?string $contactEmail;

    /**
     * Contact phone number in E.164 format.
     */
    #[Optional(nullable: true)]
    public ?string $contactPhone;

    /**
     * Contact phone country code (e.g., "1" for US).
     */
    #[Optional(nullable: true)]
    public ?string $contactPhoneCountryCode;

    /**
     * Country code (e.g., US, CA).
     */
    #[Optional(nullable: true)]
    public ?string $country;

    /**
     * Country where the business is registered.
     */
    #[Optional(nullable: true)]
    public ?string $countryOfRegistration;

    /**
     * List of destination countries for messaging.
     *
     * @var list<DestinationCountry>|null $destinationCountries
     */
    #[Optional(list: DestinationCountry::class, nullable: true)]
    public ?array $destinationCountries;

    /**
     * Business entity type.
     *
     * @var value-of<EntityType>|null $entityType
     */
    #[Optional(enum: EntityType::class, nullable: true)]
    public ?string $entityType;

    /**
     * Expected daily messaging volume.
     */
    #[Optional(nullable: true)]
    public ?string $expectedMessagingVolume;

    /**
     * Whether this is a TCR (Campaign Registry) application.
     */
    #[Optional(nullable: true)]
    public ?bool $isTcrApplication;

    /**
     * Additional notes about the business or use case.
     */
    #[Optional(nullable: true)]
    public ?string $notes;

    /**
     * Phone number prefix for messaging (e.g., "+1").
     */
    #[Optional(nullable: true)]
    public ?string $phoneNumberPrefix;

    /**
     * Postal/ZIP code.
     */
    #[Optional(nullable: true)]
    public ?string $postalCode;

    /**
     * Primary messaging use case description.
     */
    #[Optional(nullable: true)]
    public ?string $primaryUseCase;

    /**
     * State/province code.
     */
    #[Optional(nullable: true)]
    public ?string $state;

    /**
     * Street address.
     */
    #[Optional(nullable: true)]
    public ?string $street;

    /**
     * Tax ID/EIN number.
     */
    #[Optional('taxId', nullable: true)]
    public ?string $taxID;

    /**
     * Type of tax ID (e.g., us_ein, ca_bn).
     */
    #[Optional('taxIdType', nullable: true)]
    public ?string $taxIDType;

    /**
     * `new BrandData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandData::with(brandRelationship: ..., contactName: ..., vertical: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandData)
     *   ->withBrandRelationship(...)
     *   ->withContactName(...)
     *   ->withVertical(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TcrBrandRelationship|value-of<TcrBrandRelationship> $brandRelationship
     * @param TcrVertical|value-of<TcrVertical> $vertical
     * @param list<DestinationCountry|DestinationCountryShape>|null $destinationCountries
     * @param EntityType|value-of<EntityType>|null $entityType
     */
    public static function with(
        TcrBrandRelationship|string $brandRelationship,
        string $contactName,
        TcrVertical|string $vertical,
        ?string $brandName = null,
        ?string $businessLegalName = null,
        ?string $businessName = null,
        ?string $businessRole = null,
        ?string $businessURL = null,
        ?string $city = null,
        ?string $contactEmail = null,
        ?string $contactPhone = null,
        ?string $contactPhoneCountryCode = null,
        ?string $country = null,
        ?string $countryOfRegistration = null,
        ?array $destinationCountries = null,
        EntityType|string|null $entityType = null,
        ?string $expectedMessagingVolume = null,
        ?bool $isTcrApplication = null,
        ?string $notes = null,
        ?string $phoneNumberPrefix = null,
        ?string $postalCode = null,
        ?string $primaryUseCase = null,
        ?string $state = null,
        ?string $street = null,
        ?string $taxID = null,
        ?string $taxIDType = null,
    ): self {
        $self = new self;

        $self['brandRelationship'] = $brandRelationship;
        $self['contactName'] = $contactName;
        $self['vertical'] = $vertical;

        null !== $brandName && $self['brandName'] = $brandName;
        null !== $businessLegalName && $self['businessLegalName'] = $businessLegalName;
        null !== $businessName && $self['businessName'] = $businessName;
        null !== $businessRole && $self['businessRole'] = $businessRole;
        null !== $businessURL && $self['businessURL'] = $businessURL;
        null !== $city && $self['city'] = $city;
        null !== $contactEmail && $self['contactEmail'] = $contactEmail;
        null !== $contactPhone && $self['contactPhone'] = $contactPhone;
        null !== $contactPhoneCountryCode && $self['contactPhoneCountryCode'] = $contactPhoneCountryCode;
        null !== $country && $self['country'] = $country;
        null !== $countryOfRegistration && $self['countryOfRegistration'] = $countryOfRegistration;
        null !== $destinationCountries && $self['destinationCountries'] = $destinationCountries;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $expectedMessagingVolume && $self['expectedMessagingVolume'] = $expectedMessagingVolume;
        null !== $isTcrApplication && $self['isTcrApplication'] = $isTcrApplication;
        null !== $notes && $self['notes'] = $notes;
        null !== $phoneNumberPrefix && $self['phoneNumberPrefix'] = $phoneNumberPrefix;
        null !== $postalCode && $self['postalCode'] = $postalCode;
        null !== $primaryUseCase && $self['primaryUseCase'] = $primaryUseCase;
        null !== $state && $self['state'] = $state;
        null !== $street && $self['street'] = $street;
        null !== $taxID && $self['taxID'] = $taxID;
        null !== $taxIDType && $self['taxIDType'] = $taxIDType;

        return $self;
    }

    /**
     * Brand relationship level with TCR (required for TCR).
     *
     * @param TcrBrandRelationship|value-of<TcrBrandRelationship> $brandRelationship
     */
    public function withBrandRelationship(
        TcrBrandRelationship|string $brandRelationship
    ): self {
        $self = clone $this;
        $self['brandRelationship'] = $brandRelationship;

        return $self;
    }

    /**
     * Primary contact name (required).
     */
    public function withContactName(string $contactName): self
    {
        $self = clone $this;
        $self['contactName'] = $contactName;

        return $self;
    }

    /**
     * Business vertical/industry category (required for TCR).
     *
     * @param TcrVertical|value-of<TcrVertical> $vertical
     */
    public function withVertical(TcrVertical|string $vertical): self
    {
        $self = clone $this;
        $self['vertical'] = $vertical;

        return $self;
    }

    /**
     * Brand name for KYC submission.
     */
    public function withBrandName(?string $brandName): self
    {
        $self = clone $this;
        $self['brandName'] = $brandName;

        return $self;
    }

    /**
     * Legal business name.
     */
    public function withBusinessLegalName(?string $businessLegalName): self
    {
        $self = clone $this;
        $self['businessLegalName'] = $businessLegalName;

        return $self;
    }

    /**
     * Business/brand name.
     */
    public function withBusinessName(?string $businessName): self
    {
        $self = clone $this;
        $self['businessName'] = $businessName;

        return $self;
    }

    /**
     * Contact's role in the business.
     */
    public function withBusinessRole(?string $businessRole): self
    {
        $self = clone $this;
        $self['businessRole'] = $businessRole;

        return $self;
    }

    /**
     * Business website URL.
     */
    public function withBusinessURL(?string $businessURL): self
    {
        $self = clone $this;
        $self['businessURL'] = $businessURL;

        return $self;
    }

    /**
     * City.
     */
    public function withCity(?string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    /**
     * Contact email address.
     */
    public function withContactEmail(?string $contactEmail): self
    {
        $self = clone $this;
        $self['contactEmail'] = $contactEmail;

        return $self;
    }

    /**
     * Contact phone number in E.164 format.
     */
    public function withContactPhone(?string $contactPhone): self
    {
        $self = clone $this;
        $self['contactPhone'] = $contactPhone;

        return $self;
    }

    /**
     * Contact phone country code (e.g., "1" for US).
     */
    public function withContactPhoneCountryCode(
        ?string $contactPhoneCountryCode
    ): self {
        $self = clone $this;
        $self['contactPhoneCountryCode'] = $contactPhoneCountryCode;

        return $self;
    }

    /**
     * Country code (e.g., US, CA).
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Country where the business is registered.
     */
    public function withCountryOfRegistration(
        ?string $countryOfRegistration
    ): self {
        $self = clone $this;
        $self['countryOfRegistration'] = $countryOfRegistration;

        return $self;
    }

    /**
     * List of destination countries for messaging.
     *
     * @param list<DestinationCountry|DestinationCountryShape>|null $destinationCountries
     */
    public function withDestinationCountries(?array $destinationCountries): self
    {
        $self = clone $this;
        $self['destinationCountries'] = $destinationCountries;

        return $self;
    }

    /**
     * Business entity type.
     *
     * @param EntityType|value-of<EntityType>|null $entityType
     */
    public function withEntityType(EntityType|string|null $entityType): self
    {
        $self = clone $this;
        $self['entityType'] = $entityType;

        return $self;
    }

    /**
     * Expected daily messaging volume.
     */
    public function withExpectedMessagingVolume(
        ?string $expectedMessagingVolume
    ): self {
        $self = clone $this;
        $self['expectedMessagingVolume'] = $expectedMessagingVolume;

        return $self;
    }

    /**
     * Whether this is a TCR (Campaign Registry) application.
     */
    public function withIsTcrApplication(?bool $isTcrApplication): self
    {
        $self = clone $this;
        $self['isTcrApplication'] = $isTcrApplication;

        return $self;
    }

    /**
     * Additional notes about the business or use case.
     */
    public function withNotes(?string $notes): self
    {
        $self = clone $this;
        $self['notes'] = $notes;

        return $self;
    }

    /**
     * Phone number prefix for messaging (e.g., "+1").
     */
    public function withPhoneNumberPrefix(?string $phoneNumberPrefix): self
    {
        $self = clone $this;
        $self['phoneNumberPrefix'] = $phoneNumberPrefix;

        return $self;
    }

    /**
     * Postal/ZIP code.
     */
    public function withPostalCode(?string $postalCode): self
    {
        $self = clone $this;
        $self['postalCode'] = $postalCode;

        return $self;
    }

    /**
     * Primary messaging use case description.
     */
    public function withPrimaryUseCase(?string $primaryUseCase): self
    {
        $self = clone $this;
        $self['primaryUseCase'] = $primaryUseCase;

        return $self;
    }

    /**
     * State/province code.
     */
    public function withState(?string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * Street address.
     */
    public function withStreet(?string $street): self
    {
        $self = clone $this;
        $self['street'] = $street;

        return $self;
    }

    /**
     * Tax ID/EIN number.
     */
    public function withTaxID(?string $taxID): self
    {
        $self = clone $this;
        $self['taxID'] = $taxID;

        return $self;
    }

    /**
     * Type of tax ID (e.g., us_ein, ca_bn).
     */
    public function withTaxIDType(?string $taxIDType): self
    {
        $self = clone $this;
        $self['taxIDType'] = $taxIDType;

        return $self;
    }
}
