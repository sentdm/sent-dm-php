<?php

declare(strict_types=1);

namespace SentDm\Conversations;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of the authenticated customer's messages across all conversations, ordered by created date (most recent first).
 *
 * @see SentDm\Services\ConversationsService::list()
 *
 * @phpstan-type ConversationListParamsShape = array{
 *   page?: int|null, pageSize?: int|null, xProfileID?: string|null
 * }
 */
final class ConversationListParams implements BaseModel
{
    /** @use SdkModel<ConversationListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?int $page;

    #[Optional]
    public ?int $pageSize;

    #[Optional]
    public ?string $xProfileID;

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
        ?int $page = null,
        ?int $pageSize = null,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;
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

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
