<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileListResponse\Data\Pagination;
use SentDm\Profiles\ProfileListResponse\Data\Profile;

/**
 * The profiles in the organization.
 *
 * @phpstan-import-type PaginationShape from \SentDm\Profiles\ProfileListResponse\Data\Pagination
 * @phpstan-import-type ProfileShape from \SentDm\Profiles\ProfileListResponse\Data\Profile
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|Pagination|PaginationShape,
 *   profiles?: list<Profile|ProfileShape>|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Pagination metadata for list responses.
     */
    #[Optional]
    public ?Pagination $pagination;

    /**
     * The profiles on this page.
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
     * @param Pagination|PaginationShape|null $pagination
     * @param list<Profile|ProfileShape>|null $profiles
     */
    public static function with(
        Pagination|array|null $pagination = null,
        ?array $profiles = null
    ): self {
        $self = new self;

        null !== $pagination && $self['pagination'] = $pagination;
        null !== $profiles && $self['profiles'] = $profiles;

        return $self;
    }

    /**
     * Pagination metadata for list responses.
     *
     * @param Pagination|PaginationShape $pagination
     */
    public function withPagination(Pagination|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The profiles on this page.
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
