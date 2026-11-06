<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\MarketCompliance;

use SentDm\Channels\SMS\MarketCompliance\Brand\EntityType;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Business identity. The identity the registration is filed against. Omit to have none; { "inherit": true } to register under your organization's.
 *
 * @phpstan-type BrandShape = array{
 *   businessName?: string|null,
 *   city?: string|null,
 *   contactEmail?: string|null,
 *   contactName?: string|null,
 *   contactPhone?: string|null,
 *   country?: string|null,
 *   einIssuingCountry?: string|null,
 *   entityType?: null|EntityType|value-of<EntityType>,
 *   inherit?: bool|null,
 *   legalName?: string|null,
 *   postalCode?: string|null,
 *   state?: string|null,
 *   street?: string|null,
 *   taxID?: string|null,
 *   taxIDType?: string|null,
 *   website?: string|null,
 * }
 */
final class Brand implements BaseModel
{
    /** @use SdkModel<BrandShape> */
    use SdkModel;

    /**
     * Public-facing name. TCR displayName — the name recipients would recognise. Named for what it holds rather than for TCR's field, which is why it is not `display_name`. Required when `compliance.brand.inherit != true`.
     */
    #[Optional('business_name')]
    public ?string $businessName;

    /**
     * City. Required when `compliance.brand.inherit != true`.
     */
    #[Optional]
    public ?string $city;

    /**
     * Contact email. TCR email. Required when `compliance.brand.inherit != true`.
     */
    #[Optional('contact_email')]
    public ?string $contactEmail;

    /**
     * Responsible contact. Split into TCR's firstName/lastName on submission. BrandService refuses a blank one, so a missing name is reported here rather than thrown after the profile was written. Required when `compliance.brand.inherit != true`.
     */
    #[Optional('contact_name')]
    public ?string $contactName;

    /**
     * Contact phone. TCR sends it as both phone and mobilePhone, so it is asked for once. Named for the contact it belongs to rather than as a bare `phone` on a block that also carries an address. Required when `compliance.brand.inherit != true`.
     */
    #[Optional('contact_phone')]
    public ?string $contactPhone;

    /**
     * Country of registration. Two letters — US. The country spelled out in full is accepted too and stored as its code, which is what a read answers with and what is filed. Required when `compliance.brand.inherit != true`.
     */
    #[Optional]
    public ?string $country;

    /**
     * Country that issued the tax id. TCR einIssuingCountry — where the tax id was issued, which is not always where the business trades. Defaults to `country` when omitted, which is right for most. Takes the code or the country spelled out, as `country` does.
     */
    #[Optional('ein_issuing_country')]
    public ?string $einIssuingCountry;

    /**
     * Entity type. TCR entityType. Decides which vetting TCR applies and, for SOLE_PROPRIETOR, fixes the campaign fee regardless of volume. Also refused at submission if absent. Required when `compliance.brand.inherit != true`.
     *
     * @var value-of<EntityType>|null $entityType
     */
    #[Optional('entity_type', enum: EntityType::class)]
    public ?string $entityType;

    /**
     * Run on the organization's brand. True to register under the parent organization's identity rather than one of this profile's own; every field below is then neither asked for nor accepted. Omitted, the brand is the organization's unless this block supplies identity fields, which says plainly enough that it wants one of its own.
     */
    #[Optional]
    public ?bool $inherit;

    /**
     * Registered legal name. TCR companyName — the name on the incorporation documents, which is often not the name recipients would recognise. Required when `compliance.brand.inherit != true`.
     */
    #[Optional('legal_name')]
    public ?string $legalName;

    /**
     * Postal code. Required when `compliance.brand.inherit != true`.
     */
    #[Optional('postal_code')]
    public ?string $postalCode;

    /**
     * State or region. TCR state. Two letters for a US registration. Required when `compliance.brand.inherit != true`.
     */
    #[Optional]
    public ?string $state;

    /**
     * Street address. Required when `compliance.brand.inherit != true`.
     */
    #[Optional]
    public ?string $street;

    /**
     * Tax identifier. TCR ein. TcrBrandSubmissionValidator refuses a submission without one, so it is wanted here rather than discovered at filing time. Required when `compliance.brand.inherit != true`.
     */
    #[Optional('tax_id')]
    public ?string $taxID;

    /**
     * Kind of tax identifier. Which kind of identifier `tax_id` is, e.g. us_ein. Derived onto the brand form, and not itself sent to TCR. Required when `compliance.brand.inherit != true`.
     */
    #[Optional('tax_id_type')]
    public ?string $taxIDType;

