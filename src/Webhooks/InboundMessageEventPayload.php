<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of a message.received event. Delivered when a contact messages one of your numbers.
 *
 * @phpstan-type InboundMessageEventPayloadShape = array{
 *   accountID?: string|null,
 *   channel?: string|null,
 *   inboundNumber?: string|null,
 *   messageID?: string|null,
 *   outboundNumber?: string|null,
 *   receivedAt?: string|null,
 *   text?: string|null,
 *   updatedAt?: string|null,
 * }
 */
final class InboundMessageEventPayload implements BaseModel
{
    /** @use SdkModel<InboundMessageEventPayloadShape> */
    use SdkModel;

    /**
     * The account the message belongs to.
     */
    #[Optional('account_id')]
    public ?string $accountID;

    /**
     * The channel the message arrived on, for example sms or whatsapp.
     */
    #[Optional]
    public ?string $channel;

    /**
     * The contact's number in E.164 format, meaning the number the message came from.
     */
    #[Optional('inbound_number')]
    public ?string $inboundNumber;

    /**
     * The inbound message.
     */
    #[Optional('message_id')]
    public ?string $messageID;

    /**
     * Your number in E.164 format, meaning the number the message was addressed to.
     */
    #[Optional('outbound_number')]
    public ?string $outboundNumber;

    /**
     * When the message was received, in UTC (yyyy-MM-ddTHH:mm:ssZ).
     */
    #[Optional('received_at')]
    public ?string $receivedAt;

    /**
     * The message body. Sent as null when the inbound message carried no text, for
     * example a media-only message. The field is always present, so read it and check for null
     * rather than checking whether the key exists.
     */
    #[Optional(nullable: true)]
    public ?string $text;

    /**
     * When the message was received, in UTC (yyyy-MM-ddTHH:mm:ssZ). Same value as
     * ReceivedAt, kept for envelope consistency with outbound events.
     */
    #[Optional('updated_at')]
    public ?string $updatedAt;

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
        ?string $accountID = null,
        ?string $channel = null,
        ?string $inboundNumber = null,
        ?string $messageID = null,
        ?string $outboundNumber = null,
        ?string $receivedAt = null,
        ?string $text = null,
        ?string $updatedAt = null,
    ): self {
        $self = new self;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $channel && $self['channel'] = $channel;
        null !== $inboundNumber && $self['inboundNumber'] = $inboundNumber;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $outboundNumber && $self['outboundNumber'] = $outboundNumber;
        null !== $receivedAt && $self['receivedAt'] = $receivedAt;
        null !== $text && $self['text'] = $text;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The account the message belongs to.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * The channel the message arrived on, for example sms or whatsapp.
     */
    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * The contact's number in E.164 format, meaning the number the message came from.
     */
    public function withInboundNumber(string $inboundNumber): self
    {
        $self = clone $this;
        $self['inboundNumber'] = $inboundNumber;

        return $self;
    }

    /**
     * The inbound message.
     */
    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    /**
     * Your number in E.164 format, meaning the number the message was addressed to.
     */
    public function withOutboundNumber(string $outboundNumber): self
    {
        $self = clone $this;
        $self['outboundNumber'] = $outboundNumber;

        return $self;
    }

    /**
     * When the message was received, in UTC (yyyy-MM-ddTHH:mm:ssZ).
     */
    public function withReceivedAt(string $receivedAt): self
    {
        $self = clone $this;
        $self['receivedAt'] = $receivedAt;

        return $self;
    }

    /**
     * The message body. Sent as null when the inbound message carried no text, for
     * example a media-only message. The field is always present, so read it and check for null
     * rather than checking whether the key exists.
     */
    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * When the message was received, in UTC (yyyy-MM-ddTHH:mm:ssZ). Same value as
     * ReceivedAt, kept for envelope consistency with outbound events.
     */
    public function withUpdatedAt(string $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
