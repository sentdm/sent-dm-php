<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetActivitiesResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageGetActivitiesResponse\Data\Activity;

/**
 * The response data (null if error).
 *
 * @phpstan-import-type ActivityShape from \SentDm\Messages\MessageGetActivitiesResponse\Data\Activity
 *
 * @phpstan-type DataShape = array{
 *   activities?: list<Activity|ActivityShape>|null, messageID?: string|null
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
     */
    public static function with(
        ?array $activities = null,
        ?string $messageID = null
    ): self {
        $self = new self;

        null !== $activities && $self['activities'] = $activities;
        null !== $messageID && $self['messageID'] = $messageID;

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
}
