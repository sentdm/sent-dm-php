<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of delivery events for the specified webhook.
 *
 * @see SentDm\Services\WebhooksService::listEvents()
 *
 * @phpstan-type WebhookListEventsParamsShape = array{
 *   page: int, pageSize: int, search?: string|null, xProfileID?: string|null
 * }
 */
final class WebhookListEventsParams implements BaseModel
{
    /** @use SdkModel<WebhookListEventsParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public int $page;

    #[Required]
    public int $pageSize;

    #[Optional(nullable: true)]
    public ?string $search;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new WebhookListEventsParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookListEventsParams::with(page: ..., pageSize: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookListEventsParams)->withPage(...)->withPageSize(...)
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
        ?string $search = null,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        $self['page'] = $page;
        $self['pageSize'] = $pageSize;

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
