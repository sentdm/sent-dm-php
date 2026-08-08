<?php

declare(strict_types=1);

namespace SentDm\Conversations;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of the messages in a single conversation (scoped to the authenticated customer), ordered by created date (most recent first).
 *
 * @see SentDm\Services\ConversationsService::listMessages()
 *
 * @phpstan-type ConversationListMessagesParamsShape = array{
 *   page: int, pageSize: int, xProfileID?: string|null
 * }
 */
final class ConversationListMessagesParams implements BaseModel
{
    /** @use SdkModel<ConversationListMessagesParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public int $page;

    #[Required]
    public int $pageSize;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new ConversationListMessagesParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ConversationListMessagesParams::with(page: ..., pageSize: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ConversationListMessagesParams)->withPage(...)->withPageSize(...)
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
        ?string $xProfileID = null
    ): self {
        $self = new self;

        $self['page'] = $page;
        $self['pageSize'] = $pageSize;

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