    /**
     * Website. TCR website. Optional, and worth sending: carriers weigh it when vetting, so a brand that has one and omits it is vetted on less than it could be.
     */
    #[Optional]
    public ?string $website;

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
        ?string $businessName = null,
        ?string $city = null,
        ?string $contactEmail = null,
        ?string $contactName = null,
        ?string $contactPhone = null,
        ?string $country = null,
        ?string $einIssuingCountry = null,
        EntityType|string|null $entityType = null,
        ?bool $inherit = null,
        ?string $legalName = null,
        ?string $postalCode = null,
        ?string $state = null,
        ?string $street = null,
        ?string $taxID = null,
        ?string $taxIDType = null,
        ?string $website = null,
    ): self {
        $self = new self;

        null !== $businessName && $self['businessName'] = $businessName;
        null !== $city && $self['city'] = $city;
        null !== $contactEmail && $self['contactEmail'] = $contactEmail;
        null !== $contactName && $self['contactName'] = $contactName;
        null !== $contactPhone && $self['contactPhone'] = $contactPhone;
        null !== $country && $self['country'] = $country;
        null !== $einIssuingCountry && $self['einIssuingCountry'] = $einIssuingCountry;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $inherit && $self['inherit'] = $inherit;
        null !== $legalName && $self['legalName'] = $legalName;
        null !== $postalCode && $self['postalCode'] = $postalCode;
        null !== $state && $self['state'] = $state;
        null !== $street && $self['street'] = $street;
        null !== $taxID && $self['taxID'] = $taxID;
        null !== $taxIDType && $self['taxIDType'] = $taxIDType;
        null !== $website && $self['website'] = $website;

        return $self;
    }

    /**
     * Public-facing name. TCR displayName — the name recipients would recognise. Named for what it holds rather than for TCR's field, which is why it is not `display_name`. Required when `compliance.brand.inherit != true`.
     */
    public function withBusinessName(string $businessName): self
    {
        $self = clone $this;
        $self['businessName'] = $businessName;

        return $self;
    }

    /**
     * City. Required when `compliance.brand.inherit != true`.
     */
    public function withCity(string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    /**
     * Contact email. TCR email. Required when `compliance.brand.inherit != true`.
     */
    public function withContactEmail(string $contactEmail): self
    {
        $self = clone $this;
        $self['contactEmail'] = $contactEmail;

        return $self;
    }

    /**
     * Responsible contact. Split into TCR's firstName/lastName on submission. BrandService refuses a blank one, so a missing name is reported here rather than thrown after the profile was written. Required when `compliance.brand.inherit != true`.
     */
    public function withContactName(string $contactName): self
    {
        $self = clone $this;
        $self['contactName'] = $contactName;

        return $self;
    }

    /**
     * Contact phone. TCR sends it as both phone and mobilePhone, so it is asked for once. Named for the contact it belongs to rather than as a bare `phone` on a block that also carries an address. Required when `compliance.brand.inherit != true`.
     */
    public function withContactPhone(string $contactPhone): self
    {
        $self = clone $this;
        $self['contactPhone'] = $contactPhone;

        return $self;
    }

    /**
     * Country of registration. Two letters — US. The country spelled out in full is accepted too and stored as its code, which is what a read answers with and what is filed. Required when `compliance.brand.inherit != true`.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Country that issued the tax id. TCR einIssuingCountry — where the tax id was issued, which is not always where the business trades. Defaults to `country` when omitted, which is right for most. Takes the code or the country spelled out, as `country` does.
     */
    public function withEinIssuingCountry(string $einIssuingCountry): self
    {
        $self = clone $this;
        $self['einIssuingCountry'] = $einIssuingCountry;

        return $self;
    }

    /**
     * Entity type. TCR entityType. Decides which vetting TCR applies and, for SOLE_PROPRIETOR, fixes the campaign fee regardless of volume. Also refused at submission if absent. Required when `compliance.brand.inherit != true`.
     *
     * @param EntityType|value-of<EntityType> $entityType
     */
    public function withEntityType(EntityType|string $entityType): self
    {
        $self = clone $this;
        $self['entityType'] = $entityType;

        return $self;
    }

    /**
     * Run on the organization's brand. True to register under the parent organization's identity rather than one of this profile's own; every field below is then neither asked for nor accepted. Omitted, the brand is the organization's unless this block supplies identity fields, which says plainly enough that it wants one of its own.
     */
    public function withInherit(bool $inherit): self
    {
        $self = clone $this;
        $self['inherit'] = $inherit;

        return $self;
    }

    /**
     * Registered legal name. TCR companyName — the name on the incorporation documents, which is often not the name recipients would recognise. Required when `compliance.brand.inherit != true`.
     */
    public function withLegalName(string $legalName): self
    {
        $self = clone $this;
        $self['legalName'] = $legalName;

        return $self;
    }

    /**
     * Postal code. Required when `compliance.brand.inherit != true`.
     */
    public function withPostalCode(string $postalCode): self
    {
        $self = clone $this;
        $self['postalCode'] = $postalCode;

        return $self;
    }

    /**
     * State or region. TCR state. Two letters for a US registration. Required when `compliance.brand.inherit != true`.
     */
    public function withState(string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * Street address. Required when `compliance.brand.inherit != true`.
     */
    public function withStreet(string $street): self
    {
        $self = clone $this;
        $self['street'] = $street;

        return $self;
    }

    /**
     * Tax identifier. TCR ein. TcrBrandSubmissionValidator refuses a submission without one, so it is wanted here rather than discovered at filing time. Required when `compliance.brand.inherit != true`.
     */
    public function withTaxID(string $taxID): self
    {
        $self = clone $this;
        $self['taxID'] = $taxID;

        return $self;
    }

    /**
     * Kind of tax identifier. Which kind of identifier `tax_id` is, e.g. us_ein. Derived onto the brand form, and not itself sent to TCR. Required when `compliance.brand.inherit != true`.
     */
    public function withTaxIDType(string $taxIDType): self
    {
        $self = clone $this;
        $self['taxIDType'] = $taxIDType;

        return $self;
    }

    /**
     * Website. TCR website. Optional, and worth sending: carriers weigh it when vetting, so a brand that has one and omits it is vetted on less than it could be.
     */
    public function withWebsite(string $website): self
    {
        $self = clone $this;
        $self['website'] = $website;

        return $self;
    }
}
