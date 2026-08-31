<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventTypesResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\WebhookListEventTypesResponse\Data\EventType;
use SentDm\Webhooks\WebhookListEventTypesResponse\Data\Pagination;

/**
 * The webhook event types a customer can subscribe to.
 *
 * @phpstan-import-type EventTypeShape from \SentDm\Webhooks\WebhookListEventTypesResponse\Data\EventType
 * @phpstan-import-type PaginationShape from \SentDm\Webhooks\WebhookListEventTypesResponse\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   eventTypes?: list<EventType|EventTypeShape>|null,
 *   pagination?: null|Pagination|PaginationShape,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * The event_types on this page.
     *
     * @var list<EventType>|null $eventTypes
     */
    #[Optional('event_types', list: EventType::class)]
    public ?array $eventTypes;

    /**
     * Pagination metadata for list responses.
     */
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
     * @param list<EventType|EventTypeShape>|null $eventTypes
     * @param Pagination|PaginationShape|null $pagination
     */
    public static function with(
        ?array $eventTypes = null,
        Pagination|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The event_types on this page.
     *
     * @param list<EventType|EventTypeShape> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

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
}
