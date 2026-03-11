<?php

declare(strict_types=1);

namespace SentDm\Profiles\BrandsBrandData;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\BrandsBrandData\Business\EntityType;

/**
 * Business details and address information.
 *
 * @phpstan-type BusinessShape = array{
 *   city?: string|null,
 *   country?: string|null,
 *   countryOfRegistration?: string|null,
 *   entityType?: null|EntityType|value-of<EntityType>,
 *   legalName?: string|null,
 *   postalCode?: string|null,
 *   state?: string|null,
 *   street?: string|null,
 *   taxID?: string|null,
 *   taxIDType?: string|null,
 *   url?: string|null,
 * }
 */
final class Business implements BaseModel
{
    /** @use SdkModel<BusinessShape> */
    use SdkModel;

    /**
     * City.
     */
    #[Optional(nullable: true)]
    public ?string $city;

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
     * Business entity type.
     *
     * @var value-of<EntityType>|null $entityType
     */
    #[Optional(enum: EntityType::class, nullable: true)]
    public ?string $entityType;

    /**
     * Legal business name.
     */
    #[Optional(nullable: true)]
    public ?string $legalName;

    /**
     * Postal/ZIP code.
     */
    #[Optional(nullable: true)]
    public ?string $postalCode;

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
     * Business website URL.
     */
    #[Optional(nullable: true)]
    public ?string $url;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param EntityType|value-of<EntityType>|null $entityType
     */
    public static function with(
        ?string $city = null,
        ?string $country = null,
        ?string $countryOfRegistration = null,
        EntityType|string|null $entityType = null,
        ?string $legalName = null,
        ?string $postalCode = null,
        ?string $state = null,
        ?string $street = null,
        ?string $taxID = null,
        ?string $taxIDType = null,
        ?string $url = null,
    ): self {
        $self = new self;

        null !== $city && $self['city'] = $city;
        null !== $country && $self['country'] = $country;
        null !== $countryOfRegistration && $self['countryOfRegistration'] = $countryOfRegistration;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $legalName && $self['legalName'] = $legalName;
        null !== $postalCode && $self['postalCode'] = $postalCode;
        null !== $state && $self['state'] = $state;
        null !== $street && $self['street'] = $street;
        null !== $taxID && $self['taxID'] = $taxID;
        null !== $taxIDType && $self['taxIDType'] = $taxIDType;
        null !== $url && $self['url'] = $url;

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
     * Legal business name.
     */
    public function withLegalName(?string $legalName): self
    {
        $self = clone $this;
        $self['legalName'] = $legalName;

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

    /**
     * Business website URL.
     */
    public function withURL(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
