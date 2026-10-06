<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves the current status and details of a message by ID. Includes delivery status, timestamps, and error information if applicable. A message that is or was held for a later time (a send you scheduled with scheduled_at, a quiet-hours hold, or a message you cancelled while it was held) is returned as a ScheduledMessageResponse: the same fields plus scheduled_at, the instant it is held for in UTC — or, on a CANCELLED message, the instant that was called off. A message sent immediately has no scheduled_at key.
 *
 * @see SentDm\Services\MessagesService::retrieveStatus()
 *
 * @phpstan-type MessageRetrieveStatusParamsShape = array{xProfileID?: string|null}
 */
final class MessageRetrieveStatusParams implements BaseModel
{
    /** @use SdkModel<MessageRetrieveStatusParamsShape> */
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
