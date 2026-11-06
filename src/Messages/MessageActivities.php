<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * Response for GET /messages/{id}/activities.
 *
 * @phpstan-import-type MessageActivityShape from \SentDm\Messages\MessageActivity
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type MessageActivitiesShape = array{
 *   activities?: list<MessageActivity|MessageActivityShape>|null,
 *   messageID?: string|null,
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 * }
 */
final class MessageActivities implements BaseModel
{
    /** @use SdkModel<MessageActivitiesShape> */
    use SdkModel;

    /**
     * List of activity events ordered by most recent first.
     *
     * @var list<MessageActivity>|null $activities
     */
    #[Optional(list: MessageActivity::class)]
    public ?array $activities;

    /**
     * The message ID these activities belong to.
     */
    #[Optional('message_id')]
    public ?string $messageID;

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
     * @param list<MessageActivity|MessageActivityShape>|null $activities
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     */
    public static function with(
        ?array $activities = null,
        ?string $messageID = null,
        PaginationMeta|array|null $pagination = null,
    ): self {
        $self = new self;

        null !== $activities && $self['activities'] = $activities;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * List of activity events ordered by most recent first.
     *
     * @param list<MessageActivity|MessageActivityShape> $activities
     */
    public function withActivities(array $activities): self
    {
        $self = clone $this;
        $self['activities'] = $activities;

        return $self;
    }

    /**
     * The message ID these activities belong to.
     */
    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

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
