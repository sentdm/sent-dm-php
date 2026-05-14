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
 * @phpstan-import-type SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfoShape from \SentDm\Profiles\SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfo
 * @phpstan-import-type SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfoShape from \SentDm\Profiles\SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfo
 * @phpstan-import-type SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfoShape from \SentDm\Profiles\SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfo
 *
 * @phpstan-type BrandsBrandDataShape = array{
 *   compliance: SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfoShape,
 *   contact: SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfoShape,
 *   business?: null|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfoShape,
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
    public SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfo $compliance;

    /**
     * Contact information for brand KYC.
     */
    #[Required]
    public SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfo $contact;

    /**
     * Business details and address for brand KYC.
     */
    #[Optional(nullable: true)]
    public ?SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfo $business;

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
     * @param SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfoShape $compliance
     * @param SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfoShape $contact
     * @param SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfoShape|null $business
     */
    public static function with(
        SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfo|array $compliance,
        SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfo|array $contact,
        SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfo|array|null $business = null,
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
     * @param SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfoShape $compliance
     */
    public function withCompliance(
        SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandComplianceInfo|array $compliance,
    ): self {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    /**
     * Contact information for brand KYC.
     *
     * @param SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfoShape $contact
     */
    public function withContact(
        SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandContactInfo|array $contact,
    ): self {
        $self = clone $this;
        $self['contact'] = $contact;

        return $self;
    }

    /**
     * Business details and address for brand KYC.
     *
     * @param SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfo|SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfoShape|null $business
     */
    public function withBusiness(
        SentDmServicesEndpointsCustomerApIv3ContractsRequestsBrandsBrandBusinessInfo|array|null $business,
    ): self {
        $self = clone $this;
        $self['business'] = $business;

        return $self;
    }
}
