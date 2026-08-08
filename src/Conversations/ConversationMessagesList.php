<?php

declare(strict_types=1);

namespace SentDm\Conversations;

use SentDm\Conversations\ConversationMessagesList\Message;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * A paginated list of messages — used by both conversation read endpoints.
 *
 * @phpstan-import-type MessageShape from \SentDm\Conversations\ConversationMessagesList\Message
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type ConversationMessagesListShape = array{
 *   messages?: list<Message|MessageShape>|null,
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 * }
 */
final class ConversationMessagesList implements BaseModel
{
    /** @use SdkModel<ConversationMessagesListShape> */
    use SdkModel;

    /**
     * The messages on this page, most recent first.
     *
     * @var list<Message>|null $messages
     */
    #[Optional(list: Message::class)]
    public ?array $messages;

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
     * @param list<Message|MessageShape>|null $messages
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     */
    public static function with(
        ?array $messages = null,
        PaginationMeta|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $messages && $self['messages'] = $messages;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The messages on this page, most recent first.
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
     * @param PaginationMeta|PaginationMetaShape $pagination
     */
    public function withPagination(PaginationMeta|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }
}
