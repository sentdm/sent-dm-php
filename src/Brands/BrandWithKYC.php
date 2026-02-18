<?php

declare(strict_types=1);

namespace SentDm\Brands;

use SentDm\Brands\BrandWithKYC\IdentityStatus;
use SentDm\Brands\BrandWithKYC\Status;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Flattened brand response with embedded KYC information.
 *
 * @phpstan-import-type DestinationCountryShape from \SentDm\Brands\DestinationCountry
 *
 * @phpstan-type BrandWithKYCShape = array{
 *   id?: string|null,
 *   brandRelationship?: null|TcrBrandRelationship|value-of<TcrBrandRelationship>,
 *   businessLegalName?: string|null,
 *   businessName?: string|null,
 *   businessRole?: string|null,
 *   businessURL?: string|null,
 *   city?: string|null,
 *   contactEmail?: string|null,
 *   contactName?: string|null,
 *   contactPhone?: string|null,
 *   contactPhoneCountryCode?: string|null,
 *   country?: string|null,
 *   countryOfRegistration?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   cspID?: string|null,
 *   destinationCountries?: list<DestinationCountry|DestinationCountryShape>|null,
 *   entityType?: string|null,
 *   expectedMessagingVolume?: string|null,
 *   identityStatus?: null|IdentityStatus|value-of<IdentityStatus>,
 *   isInherited?: bool|null,
 *   isTcrApplication?: bool|null,
 *   notes?: string|null,
 *   phoneNumberPrefix?: string|null,
 *   postalCode?: string|null,
 *   primaryUseCase?: string|null,
 *   state?: string|null,
 *   status?: null|Status|value-of<Status>,
 *   street?: string|null,
 *   submittedAt?: \DateTimeInterface|null,
 *   submittedToTcr?: bool|null,
 *   taxID?: string|null,
 *   taxIDType?: string|null,
 *   tcrBrandID?: string|null,
 *   universalEin?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   vertical?: null|TcrVertical|value-of<TcrVertical>,
 * }
 */
final class BrandWithKYC implements BaseModel
{
    /** @use SdkModel<BrandWithKYCShape> */
    use SdkModel;

    /**
     * Unique identifier for the brand.
     */
    #[Optional]
    public ?string $id;

    /**
     * Brand relationship level with TCR.
     *
     * @var value-of<TcrBrandRelationship>|null $brandRelationship
     */
    #[Optional(enum: TcrBrandRelationship::class, nullable: true)]
    public ?string $brandRelationship;

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
     * Primary contact name.
     */
    #[Optional]
    public ?string $contactName;

    /**
     * Contact phone number.
     */
    #[Optional(nullable: true)]
    public ?string $contactPhone;

    /**
     * Contact phone country code.
     */
    #[Optional(nullable: true)]
    public ?string $contactPhoneCountryCode;

    /**
     * Country code.
     */
    #[Optional(nullable: true)]
    public ?string $country;

    /**
     * Country where the business is registered.
     */
    #[Optional(nullable: true)]
    public ?string $countryOfRegistration;

    /**
     * When the brand was created.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * CSP (Campaign Service Provider) ID.
     */
    #[Optional('cspId', nullable: true)]
    public ?string $cspID;

    /**
     * List of destination countries for messaging.
     *
     * @var list<DestinationCountry>|null $destinationCountries
     */
    #[Optional(list: DestinationCountry::class)]
    public ?array $destinationCountries;

    /**
     * Business entity type.
     */
    #[Optional(nullable: true)]
    public ?string $entityType;

    /**
     * Expected daily messaging volume.
     */
    #[Optional(nullable: true)]
    public ?string $expectedMessagingVolume;

    /**
     * TCR brand identity verification status.
     *
     * @var value-of<IdentityStatus>|null $identityStatus
     */
    #[Optional(enum: IdentityStatus::class, nullable: true)]
    public ?string $identityStatus;

    /**
     * Whether this brand is inherited from parent organization.
     */
    #[Optional]
    public ?bool $isInherited;

    /**
     * Whether this is a TCR application.
     */
    #[Optional]
    public ?bool $isTcrApplication;

    /**
     * Additional notes.
     */
    #[Optional(nullable: true)]
    public ?string $notes;

    /**
     * Phone number prefix for messaging.
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
     * TCR brand status.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    /**
     * Street address.
     */
    #[Optional(nullable: true)]
    public ?string $street;

    /**
     * When the brand was submitted to TCR.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $submittedAt;

    /**
     * Whether this brand was submitted to TCR.
     */
    #[Optional('submittedToTCR')]
    public ?bool $submittedToTcr;

