<?php

declare(strict_types=1);

namespace SentDm\CallsPage;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type DataShape = array{
 *   calls?: list<mixed>|null, pagination?: null|PaginationMeta|PaginationMetaShape
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<mixed>|null $calls */
    #[Optional(list: 'mixed')]
    public ?array $calls;

    /**
     * Pagination metadata for list responses.
     */
    #[Optional]
    public ?PaginationMeta $pagination;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<mixed>|null $calls
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     */
    public static function with(
        ?array $calls = null,
        PaginationMeta|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $calls && $self['calls'] = $calls;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * @param list<mixed> $calls
     */
    public function withCalls(array $calls): self
    {
        $self = clone $this;
        $self['calls'] = $calls;

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
}
