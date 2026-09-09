<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventTypesResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;
use SentDm\Webhooks\WebhookEventType;

/**
 * The webhook event types a customer can subscribe to.
 *
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type DataShape = array{
 *   eventTypes?: list<mixed>|null,
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * The event_types on this page.
     *
     * @var list<mixed>|null $eventTypes
     */
    #[Optional('event_types', list: WebhookEventType::class)]
    public ?array $eventTypes;

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
     * @param list<mixed>|null $eventTypes
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     */
    public static function with(
        ?array $eventTypes = null,
        PaginationMeta|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The event_types on this page.
     *
     * @param list<mixed> $eventTypes
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
     * @param PaginationMeta|PaginationMetaShape $pagination
     */
    public function withPagination(PaginationMeta|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }
}
