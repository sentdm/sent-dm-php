<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Brand and KYC data grouped into contact, business, and compliance sections.
 *
 * @phpstan-import-type BrandComplianceInfoShape from \SentDm\Profiles\BrandComplianceInfo
 * @phpstan-import-type BrandContactInfoShape from \SentDm\Profiles\BrandContactInfo
 * @phpstan-import-type BrandBusinessInfoShape from \SentDm\Profiles\BrandBusinessInfo
 *
 * @phpstan-type BrandsBrandDataShape = array{
 *   compliance: BrandComplianceInfo|BrandComplianceInfoShape,
 *   contact: BrandContactInfo|BrandContactInfoShape,
 *   business?: null|BrandBusinessInfo|BrandBusinessInfoShape,
 * }
 */
final class BrandsBrandData implements BaseModel
{
    /** @use SdkModel<BrandsBrandDataShape> */
    use SdkModel;

    /**
     * Compliance and TCR information for brand registration.
     */
    #[Required]
    public BrandComplianceInfo $compliance;

    /**
     * Contact information for brand KYC.
     */
    #[Required]
    public BrandContactInfo $contact;

    /**
     * Business details and address for brand KYC.
     */
    #[Optional(nullable: true)]
    public ?BrandBusinessInfo $business;

    /**
     * `new BrandsBrandData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandsBrandData::with(compliance: ..., contact: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandsBrandData)->withCompliance(...)->withContact(...)
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
     * @param BrandComplianceInfo|BrandComplianceInfoShape $compliance
     * @param BrandContactInfo|BrandContactInfoShape $contact
     * @param BrandBusinessInfo|BrandBusinessInfoShape|null $business
     */
    public static function with(
        BrandComplianceInfo|array $compliance,
        BrandContactInfo|array $contact,
        BrandBusinessInfo|array|null $business = null,
    ): self {
        $self = new self;

        $self['compliance'] = $compliance;
        $self['contact'] = $contact;

        null !== $business && $self['business'] = $business;

        return $self;
    }

    /**
     * Compliance and TCR information for brand registration.
     *
     * @param BrandComplianceInfo|BrandComplianceInfoShape $compliance
     */
    public function withCompliance(BrandComplianceInfo|array $compliance): self
    {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    /**
     * Contact information for brand KYC.
     *
     * @param BrandContactInfo|BrandContactInfoShape $contact
     */
    public function withContact(BrandContactInfo|array $contact): self
    {
        $self = clone $this;
        $self['contact'] = $contact;

        return $self;
    }

    /**
     * Business details and address for brand KYC.
     *
     * @param BrandBusinessInfo|BrandBusinessInfoShape|null $business
     */
    public function withBusiness(BrandBusinessInfo|array|null $business): self
    {
        $self = clone $this;
        $self['business'] = $business;

        return $self;
    }
}
