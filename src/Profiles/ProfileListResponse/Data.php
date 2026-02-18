<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileDetail;

/**
 * The response data (null if error).
 *
 * @phpstan-import-type ProfileDetailShape from \SentDm\Profiles\ProfileDetail
 *
 * @phpstan-type DataShape = array{
 *   profiles?: list<ProfileDetail|ProfileDetailShape>|null
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * List of profiles in the organization.
     *
     * @var list<ProfileDetail>|null $profiles
     */
    #[Optional(list: ProfileDetail::class)]
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
     * @param list<ProfileDetail|ProfileDetailShape>|null $profiles
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
     * @param list<ProfileDetail|ProfileDetailShape> $profiles
     */
    public function withProfiles(array $profiles): self
    {
        $self = clone $this;
        $self['profiles'] = $profiles;

        return $self;
    }
}