    /**
     * Tax ID/EIN number.
     */
    #[Optional('taxId', nullable: true)]
    public ?string $taxID;

    /**
     * Type of tax ID.
     */
    #[Optional('taxIdType', nullable: true)]
    public ?string $taxIDType;

    /**
     * TCR brand ID (populated after TCR submission).
     */
    #[Optional('tcrBrandId', nullable: true)]
    public ?string $tcrBrandID;

    /**
     * Universal EIN from TCR.
     */
    #[Optional(nullable: true)]
    public ?string $universalEin;

    /**
     * When the brand was last updated.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Business vertical/industry category.
     *
     * @var value-of<TcrVertical>|null $vertical
     */
    #[Optional(enum: TcrVertical::class, nullable: true)]
    public ?string $vertical;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TcrBrandRelationship|value-of<TcrBrandRelationship>|null $brandRelationship
     * @param list<DestinationCountry|DestinationCountryShape>|null $destinationCountries
     * @param IdentityStatus|value-of<IdentityStatus>|null $identityStatus
     * @param Status|value-of<Status>|null $status
     * @param TcrVertical|value-of<TcrVertical>|null $vertical
     */
    public static function with(
        ?string $id = null,
        TcrBrandRelationship|string|null $brandRelationship = null,
        ?string $businessLegalName = null,
        ?string $businessName = null,
        ?string $businessRole = null,
        ?string $businessURL = null,
        ?string $city = null,
        ?string $contactEmail = null,
        ?string $contactName = null,
        ?string $contactPhone = null,
        ?string $contactPhoneCountryCode = null,
        ?string $country = null,
        ?string $countryOfRegistration = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $cspID = null,
        ?array $destinationCountries = null,
        ?string $entityType = null,
        ?string $expectedMessagingVolume = null,
        IdentityStatus|string|null $identityStatus = null,
        ?bool $isInherited = null,
        ?bool $isTcrApplication = null,
        ?string $notes = null,
        ?string $phoneNumberPrefix = null,
        ?string $postalCode = null,
        ?string $primaryUseCase = null,
        ?string $state = null,
        Status|string|null $status = null,
        ?string $street = null,
        ?\DateTimeInterface $submittedAt = null,
        ?bool $submittedToTcr = null,
        ?string $taxID = null,
        ?string $taxIDType = null,
        ?string $tcrBrandID = null,
        ?string $universalEin = null,
        ?\DateTimeInterface $updatedAt = null,
        TcrVertical|string|null $vertical = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $brandRelationship && $self['brandRelationship'] = $brandRelationship;
        null !== $businessLegalName && $self['businessLegalName'] = $businessLegalName;
        null !== $businessName && $self['businessName'] = $businessName;
        null !== $businessRole && $self['businessRole'] = $businessRole;
        null !== $businessURL && $self['businessURL'] = $businessURL;
        null !== $city && $self['city'] = $city;
        null !== $contactEmail && $self['contactEmail'] = $contactEmail;
        null !== $contactName && $self['contactName'] = $contactName;
        null !== $contactPhone && $self['contactPhone'] = $contactPhone;
        null !== $contactPhoneCountryCode && $self['contactPhoneCountryCode'] = $contactPhoneCountryCode;
        null !== $country && $self['country'] = $country;
        null !== $countryOfRegistration && $self['countryOfRegistration'] = $countryOfRegistration;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $cspID && $self['cspID'] = $cspID;
        null !== $destinationCountries && $self['destinationCountries'] = $destinationCountries;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $expectedMessagingVolume && $self['expectedMessagingVolume'] = $expectedMessagingVolume;
        null !== $identityStatus && $self['identityStatus'] = $identityStatus;
        null !== $isInherited && $self['isInherited'] = $isInherited;
        null !== $isTcrApplication && $self['isTcrApplication'] = $isTcrApplication;
        null !== $notes && $self['notes'] = $notes;
        null !== $phoneNumberPrefix && $self['phoneNumberPrefix'] = $phoneNumberPrefix;
        null !== $postalCode && $self['postalCode'] = $postalCode;
        null !== $primaryUseCase && $self['primaryUseCase'] = $primaryUseCase;
        null !== $state && $self['state'] = $state;
        null !== $status && $self['status'] = $status;
        null !== $street && $self['street'] = $street;
        null !== $submittedAt && $self['submittedAt'] = $submittedAt;
        null !== $submittedToTcr && $self['submittedToTcr'] = $submittedToTcr;
        null !== $taxID && $self['taxID'] = $taxID;
        null !== $taxIDType && $self['taxIDType'] = $taxIDType;
        null !== $tcrBrandID && $self['tcrBrandID'] = $tcrBrandID;
        null !== $universalEin && $self['universalEin'] = $universalEin;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $vertical && $self['vertical'] = $vertical;

        return $self;
    }

