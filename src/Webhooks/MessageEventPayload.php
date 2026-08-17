<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of an outbound message lifecycle event. Delivered once per status change, so a single
 * message produces several of these as it moves toward a terminal status.
 *
 * @phpstan-type MessageEventPayloadShape = array{
 *   accountID?: string|null,
 *   agentID?: string|null,
 *   channel?: string|null,
 *   messageID?: string|null,
 *   messageStatus?: string|null,
 *   outboundNumber?: string|null,
 *   templateID?: string|null,
 *   templateName?: string|null,
 *   updatedAt?: string|null,
 * }
 */
final class MessageEventPayload implements BaseModel
{
    /** @use SdkModel<MessageEventPayloadShape> */
    use SdkModel;

    /**
     * The account the message belongs to.
     */
    #[Optional('account_id')]
    public ?string $accountID;

    /**
     * The agent attributed to the send, when the send was attributed to one.
     */
    #[Optional('agent_id', nullable: true)]
    public ?string $agentID;

    /**
     * The channel the message went out on, for example sms or whatsapp. A message
     * that falls back to another channel reports the channel actually used.
     */
    #[Optional]
    public ?string $channel;

    /**
     * The message this event describes. Stable across every event in the message's lifecycle, so
     * use it to correlate them.
     */
    #[Optional('message_id')]
    public ?string $messageID;

    /**
     * The status the message just reached, for example SENT, DELIVERED, or
     * FAILED. Sent means dispatched and delivered means confirmed, so treat them as
     * distinct outcomes.
     */
    #[Optional('message_status')]
    public ?string $messageStatus;

    /**
     * The recipient's number in E.164 format.
     */
    #[Optional('outbound_number')]
    public ?string $outboundNumber;

    /**
     * The template the message was sent from, when it was sent from one.
     */
    #[Optional('template_id', nullable: true)]
    public ?string $templateID;

    /**
     * Name of the template the message was sent from. Omitted when the message wasn't
     * template-based.
     */
    #[Optional('template_name', nullable: true)]
    public ?string $templateName;

    /**
     * When the message reached MessageStatus, in UTC
     * (yyyy-MM-ddTHH:mm:ssZ).
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
        ?string $agentID = null,
        ?string $channel = null,
        ?string $messageID = null,
        ?string $messageStatus = null,
        ?string $outboundNumber = null,
        ?string $templateID = null,
        ?string $templateName = null,
        ?string $updatedAt = null,
    ): self {
        $self = new self;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $agentID && $self['agentID'] = $agentID;
        null !== $channel && $self['channel'] = $channel;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $messageStatus && $self['messageStatus'] = $messageStatus;
        null !== $outboundNumber && $self['outboundNumber'] = $outboundNumber;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateName && $self['templateName'] = $templateName;
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
     * The agent attributed to the send, when the send was attributed to one.
     */
    public function withAgentID(?string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * The channel the message went out on, for example sms or whatsapp. A message
     * that falls back to another channel reports the channel actually used.
     */
    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * The message this event describes. Stable across every event in the message's lifecycle, so
     * use it to correlate them.
     */
    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    /**
     * The status the message just reached, for example SENT, DELIVERED, or
     * FAILED. Sent means dispatched and delivered means confirmed, so treat them as
     * distinct outcomes.
     */
    public function withMessageStatus(string $messageStatus): self
    {
        $self = clone $this;
        $self['messageStatus'] = $messageStatus;

        return $self;
    }

    /**
     * The recipient's number in E.164 format.
     */
    public function withOutboundNumber(string $outboundNumber): self
    {
        $self = clone $this;
        $self['outboundNumber'] = $outboundNumber;

        return $self;
    }

    /**
     * The template the message was sent from, when it was sent from one.
     */
    public function withTemplateID(?string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

        return $self;
    }

    /**
     * Name of the template the message was sent from. Omitted when the message wasn't
     * template-based.
     */
    public function withTemplateName(?string $templateName): self
    {
        $self = clone $this;
        $self['templateName'] = $templateName;

        return $self;
    }

    /**
     * When the message reached MessageStatus, in UTC
     * (yyyy-MM-ddTHH:mm:ssZ).
     */
    public function withUpdatedAt(string $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
