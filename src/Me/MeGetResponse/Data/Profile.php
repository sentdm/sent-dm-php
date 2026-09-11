<?php

declare(strict_types=1);

namespace SentDm\Me\MeGetResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Me\ProfileSettings;

/**
 * Profile (sender profile) response for v3 API.
 *
 * @phpstan-import-type ProfileSettingsShape from \SentDm\Me\ProfileSettings
 *
 * @phpstan-type ProfileShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   icon?: string|null,
 *   name?: string|null,
 *   role?: string|null,
 *   settings?: null|ProfileSettings|ProfileSettingsShape,
 *   shortName?: string|null,
 *   status?: string|null,
 * }
 */
final class Profile implements BaseModel
{
    /** @use SdkModel<ProfileShape> */
    use SdkModel;

    /**
     * Profile unique identifier.
     */
    #[Optional]
    public ?string $id;

    /**
     * When the profile was created.
     */
    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * Profile description.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Profile icon URL.
     */
    #[Optional(nullable: true)]
    public ?string $icon;

    /**
     * Profile name.
     */
    #[Optional]
    public ?string $name;

    /**
     * User's role in this profile: admin, billing, developer (inherited from organization if not explicitly set).
     */
    #[Optional(nullable: true)]
    public ?string $role;

    /**
     * Profile configuration settings.
     */
    #[Optional]
    public ?ProfileSettings $settings;

    /**
     * Profile short name (abbreviation).
     */
    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    /**
     * Profile setup status: incomplete, pending_review, approved, rejected.
     */
    #[Optional(nullable: true)]
    public ?string $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ProfileSettings|ProfileSettingsShape|null $settings
     */
    public static function with(
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?string $icon = null,
        ?string $name = null,
        ?string $role = null,
        ProfileSettings|array|null $settings = null,
        ?string $shortName = null,
        ?string $status = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $icon && $self['icon'] = $icon;
        null !== $name && $self['name'] = $name;
        null !== $role && $self['role'] = $role;
        null !== $settings && $self['settings'] = $settings;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * Profile unique identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When the profile was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Profile description.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Profile icon URL.
     */
    public function withIcon(?string $icon): self
    {
        $self = clone $this;
        $self['icon'] = $icon;

        return $self;
    }

    /**
     * Profile name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * User's role in this profile: admin, billing, developer (inherited from organization if not explicitly set).
     */
    public function withRole(?string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * Profile configuration settings.
     *
     * @param ProfileSettings|ProfileSettingsShape $settings
     */
    public function withSettings(ProfileSettings|array $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

        return $self;
    }

    /**
     * Profile short name (abbreviation).
     */
    public function withShortName(?string $shortName): self
    {
        $self = clone $this;
        $self['shortName'] = $shortName;

        return $self;
    }

    /**
     * Profile setup status: incomplete, pending_review, approved, rejected.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
