<?php

declare(strict_types=1);

namespace SentDm\ConversationsPage;

use SentDm\ConversationsPage\Data\Pagination;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PaginationShape from \SentDm\ConversationsPage\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   messages?: list<mixed>|null, pagination?: null|Pagination|PaginationShape
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<mixed>|null $messages */
    #[Optional(list: 'mixed')]
    public ?array $messages;

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
     * @param list<mixed>|null $messages
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
     * @param list<mixed> $messages
     */
    public function withMessages(array $messages): self
    {
        $self = clone $this;
        $self['messages'] = $messages;

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
}
