<?php

declare(strict_types=1);

namespace SentDm\WebhookEventsPage;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\WebhookEventsPage\Data\Pagination;

/**
 * @phpstan-import-type PaginationShape from \SentDm\WebhookEventsPage\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   events?: list<mixed>|null, pagination?: null|Pagination|PaginationShape
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<mixed>|null $events */
    #[Optional(list: 'mixed')]
    public ?array $events;

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
     * @param list<mixed>|null $events
     * @param Pagination|PaginationShape|null $pagination
     */
    public static function with(
        ?array $events = null,
        Pagination|array|null $pagination = null
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
     * @param Pagination|PaginationShape $pagination
     */
    public function withPagination(Pagination|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }
}
