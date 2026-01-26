<?php

declare(strict_types=1);

namespace SentDm\Organizations;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ProfileSummaryShape from \SentDm\Organizations\ProfileSummary
 *
 * @phpstan-type OrganizationGetProfilesResponseShape = array{
 *   organizationID?: string|null,
 *   profiles?: list<ProfileSummary|ProfileSummaryShape>|null,
 * }
 */
final class OrganizationGetProfilesResponse implements BaseModel
{
    /** @use SdkModel<OrganizationGetProfilesResponseShape> */
    use SdkModel;

    #[Optional('organizationId')]
    public ?string $organizationID;

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
        ?string $organizationID = null,
        ?array $profiles = null
    ): self {
        $self = new self;

        null !== $organizationID && $self['organizationID'] = $organizationID;
        null !== $profiles && $self['profiles'] = $profiles;

        return $self;
    }

    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

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
