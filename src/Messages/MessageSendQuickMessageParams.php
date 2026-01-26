<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Sends a message to a phone number using the default template. This endpoint is rate limited to 5 messages per customer per day. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\MessagesService::sendQuickMessage()
 *
 * @phpstan-type MessageSendQuickMessageParamsShape = array{
 *   customMessage: string, phoneNumber: string
 * }
 */
final class MessageSendQuickMessageParams implements BaseModel
{
    /** @use SdkModel<MessageSendQuickMessageParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The custom message content to include in the template.
     */
    #[Required]
    public string $customMessage;

    /**
     * The phone number to send the message to, in international format (e.g., +1234567890).
     */
    #[Required]
    public string $phoneNumber;

    /**
     * `new MessageSendQuickMessageParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageSendQuickMessageParams::with(customMessage: ..., phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageSendQuickMessageParams)
     *   ->withCustomMessage(...)
     *   ->withPhoneNumber(...)
     * ```
     */
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
        string $customMessage,
        string $phoneNumber
    ): self {
        $self = new self;

        $self['customMessage'] = $customMessage;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * The custom message content to include in the template.
     */
    public function withCustomMessage(string $customMessage): self
    {
        $self = clone $this;
        $self['customMessage'] = $customMessage;

        return $self;
    }

    /**
     * The phone number to send the message to, in international format (e.g., +1234567890).
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }
}
