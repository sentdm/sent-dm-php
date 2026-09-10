<?php

declare(strict_types=1);

namespace SentDm\WebhooksPage\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type PaginationShape = array{
 *   hasMore?: bool|null, page?: int|null, totalPages?: int|null
 * }
 */
final class Pagination implements BaseModel
{
    /** @use SdkModel<PaginationShape> */
    use SdkModel;

    #[Optional('has_more')]
    public ?bool $hasMore;

    #[Optional]
    public ?int $page;

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
     */
    public static function with(
        ?bool $hasMore = null,
        ?int $page = null,
        ?int $totalPages = null
    ): self {
        $self = new self;

        null !== $hasMore && $self['hasMore'] = $hasMore;
        null !== $page && $self['page'] = $page;
        null !== $totalPages && $self['totalPages'] = $totalPages;

        return $self;
    }

    public function withHasMore(bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    public function withTotalPages(int $totalPages): self
    {
        $self = clone $this;
        $self['totalPages'] = $totalPages;

        return $self;
    }
}
