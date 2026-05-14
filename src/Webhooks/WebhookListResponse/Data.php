<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;
use SentDm\Webhooks\WebhookResponse;

/**
 * The response data (null if error).
 *
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 * @phpstan-import-type WebhookResponseShape from \SentDm\Webhooks\WebhookResponse
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 *   webhooks?: list<WebhookResponse|WebhookResponseShape>|null,
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

    /** @var list<WebhookResponse>|null $webhooks */
    #[Optional(list: WebhookResponse::class)]
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
     * @param list<WebhookResponse|WebhookResponseShape>|null $webhooks
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
     * @param list<WebhookResponse|WebhookResponseShape> $webhooks
     */
    public function withWebhooks(array $webhooks): self
    {
        $self = clone $this;
        $self['webhooks'] = $webhooks;

        return $self;
    }
}
