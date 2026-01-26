<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TemplateResponseShape from \SentDm\Templates\TemplateResponse
 *
 * @phpstan-type TemplateListResponseShape = array{
 *   items?: list<TemplateResponse|TemplateResponseShape>|null,
 *   page?: int|null,
 *   pageSize?: int|null,
 *   totalCount?: int|null,
 *   totalPages?: int|null,
 * }
 */
final class TemplateListResponse implements BaseModel
{
    /** @use SdkModel<TemplateListResponseShape> */
    use SdkModel;

    /** @var list<TemplateResponse>|null $items */
    #[Optional(list: TemplateResponse::class)]
    public ?array $items;

    #[Optional]
    public ?int $page;

    #[Optional]
    public ?int $pageSize;

    #[Optional]
    public ?int $totalCount;

    #[Optional]
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
     * @param list<TemplateResponse|TemplateResponseShape>|null $items
     */
    public static function with(
        ?array $items = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?int $totalCount = null,
        ?int $totalPages = null,
    ): self {
        $self = new self;

        null !== $items && $self['items'] = $items;
        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $totalCount && $self['totalCount'] = $totalCount;
        null !== $totalPages && $self['totalPages'] = $totalPages;

        return $self;
    }

    /**
     * @param list<TemplateResponse|TemplateResponseShape> $items
     */
    public function withItems(array $items): self
    {
        $self = clone $this;
        $self['items'] = $items;

        return $self;
    }

    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    public function withTotalCount(int $totalCount): self
    {
        $self = clone $this;
        $self['totalCount'] = $totalCount;

        return $self;
    }

    public function withTotalPages(int $totalPages): self
    {
        $self = clone $this;
        $self['totalPages'] = $totalPages;

        return $self;
    }
}
