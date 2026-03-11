<?php

declare(strict_types=1);

namespace SentDm\Brands;

use SentDm\Brands\BrandWithKYC\Business;
use SentDm\Brands\BrandWithKYC\Compliance;
use SentDm\Brands\BrandWithKYC\Contact;
use SentDm\Brands\BrandWithKYC\IdentityStatus;
use SentDm\Brands\BrandWithKYC\Status;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Brand response with nested contact, business, and compliance sections — mirrors the request structure.
 *
 * @phpstan-import-type BusinessShape from \SentDm\Brands\BrandWithKYC\Business
 * @phpstan-import-type ComplianceShape from \SentDm\Brands\BrandWithKYC\Compliance
 * @phpstan-import-type ContactShape from \SentDm\Brands\BrandWithKYC\Contact
 *
 * @phpstan-type BrandWithKYCShape = array{
 *   id?: string|null,
 *   business?: null|Business|BusinessShape,
 *   compliance?: null|Compliance|ComplianceShape,
 *   contact?: null|Contact|ContactShape,
 *   createdAt?: \DateTimeInterface|null,
 *   cspID?: string|null,
 *   identityStatus?: null|IdentityStatus|value-of<IdentityStatus>,
 *   isInherited?: bool|null,
 *   status?: null|Status|value-of<Status>,
 *   submittedAt?: \DateTimeInterface|null,
 *   submittedToTcr?: bool|null,
 *   tcrBrandID?: string|null,
 *   universalEin?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
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
     * Business details and address information.
     */
    #[Optional(nullable: true)]
    public ?Business $business;

    /**
     * Compliance and TCR-related information.
     */
    #[Optional(nullable: true)]
    public ?Compliance $compliance;

    /**
     * Contact information for the brand.
     */
    #[Optional(nullable: true)]
    public ?Contact $contact;

    /**
     * When the brand was created.
     */
    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * CSP (Campaign Service Provider) ID.
     */
    #[Optional('csp_id', nullable: true)]
    public ?string $cspID;

    /**
     * TCR brand identity verification status.
     *
     * @var value-of<IdentityStatus>|null $identityStatus
     */
    #[Optional('identity_status', enum: IdentityStatus::class, nullable: true)]
    public ?string $identityStatus;

    /**
     * Whether this brand is inherited from the parent organization.
     */
    #[Optional('is_inherited')]
    public ?bool $isInherited;

    /**
     * TCR brand status.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    /**
     * When the brand was submitted to TCR.
     */
    #[Optional('submitted_at', nullable: true)]
    public ?\DateTimeInterface $submittedAt;

    /**
     * Whether this brand has been submitted to TCR.
     */
    #[Optional('submitted_to_tcr')]
    public ?bool $submittedToTcr;

    /**
     * TCR brand ID (populated after TCR submission).
     */
    #[Optional('tcr_brand_id', nullable: true)]
    public ?string $tcrBrandID;

    /**
     * Universal EIN from TCR.
     */
    #[Optional('universal_ein', nullable: true)]
    public ?string $universalEin;

    /**
     * When the brand was last updated.
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
     *
     * @param Business|BusinessShape|null $business
     * @param Compliance|ComplianceShape|null $compliance
     * @param Contact|ContactShape|null $contact
     * @param IdentityStatus|value-of<IdentityStatus>|null $identityStatus
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?string $id = null,
        Business|array|null $business = null,
        Compliance|array|null $compliance = null,
        Contact|array|null $contact = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $cspID = null,
        IdentityStatus|string|null $identityStatus = null,
        ?bool $isInherited = null,
        Status|string|null $status = null,
        ?\DateTimeInterface $submittedAt = null,
        ?bool $submittedToTcr = null,
        ?string $tcrBrandID = null,
        ?string $universalEin = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $business && $self['business'] = $business;
        null !== $compliance && $self['compliance'] = $compliance;
        null !== $contact && $self['contact'] = $contact;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $cspID && $self['cspID'] = $cspID;
        null !== $identityStatus && $self['identityStatus'] = $identityStatus;
        null !== $isInherited && $self['isInherited'] = $isInherited;
        null !== $status && $self['status'] = $status;
        null !== $submittedAt && $self['submittedAt'] = $submittedAt;
        null !== $submittedToTcr && $self['submittedToTcr'] = $submittedToTcr;
        null !== $tcrBrandID && $self['tcrBrandID'] = $tcrBrandID;
        null !== $universalEin && $self['universalEin'] = $universalEin;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

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

    /**
     * Compliance and TCR-related information.
     *
     * @param Compliance|ComplianceShape|null $compliance
     */
    public function withCompliance(Compliance|array|null $compliance): self
    {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    /**
     * Contact information for the brand.
     *
     * @param Contact|ContactShape|null $contact
     */
    public function withContact(Contact|array|null $contact): self
    {
        $self = clone $this;
        $self['contact'] = $contact;

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
     * Whether this brand is inherited from the parent organization.
     */
    public function withIsInherited(bool $isInherited): self
    {
        $self = clone $this;
        $self['isInherited'] = $isInherited;

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
     * When the brand was submitted to TCR.
     */
    public function withSubmittedAt(?\DateTimeInterface $submittedAt): self
    {
        $self = clone $this;
        $self['submittedAt'] = $submittedAt;

        return $self;
    }

    /**
     * Whether this brand has been submitted to TCR.
     */
    public function withSubmittedToTcr(bool $submittedToTcr): self
    {
        $self = clone $this;
        $self['submittedToTcr'] = $submittedToTcr;

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
}
