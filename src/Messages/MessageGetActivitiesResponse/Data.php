<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetActivitiesResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageGetActivitiesResponse\Data\Activity;
use SentDm\Messages\MessageGetActivitiesResponse\Data\Pagination;

/**
 * Response for GET /messages/{id}/activities.
 *
 * @phpstan-import-type ActivityShape from \SentDm\Messages\MessageGetActivitiesResponse\Data\Activity
 * @phpstan-import-type PaginationShape from \SentDm\Messages\MessageGetActivitiesResponse\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   activities?: list<Activity|ActivityShape>|null,
 *   messageID?: string|null,
 *   pagination?: null|Pagination|PaginationShape,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * List of activity events ordered by most recent first.
     *
     * @var list<Activity>|null $activities
     */
    #[Optional(list: Activity::class)]
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
     * @param list<Activity|ActivityShape>|null $activities
     * @param Pagination|PaginationShape|null $pagination
     */
    public static function with(
        ?array $activities = null,
        ?string $messageID = null,
        Pagination|array|null $pagination = null,
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
     * @param list<Activity|ActivityShape> $activities
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
     * @param Pagination|PaginationShape $pagination
     */
    public function withPagination(Pagination|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }
}
