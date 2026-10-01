<?php

declare(strict_types=1);

namespace SentDm\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * Paginated list of calls.
 *
 * @phpstan-import-type CallShape from \SentDm\Calls\Call
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type CallsListShape = array{
 *   calls?: list<Call|CallShape>|null,
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 * }
 */
final class CallsList implements BaseModel
{
    /** @use SdkModel<CallsListShape> */
    use SdkModel;

    /**
     * The calls on this page, most recent first.
     *
     * @var list<Call>|null $calls
     */
    #[Optional(list: Call::class)]
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
     * @param list<Call|CallShape>|null $calls
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
     * The calls on this page, most recent first.
     *
     * @param list<Call|CallShape> $calls
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
