<?php

declare(strict_types=1);

namespace SentDm\WebhooksPage;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|PaginationMeta|PaginationMetaShape, webhooks?: list<mixed>|null
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
    public ?PaginationMeta $pagination;

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
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     * @param list<mixed>|null $webhooks
     */
    public static function with(
        PaginationMeta|array|null $pagination = null,
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
     * @param PaginationMeta|PaginationMetaShape $pagination
     */
    public function withPagination(PaginationMeta|array $pagination): self
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
