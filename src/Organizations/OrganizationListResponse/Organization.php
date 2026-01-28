<?php

declare(strict_types=1);

namespace SentDm\Organizations\OrganizationListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Organizations\ProfileSummary;

/**
 * @phpstan-import-type ProfileSummaryShape from \SentDm\Organizations\ProfileSummary
 *
 * @phpstan-type OrganizationShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   icon?: string|null,
 *   name?: string|null,
 *   profiles?: list<ProfileSummary|ProfileSummaryShape>|null,
 * }
 */
final class Organization implements BaseModel
{
    /** @use SdkModel<OrganizationShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional(nullable: true)]
    public ?string $description;

    #[Optional(nullable: true)]
    public ?string $icon;

    #[Optional]
    public ?string $name;

    /** @var list<ProfileSummary>|null $profiles */
    #[Optional(list: ProfileSummary::class)]
    public ?array $profiles;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ProfileSummary|ProfileSummaryShape>|null $profiles
     */
    public static function with(
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?string $icon = null,
        ?string $name = null,
        ?array $profiles = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $icon && $self['icon'] = $icon;
        null !== $name && $self['name'] = $name;
        null !== $profiles && $self['profiles'] = $profiles;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withIcon(?string $icon): self
    {
        $self = clone $this;
        $self['icon'] = $icon;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param list<ProfileSummary|ProfileSummaryShape> $profiles
     */
    public function withProfiles(array $profiles): self
    {
        $self = clone $this;
        $self['profiles'] = $profiles;

        return $self;
    }
}