    /**
     * Unique identifier for the brand.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Brand relationship level with TCR.
     *
     * @param TcrBrandRelationship|value-of<TcrBrandRelationship>|null $brandRelationship
     */
    public function withBrandRelationship(
        TcrBrandRelationship|string|null $brandRelationship
    ): self {
        $self = clone $this;
        $self['brandRelationship'] = $brandRelationship;

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
     * Primary contact name.
     */
    public function withContactName(string $contactName): self
    {
        $self = clone $this;
        $self['contactName'] = $contactName;

        return $self;
    }

    /**
     * Contact phone number.
     */
    public function withContactPhone(?string $contactPhone): self
    {
        $self = clone $this;
        $self['contactPhone'] = $contactPhone;

        return $self;
    }

    /**
     * Contact phone country code.
     */
    public function withContactPhoneCountryCode(
        ?string $contactPhoneCountryCode
    ): self {
        $self = clone $this;
        $self['contactPhoneCountryCode'] = $contactPhoneCountryCode;

        return $self;
    }

    /**
     * Country code.
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
     * When the brand was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * CSP (Campaign Service Provider) ID.
     */
    public function withCspID(?string $cspID): self
    {
        $self = clone $this;
        $self['cspID'] = $cspID;

        return $self;
    }

    /**
     * List of destination countries for messaging.
     *
     * @param list<DestinationCountry|DestinationCountryShape> $destinationCountries
     */
    public function withDestinationCountries(array $destinationCountries): self
    {
        $self = clone $this;
        $self['destinationCountries'] = $destinationCountries;

        return $self;
    }

    /**
     * Business entity type.
     */
    public function withEntityType(?string $entityType): self
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
     * TCR brand identity verification status.
     *
     * @param IdentityStatus|value-of<IdentityStatus>|null $identityStatus
     */
    public function withIdentityStatus(
        IdentityStatus|string|null $identityStatus
    ): self {
        $self = clone $this;
        $self['identityStatus'] = $identityStatus;

        return $self;
    }

    /**
     * Whether this brand is inherited from parent organization.
     */
    public function withIsInherited(bool $isInherited): self
    {
        $self = clone $this;
        $self['isInherited'] = $isInherited;

        return $self;
    }

    /**
     * Whether this is a TCR application.
     */
    public function withIsTcrApplication(bool $isTcrApplication): self
    {
        $self = clone $this;
        $self['isTcrApplication'] = $isTcrApplication;

        return $self;
    }

    /**
     * Additional notes.
     */
    public function withNotes(?string $notes): self
    {
        $self = clone $this;
        $self['notes'] = $notes;

        return $self;
    }

    /**
     * Phone number prefix for messaging.
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
     * TCR brand status.
     *
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

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
     * When the brand was submitted to TCR.
     */
    public function withSubmittedAt(?\DateTimeInterface $submittedAt): self
    {
        $self = clone $this;
        $self['submittedAt'] = $submittedAt;

        return $self;
    }

    /**
     * Whether this brand was submitted to TCR.
     */
    public function withSubmittedToTcr(bool $submittedToTcr): self
    {
        $self = clone $this;
        $self['submittedToTcr'] = $submittedToTcr;

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
     * Type of tax ID.
     */
    public function withTaxIDType(?string $taxIDType): self
    {
        $self = clone $this;
        $self['taxIDType'] = $taxIDType;

        return $self;
    }

    /**
     * TCR brand ID (populated after TCR submission).
     */
    public function withTcrBrandID(?string $tcrBrandID): self
    {
        $self = clone $this;
        $self['tcrBrandID'] = $tcrBrandID;

        return $self;
    }

    /**
     * Universal EIN from TCR.
     */
    public function withUniversalEin(?string $universalEin): self
    {
        $self = clone $this;
        $self['universalEin'] = $universalEin;

        return $self;
    }

    /**
     * When the brand was last updated.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Business vertical/industry category.
     *
     * @param TcrVertical|value-of<TcrVertical>|null $vertical
     */
    public function withVertical(TcrVertical|string|null $vertical): self
    {
        $self = clone $this;
        $self['vertical'] = $vertical;

        return $self;
    }
}
