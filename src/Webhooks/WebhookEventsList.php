<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A paginated list of webhook delivery records.
 *
 * @phpstan-import-type WebhookDeliveryShape from \SentDm\Webhooks\WebhookDelivery
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type WebhookEventsListShape = array{
 *   events?: list<WebhookDelivery|WebhookDeliveryShape>|null,
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 * }
 */
final class WebhookEventsList implements BaseModel
{
    /** @use SdkModel<WebhookEventsListShape> */
    use SdkModel;

    /**
     * The events on this page.
     *
     * @var list<WebhookDelivery>|null $events
     */
    #[Optional(list: WebhookDelivery::class)]
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
     * @param list<WebhookDelivery|WebhookDeliveryShape>|null $events
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
     * The events on this page.
     *
     * @param list<WebhookDelivery|WebhookDeliveryShape> $events
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
