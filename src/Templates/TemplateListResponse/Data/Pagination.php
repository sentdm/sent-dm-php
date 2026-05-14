<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateListResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateListResponse\Data\Pagination\Cursors;

/**
 * Pagination metadata for list responses.
 *
 * @phpstan-import-type CursorsShape from \SentDm\Templates\TemplateListResponse\Data\Pagination\Cursors
 *
 * @phpstan-type PaginationShape = array{
 *   cursors?: null|Cursors|CursorsShape,
 *   hasMore?: bool|null,
 *   page?: int|null,
 *   pageSize?: int|null,
 *   totalCount?: int|null,
 *   totalPages?: int|null,
 * }
 */
final class Pagination implements BaseModel
{
    /** @use SdkModel<PaginationShape> */
    use SdkModel;

    /**
     * Cursor-based pagination pointers.
     */
    #[Optional(nullable: true)]
    public ?Cursors $cursors;

    /**
     * Whether there are more pages after this one.
     */
    #[Optional('has_more')]
    public ?bool $hasMore;

    /**
     * Current page number (1-indexed).
     */
    #[Optional]
    public ?int $page;

    /**
     * Number of items per page.
     */
    #[Optional('page_size')]
    public ?int $pageSize;

    /**
     * Total number of items across all pages.
     */
    #[Optional('total_count')]
    public ?int $totalCount;

    /**
     * Total number of pages.
     */
    #[Optional('total_pages')]
    public ?int $totalPages;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Cursors|CursorsShape|null $cursors
     */
    public static function with(
        Cursors|array|null $cursors = null,
        ?bool $hasMore = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?int $totalCount = null,
        ?int $totalPages = null,
    ): self {
        $self = new self;

        null !== $cursors && $self['cursors'] = $cursors;
        null !== $hasMore && $self['hasMore'] = $hasMore;
        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $totalCount && $self['totalCount'] = $totalCount;
        null !== $totalPages && $self['totalPages'] = $totalPages;

        return $self;
    }

    /**
     * Cursor-based pagination pointers.
     *
     * @param Cursors|CursorsShape|null $cursors
     */
    public function withCursors(Cursors|array|null $cursors): self
    {
        $self = clone $this;
        $self['cursors'] = $cursors;

        return $self;
    }

    /**
     * Whether there are more pages after this one.
     */
    public function withHasMore(bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    /**
     * Current page number (1-indexed).
     */
    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Number of items per page.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Total number of items across all pages.
     */
    public function withTotalCount(int $totalCount): self
    {
        $self = clone $this;
        $self['totalCount'] = $totalCount;

        return $self;
    }

    /**
     * Total number of pages.
     */
    public function withTotalPages(int $totalPages): self
    {
        $self = clone $this;
        $self['totalPages'] = $totalPages;

        return $self;
    }
}
