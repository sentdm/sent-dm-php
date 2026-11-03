<?php

declare(strict_types=1);

namespace SentDm\WebhookEventsPage;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type DataShape = array{
 *   events?: list<mixed>|null, pagination?: null|PaginationMeta|PaginationMetaShape
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<mixed>|null $events */
    #[Optional(list: 'mixed')]
    public ?array $events;

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
     * @param list<mixed>|null $events
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     */
    public static function with(
        ?array $events = null,
        PaginationMeta|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $events && $self['events'] = $events;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * @param list<mixed> $events
     */
    public function withEvents(array $events): self
    {
        $self = clone $this;
        $self['events'] = $events;

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
