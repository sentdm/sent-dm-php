<?php

declare(strict_types=1);

namespace SentDm\CallsPage;

use SentDm\CallsPage\Data\Pagination;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PaginationShape from \SentDm\CallsPage\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   calls?: list<mixed>|null, pagination?: null|Pagination|PaginationShape
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<mixed>|null $calls */
    #[Optional(list: 'mixed')]
    public ?array $calls;

    #[Optional]
    public ?Pagination $pagination;

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
     * @param Pagination|PaginationShape|null $pagination
     */
    public static function with(
        ?array $calls = null,
        Pagination|array|null $pagination = null
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
     * @param Pagination|PaginationShape $pagination
     */
    public function withPagination(Pagination|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }
}
