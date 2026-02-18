<?php

declare(strict_types=1);

namespace SentDm\Me\MeGetResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Me\MeGetResponse\Data\Profile;
use SentDm\Me\ProfileSettings;

/**
 * The response data (null if error).
 *
 * @phpstan-import-type ProfileShape from \SentDm\Me\MeGetResponse\Data\Profile
 * @phpstan-import-type ProfileSettingsShape from \SentDm\Me\ProfileSettings
 *
 * @phpstan-type DataShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   icon?: string|null,
 *   name?: string|null,
 *   profiles?: list<Profile|ProfileShape>|null,
 *   settings?: null|ProfileSettings|ProfileSettingsShape,
 *   status?: string|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Customer ID (organization or profile).
     */
    #[Optional]
    public ?string $id;

    /**
     * When the account was created.
     */
    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * Account description.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Account icon URL.
     */
    #[Optional(nullable: true)]
    public ?string $icon;

    /**
     * Account name.
     */
    #[Optional]
    public ?string $name;

    /**
     * List of profiles (only for organization type).
     *
     * @var list<Profile>|null $profiles
     */
    #[Optional(list: Profile::class, nullable: true)]
    public ?array $profiles;

    /**
     * Profile settings (only for profile type).
     */
    #[Optional(nullable: true)]
    public ?ProfileSettings $settings;

    /**
     * Profile status (only for profile type): incomplete, pending_review, approved, etc.
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
     * @param list<Profile|ProfileShape>|null $profiles
     * @param ProfileSettings|ProfileSettingsShape|null $settings
     */
    public static function with(
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?string $icon = null,
        ?string $name = null,
        ?array $profiles = null,
        ProfileSettings|array|null $settings = null,
        ?string $status = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $icon && $self['icon'] = $icon;
        null !== $name && $self['name'] = $name;
        null !== $profiles && $self['profiles'] = $profiles;
        null !== $settings && $self['settings'] = $settings;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * Customer ID (organization or profile).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When the account was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Account description.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Account icon URL.
     */
    public function withIcon(?string $icon): self
    {
        $self = clone $this;
        $self['icon'] = $icon;

        return $self;
    }

    /**
     * Account name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * List of profiles (only for organization type).
     *
     * @param list<Profile|ProfileShape>|null $profiles
     */
    public function withProfiles(?array $profiles): self
    {
        $self = clone $this;
        $self['profiles'] = $profiles;

        return $self;
    }

    /**
     * Profile settings (only for profile type).
     *
     * @param ProfileSettings|ProfileSettingsShape|null $settings
     */
    public function withSettings(ProfileSettings|array|null $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

        return $self;
    }

    /**
     * Profile status (only for profile type): incomplete, pending_review, approved, etc.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
