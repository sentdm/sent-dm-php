<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of webhooks for the authenticated customer.
 *
 * @see SentDm\Services\WebhooksService::list()
 *
 * @phpstan-type WebhookListParamsShape = array{
 *   page: int,
 *   pageSize: int,
 *   isActive?: bool|null,
 *   search?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class WebhookListParams implements BaseModel
{
    /** @use SdkModel<WebhookListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public int $page;

    #[Required]
    public int $pageSize;

    #[Optional(nullable: true)]
    public ?bool $isActive;

    #[Optional(nullable: true)]
    public ?string $search;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new WebhookListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookListParams::with(page: ..., pageSize: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookListParams)->withPage(...)->withPageSize(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        int $page,
        int $pageSize,
        ?bool $isActive = null,
        ?string $search = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['page'] = $page;
        $self['pageSize'] = $pageSize;

        null !== $isActive && $self['isActive'] = $isActive;
        null !== $search && $self['search'] = $search;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    public function withIsActive(?bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    public function withSearch(?string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
