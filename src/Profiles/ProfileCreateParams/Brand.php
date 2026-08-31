<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileCreateParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileCreateParams\Brand\Business;
use SentDm\Profiles\ProfileCreateParams\Brand\Compliance;
use SentDm\Profiles\ProfileCreateParams\Brand\Contact;

/**
 * Brand and KYC data grouped into contact, business, and compliance sections.
 *
 * @phpstan-import-type ComplianceShape from \SentDm\Profiles\ProfileCreateParams\Brand\Compliance
 * @phpstan-import-type ContactShape from \SentDm\Profiles\ProfileCreateParams\Brand\Contact
 * @phpstan-import-type BusinessShape from \SentDm\Profiles\ProfileCreateParams\Brand\Business
 *
 * @phpstan-type BrandShape = array{
 *   compliance: Compliance|ComplianceShape,
 *   contact: Contact|ContactShape,
 *   business?: null|Business|BusinessShape,
 * }
 */
final class Brand implements BaseModel
{
    /** @use SdkModel<BrandShape> */
    use SdkModel;

    /**
     * Compliance and TCR information for brand registration.
     */
    #[Required]
    public Compliance $compliance;

    /**
     * Contact information for brand KYC.
     */
    #[Required]
    public Contact $contact;

    /**
     * Business details and address for brand KYC.
     */
    #[Optional(nullable: true)]
    public ?Business $business;

    /**
     * `new Brand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Brand::with(compliance: ..., contact: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Brand)->withCompliance(...)->withContact(...)
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
     * Compliance and TCR information for brand registration.
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
     * Contact information for brand KYC.
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
     * Business details and address for brand KYC.
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
