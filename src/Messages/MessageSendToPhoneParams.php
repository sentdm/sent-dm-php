<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Sends a message to a phone number using a template. The phone number doesn't need to be a pre-existing contact. The message can be sent via SMS or WhatsApp. Optionally specify a webhook URL to receive delivery status updates. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\MessagesService::sendToPhone()
 *
 * @phpstan-type MessageSendToPhoneParamsShape = array{
 *   phoneNumber: string,
 *   templateID: string,
 *   templateVariables?: array<string,string>|null,
 * }
 */
final class MessageSendToPhoneParams implements BaseModel
{
    /** @use SdkModel<MessageSendToPhoneParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The phone number to send the message to, in international format (e.g., +1234567890).
     */
    #[Required]
    public string $phoneNumber;

    /**
     * The unique identifier of the template to use for the message.
     */
    #[Required('templateId')]
    public string $templateID;

    /**
     * Optional key-value pairs of template variables to replace in the template body. For example, if your template contains "Hello {{name}}", you would provide { "name": "John Doe" }.
     *
     * @var array<string,string>|null $templateVariables
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $templateVariables;

    /**
     * `new MessageSendToPhoneParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageSendToPhoneParams::with(phoneNumber: ..., templateID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageSendToPhoneParams)->withPhoneNumber(...)->withTemplateID(...)
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
     *
     * @param array<string,string>|null $templateVariables
     */
    public static function with(
        string $phoneNumber,
        string $templateID,
        ?array $templateVariables = null
    ): self {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;
        $self['templateID'] = $templateID;

        null !== $templateVariables && $self['templateVariables'] = $templateVariables;

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

    /**
     * The unique identifier of the template to use for the message.
     */
    public function withTemplateID(string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

        return $self;
    }

    /**
     * Optional key-value pairs of template variables to replace in the template body. For example, if your template contains "Hello {{name}}", you would provide { "name": "John Doe" }.
     *
     * @param array<string,string>|null $templateVariables
     */
    public function withTemplateVariables(?array $templateVariables): self
    {
        $self = clone $this;
        $self['templateVariables'] = $templateVariables;

        return $self;
    }
}
