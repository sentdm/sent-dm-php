<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageSendResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * What one recipient of a send got, as the API reports it.
 *
 * @phpstan-type RecipientShape = array{
 *   body?: string|null,
 *   channel?: string|null,
 *   messageID?: string|null,
 *   to?: string|null,
 * }
 */
final class Recipient implements BaseModel
{
    /** @use SdkModel<RecipientShape> */
    use SdkModel;

    /**
     * Resolved template body for this recipient's channel, or null when the channel is auto-detected.
     */
    #[Optional(nullable: true)]
    public ?string $body;

    /**
     * Channel this message will be sent on — sms, whatsapp — or null to auto-detect.
     */
    #[Optional(nullable: true)]
    public ?string $channel;

    /**
     * Identifier for tracking this recipient's message.
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
        ?string $body = null,
        ?string $channel = null,
        ?string $messageID = null,
        ?string $to = null,
    ): self {
        $self = new self;

        null !== $body && $self['body'] = $body;
        null !== $channel && $self['channel'] = $channel;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $to && $self['to'] = $to;

        return $self;
    }

    /**
     * Resolved template body for this recipient's channel, or null when the channel is auto-detected.
     */
    public function withBody(?string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Channel this message will be sent on — sms, whatsapp — or null to auto-detect.
     */
    public function withChannel(?string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * Identifier for tracking this recipient's message.
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
