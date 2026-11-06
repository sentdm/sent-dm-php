<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Brand response with nested contact, business, and compliance sections — mirrors the request structure.
 *
 * @phpstan-import-type BrandBusinessShape from \SentDm\Profiles\BrandBusiness
 * @phpstan-import-type BrandComplianceShape from \SentDm\Profiles\BrandCompliance
 * @phpstan-import-type BrandContactShape from \SentDm\Profiles\BrandContact
 *
 * @phpstan-type BrandWithKYCShape = array{
 *   id?: string|null,
 *   business?: null|BrandBusiness|BrandBusinessShape,
 *   compliance?: null|BrandCompliance|BrandComplianceShape,
 *   contact?: null|BrandContact|BrandContactShape,
 *   createdAt?: \DateTimeInterface|null,
 *   cspID?: string|null,
 *   identityStatus?: null|TcrBrandIdentityStatus|value-of<TcrBrandIdentityStatus>,
 *   isInherited?: bool|null,
 *   status?: null|TcrBrandStatus|value-of<TcrBrandStatus>,
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
    public ?BrandBusiness $business;

    /**
     * Compliance and TCR-related information.
     */
    #[Optional(nullable: true)]
    public ?BrandCompliance $compliance;

    /**
     * Contact information for the brand.
     */
    #[Optional(nullable: true)]
    public ?BrandContact $contact;

    /**
     * When the brand was created.
     */
    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * @deprecated
     *
     * Deprecated and scheduled for removal. Identifies the Campaign Service Provider that
     * registered the brand, which is Sent, so the value is the same for every brand and every
     * account. Nothing on your side can act on it and there is no replacement. Stop reading it.
     */
    #[Optional('csp_id', nullable: true)]
    public ?string $cspID;

    /** @var value-of<TcrBrandIdentityStatus>|null $identityStatus */
    #[Optional(
        'identity_status',
        enum: TcrBrandIdentityStatus::class,
        nullable: true
    )]
    public ?string $identityStatus;

    /**
     * Whether this brand is inherited from the parent organization.
     */
    #[Optional('is_inherited')]
    public ?bool $isInherited;

    /** @var value-of<TcrBrandStatus>|null $status */
    #[Optional(enum: TcrBrandStatus::class, nullable: true)]
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
     * @param BrandBusiness|BrandBusinessShape|null $business
     * @param BrandCompliance|BrandComplianceShape|null $compliance
     * @param BrandContact|BrandContactShape|null $contact
     * @param TcrBrandIdentityStatus|value-of<TcrBrandIdentityStatus>|null $identityStatus
     * @param TcrBrandStatus|value-of<TcrBrandStatus>|null $status
     */
    public static function with(
        ?string $id = null,
        BrandBusiness|array|null $business = null,
        BrandCompliance|array|null $compliance = null,
        BrandContact|array|null $contact = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $cspID = null,
        TcrBrandIdentityStatus|string|null $identityStatus = null,
        ?bool $isInherited = null,
        TcrBrandStatus|string|null $status = null,
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
     * @param BrandBusiness|BrandBusinessShape|null $business
     */
    public function withBusiness(BrandBusiness|array|null $business): self
    {
        $self = clone $this;
        $self['business'] = $business;

        return $self;
    }

    /**
     * Compliance and TCR-related information.
     *
     * @param BrandCompliance|BrandComplianceShape|null $compliance
     */
    public function withCompliance(BrandCompliance|array|null $compliance): self
    {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    /**
     * Contact information for the brand.
     *
     * @param BrandContact|BrandContactShape|null $contact
     */
    public function withContact(BrandContact|array|null $contact): self
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
     * Deprecated and scheduled for removal. Identifies the Campaign Service Provider that
     * registered the brand, which is Sent, so the value is the same for every brand and every
     * account. Nothing on your side can act on it and there is no replacement. Stop reading it.
     */
    public function withCspID(?string $cspID): self
    {
        $self = clone $this;
        $self['cspID'] = $cspID;

        return $self;
    }

    /**
     * @param TcrBrandIdentityStatus|value-of<TcrBrandIdentityStatus>|null $identityStatus
     */
    public function withIdentityStatus(
        TcrBrandIdentityStatus|string|null $identityStatus
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
     * @param TcrBrandStatus|value-of<TcrBrandStatus>|null $status
     */
    public function withStatus(TcrBrandStatus|string|null $status): self
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
