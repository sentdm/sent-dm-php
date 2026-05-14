<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileListResponse\Data\Profile;

/**
 * List of profiles response.
 *
 * @phpstan-import-type ProfileShape from \SentDm\Profiles\ProfileListResponse\Data\Profile
 *
 * @phpstan-type DataShape = array{profiles?: list<Profile|ProfileShape>|null}
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * List of profiles in the organization.
     *
     * @var list<Profile>|null $profiles
     */
    #[Optional(list: Profile::class)]
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
     * @param list<Profile|ProfileShape>|null $profiles
     */
    public static function with(?array $profiles = null): self
    {
        $self = new self;

        null !== $profiles && $self['profiles'] = $profiles;

        return $self;
    }

    /**
     * List of profiles in the organization.
     *
     * @param list<Profile|ProfileShape> $profiles
     */
    public function withProfiles(array $profiles): self
    {
        $self = clone $this;
        $self['profiles'] = $profiles;

        return $self;
    }
}
