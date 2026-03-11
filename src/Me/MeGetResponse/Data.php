<?php

declare(strict_types=1);

namespace SentDm\Me\MeGetResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Me\MeGetResponse\Data\Channels;
use SentDm\Me\MeGetResponse\Data\Profile;
use SentDm\Me\ProfileSettings;

/**
 * The response data (null if error).
 *
 * @phpstan-import-type ChannelsShape from \SentDm\Me\MeGetResponse\Data\Channels
 * @phpstan-import-type ProfileShape from \SentDm\Me\MeGetResponse\Data\Profile
 * @phpstan-import-type ProfileSettingsShape from \SentDm\Me\ProfileSettings
 *
 * @phpstan-type DataShape = array{
 *   id?: string|null,
 *   channels?: null|Channels|ChannelsShape,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   email?: string|null,
 *   icon?: string|null,
 *   name?: string|null,
 *   organizationID?: string|null,
 *   profiles?: list<Profile|ProfileShape>|null,
 *   settings?: null|ProfileSettings|ProfileSettingsShape,
 *   shortName?: string|null,
 *   status?: string|null,
 *   type?: string|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Customer ID (organization, account, or profile).
     */
    #[Optional]
    public ?string $id;

    /**
     * Messaging channel configuration.
     */
    #[Optional]
    public ?Channels $channels;

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
     * Contact email address.
     */
    #[Optional(nullable: true)]
    public ?string $email;

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
     * Organization ID (only for profile type — the parent organization).
     */
    #[Optional('organization_id', nullable: true)]
    public ?string $organizationID;

    /**
     * List of profiles (populated for organization type, empty for user and profile types).
     *
     * @var list<Profile>|null $profiles
     */
    #[Optional(list: Profile::class)]
    public ?array $profiles;

    /**
     * Profile settings (only for profile type).
     */
    #[Optional(nullable: true)]
    public ?ProfileSettings $settings;

    /**
     * Short name / abbreviation (only for profile type).
     */
    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    /**
     * Profile status (only for profile type): incomplete, pending_review, approved, etc.
     */
    #[Optional(nullable: true)]
    public ?string $status;

    /**
     * Account type: "organization" (has profiles), "user" (no profiles), or "profile" (child of an organization).
     */
    #[Optional]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Channels|ChannelsShape|null $channels
     * @param list<Profile|ProfileShape>|null $profiles
     * @param ProfileSettings|ProfileSettingsShape|null $settings
     */
    public static function with(
        ?string $id = null,
        Channels|array|null $channels = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?string $email = null,
        ?string $icon = null,
        ?string $name = null,
        ?string $organizationID = null,
        ?array $profiles = null,
        ProfileSettings|array|null $settings = null,
        ?string $shortName = null,
        ?string $status = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $channels && $self['channels'] = $channels;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $email && $self['email'] = $email;
        null !== $icon && $self['icon'] = $icon;
        null !== $name && $self['name'] = $name;
        null !== $organizationID && $self['organizationID'] = $organizationID;
        null !== $profiles && $self['profiles'] = $profiles;
        null !== $settings && $self['settings'] = $settings;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $status && $self['status'] = $status;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Customer ID (organization, account, or profile).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Messaging channel configuration.
     *
     * @param Channels|ChannelsShape $channels
     */
    public function withChannels(Channels|array $channels): self
    {
        $self = clone $this;
        $self['channels'] = $channels;

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
     * Contact email address.
     */
    public function withEmail(?string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

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
     * Organization ID (only for profile type — the parent organization).
     */
    public function withOrganizationID(?string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * List of profiles (populated for organization type, empty for user and profile types).
     *
     * @param list<Profile|ProfileShape> $profiles
     */
    public function withProfiles(array $profiles): self
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
     * Short name / abbreviation (only for profile type).
     */
    public function withShortName(?string $shortName): self
    {
        $self = clone $this;
        $self['shortName'] = $shortName;

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

    /**
     * Account type: "organization" (has profiles), "user" (no profiles), or "profile" (child of an organization).
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
