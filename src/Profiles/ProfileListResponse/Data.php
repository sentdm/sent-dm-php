<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileDetail;
use SentDm\Webhooks\PaginationMeta;

/**
 * The profiles in the organization.
 *
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 * @phpstan-import-type ProfileDetailShape from \SentDm\Profiles\ProfileDetail
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 *   profiles?: list<ProfileDetail|ProfileDetailShape>|null,
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
    public ?PaginationMeta $pagination;

    /**
     * The profiles on this page.
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
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     * @param list<ProfileDetail|ProfileDetailShape>|null $profiles
     */
    public static function with(
        PaginationMeta|array|null $pagination = null,
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
     * @param PaginationMeta|PaginationMetaShape $pagination
     */
    public function withPagination(PaginationMeta|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The profiles on this page.
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
