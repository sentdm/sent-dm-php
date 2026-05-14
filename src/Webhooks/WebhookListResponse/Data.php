<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\WebhookListResponse\Data\Pagination;
use SentDm\Webhooks\WebhookListResponse\Data\Webhook;

/**
 * The response data (null if error).
 *
 * @phpstan-import-type PaginationShape from \SentDm\Webhooks\WebhookListResponse\Data\Pagination
 * @phpstan-import-type WebhookShape from \SentDm\Webhooks\WebhookListResponse\Data\Webhook
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|Pagination|PaginationShape,
 *   webhooks?: list<Webhook|WebhookShape>|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Pagination metadata for list responses.
     */
    #[Optional]
    public ?Pagination $pagination;

    /** @var list<Webhook>|null $webhooks */
    #[Optional(list: Webhook::class)]
    public ?array $webhooks;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Pagination|PaginationShape|null $pagination
     * @param list<Webhook|WebhookShape>|null $webhooks
     */
    public static function with(
        Pagination|array|null $pagination = null,
        ?array $webhooks = null
    ): self {
        $self = new self;

        null !== $pagination && $self['pagination'] = $pagination;
        null !== $webhooks && $self['webhooks'] = $webhooks;

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

    /**
     * @param list<Webhook|WebhookShape> $webhooks
     */
    public function withWebhooks(array $webhooks): self
    {
        $self = clone $this;
        $self['webhooks'] = $webhooks;

        return $self;
    }
}
