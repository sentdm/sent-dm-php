<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves the activity log for a specific message. Activities track the message lifecycle including acceptance, processing, sending, delivery, and any errors. A SCHEDULED entry carries scheduled_at, the release instant in UTC as it stood at that moment. Other entries have no scheduled_at key.
 *
 * @see SentDm\Services\MessagesService::retrieveActivities()
 *
 * @phpstan-type MessageRetrieveActivitiesParamsShape = array{
 *   xProfileID?: string|null
 * }
 */
final class MessageRetrieveActivitiesParams implements BaseModel
{
    /** @use SdkModel<MessageRetrieveActivitiesParamsShape> */
    use SdkModel;
    use SdkParams;

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
    public static function with(?string $xProfileID = null): self
    {
        $self = new self;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
