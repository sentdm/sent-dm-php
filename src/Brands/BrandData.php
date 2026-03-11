<?php

declare(strict_types=1);

namespace SentDm\Brands;

use SentDm\Brands\BrandData\Business;
use SentDm\Brands\BrandData\Compliance;
use SentDm\Brands\BrandData\Contact;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Brand and KYC data grouped into contact, business, and compliance sections.
 *
 * @phpstan-import-type ComplianceShape from \SentDm\Brands\BrandData\Compliance
 * @phpstan-import-type ContactShape from \SentDm\Brands\BrandData\Contact
 * @phpstan-import-type BusinessShape from \SentDm\Brands\BrandData\Business
 *
 * @phpstan-type BrandDataShape = array{
 *   compliance: Compliance|ComplianceShape,
 *   contact: Contact|ContactShape,
 *   business?: null|Business|BusinessShape,
 * }
 */
final class BrandData implements BaseModel
{
    /** @use SdkModel<BrandDataShape> */
    use SdkModel;

    /**
     * Compliance and TCR-related information.
     */
    #[Required]
    public Compliance $compliance;

    /**
     * Contact information for the brand.
     */
    #[Required]
    public Contact $contact;

    /**
     * Business details and address information.
     */
    #[Optional(nullable: true)]
    public ?Business $business;

    /**
     * `new BrandData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandData::with(compliance: ..., contact: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandData)->withCompliance(...)->withContact(...)
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
     * @param Compliance|ComplianceShape $compliance
     * @param Contact|ContactShape $contact
     * @param Business|BusinessShape|null $business
     */
    public static function with(
        Compliance|array $compliance,
        Contact|array $contact,
        Business|array|null $business = null,
    ): self {
        $self = new self;

        $self['compliance'] = $compliance;
        $self['contact'] = $contact;

        null !== $business && $self['business'] = $business;

        return $self;
    }

    /**
     * Compliance and TCR-related information.
     *
     * @param Compliance|ComplianceShape $compliance
     */
    public function withCompliance(Compliance|array $compliance): self
    {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    /**
     * Contact information for the brand.
     *
     * @param Contact|ContactShape $contact
     */
    public function withContact(Contact|array $contact): self
    {
        $self = clone $this;
        $self['contact'] = $contact;

        return $self;
    }

    /**
     * Business details and address information.
     *
     * @param Business|BusinessShape|null $business
     */
    public function withBusiness(Business|array|null $business): self
    {
        $self = clone $this;
        $self['business'] = $business;

        return $self;
    }
}
