<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves the current status and details of a message by ID. Includes delivery status, timestamps, and error information if applicable.
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
