<?php

declare(strict_types=1);

namespace SentDm\WebhooksPage;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\WebhooksPage\Data\Pagination;

/**
 * @phpstan-import-type PaginationShape from \SentDm\WebhooksPage\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|Pagination|PaginationShape, webhooks?: list<mixed>|null
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    #[Optional]
    public ?Pagination $pagination;

    /** @var list<mixed>|null $webhooks */
    #[Optional(list: 'mixed')]
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
     * @param list<mixed>|null $webhooks
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
     * @param Pagination|PaginationShape $pagination
     */
    public function withPagination(Pagination|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * @param list<mixed> $webhooks
     */
    public function withWebhooks(array $webhooks): self
    {
        $self = clone $this;
        $self['webhooks'] = $webhooks;

        return $self;
    }
}
