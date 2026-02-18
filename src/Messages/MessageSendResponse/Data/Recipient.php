<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageSendResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Per-recipient result in the send message response.
 *
 * @phpstan-type RecipientShape = array{
 *   channel?: string|null, messageID?: string|null, to?: string|null
 * }
 */
final class Recipient implements BaseModel
{
    /** @use SdkModel<RecipientShape> */
    use SdkModel;

    /**
     * Channel this message will be sent on (e.g. "sms", "whatsapp"), or null for auto-detect.
     */
    #[Optional(nullable: true)]
    public ?string $channel;

    /**
     * Unique message identifier for tracking this recipient's message.
     */
    #[Optional('message_id')]
    public ?string $messageID;

    /**
     * Phone number in E.164 format.
     */
    #[Optional]
    public ?string $to;

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
        ?string $channel = null,
        ?string $messageID = null,
        ?string $to = null
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $to && $self['to'] = $to;

        return $self;
    }

    /**
     * Channel this message will be sent on (e.g. "sms", "whatsapp"), or null for auto-detect.
     */
    public function withChannel(?string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * Unique message identifier for tracking this recipient's message.
     */
    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    /**
     * Phone number in E.164 format.
     */
    public function withTo(string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }
}
