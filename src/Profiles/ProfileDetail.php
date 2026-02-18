<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileDetail\Settings;

/**
 * Detailed profile response for v3 API.
 *
 * @phpstan-import-type SettingsShape from \SentDm\Profiles\ProfileDetail\Settings
 *
 * @phpstan-type ProfileDetailShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   email?: string|null,
 *   icon?: string|null,
 *   name?: string|null,
 *   organizationID?: string|null,
 *   settings?: null|Settings|SettingsShape,
 *   shortName?: string|null,
 *   status?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class ProfileDetail implements BaseModel
{
    /** @use SdkModel<ProfileDetailShape> */
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
     * Profile email (inherited from organization).
     */
    #[Optional(nullable: true)]
    public ?string $email;

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
     * Parent organization ID.
     */
    #[Optional('organization_id', nullable: true)]
    public ?string $organizationID;

    /**
     * Profile configuration settings.
     */
    #[Optional]
    public ?Settings $settings;

    /**
     * Profile short name (abbreviation).
     */
    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    /**
     * Profile setup status: incomplete, pending_review, approved, rejected.
     */
    #[Optional]
    public ?string $status;

    /**
     * When the profile was last updated.
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
     * @param Settings|SettingsShape|null $settings
     */
    public static function with(
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?string $email = null,
        ?string $icon = null,
        ?string $name = null,
        ?string $organizationID = null,
        Settings|array|null $settings = null,
        ?string $shortName = null,
        ?string $status = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $email && $self['email'] = $email;
        null !== $icon && $self['icon'] = $icon;
        null !== $name && $self['name'] = $name;
        null !== $organizationID && $self['organizationID'] = $organizationID;
        null !== $settings && $self['settings'] = $settings;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

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
     * Profile email (inherited from organization).
     */
    public function withEmail(?string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

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
     * Parent organization ID.
     */
    public function withOrganizationID(?string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * Profile configuration settings.
     *
     * @param Settings|SettingsShape $settings
     */
    public function withSettings(Settings|array $settings): self
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
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When the profile was last updated.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
