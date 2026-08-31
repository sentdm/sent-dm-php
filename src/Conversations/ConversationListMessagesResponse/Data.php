<?php

declare(strict_types=1);

namespace SentDm\Conversations\ConversationListMessagesResponse;

use SentDm\Conversations\ConversationListMessagesResponse\Data\Message;
use SentDm\Conversations\ConversationListMessagesResponse\Data\Pagination;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A paginated list of messages — used by both conversation read endpoints.
 *
 * @phpstan-import-type MessageShape from \SentDm\Conversations\ConversationListMessagesResponse\Data\Message
 * @phpstan-import-type PaginationShape from \SentDm\Conversations\ConversationListMessagesResponse\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   messages?: list<Message|MessageShape>|null,
 *   pagination?: null|Pagination|PaginationShape,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * The messages on this page.
     *
     * @var list<Message>|null $messages
     */
    #[Optional(list: Message::class)]
    public ?array $messages;

    /**
     * Pagination metadata for list responses.
     */
    #[Optional]
    public ?Pagination $pagination;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Message|MessageShape>|null $messages
     * @param Pagination|PaginationShape|null $pagination
     */
    public static function with(
        ?array $messages = null,
        Pagination|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $messages && $self['messages'] = $messages;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The messages on this page.
     *
     * @param list<Message|MessageShape> $messages
     */
    public function withMessages(array $messages): self
    {
        $self = clone $this;
        $self['messages'] = $messages;

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
}
