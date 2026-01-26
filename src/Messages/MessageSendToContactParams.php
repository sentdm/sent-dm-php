<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Sends a message to a specific contact using a template. The message can be sent via SMS or WhatsApp depending on the contact's capabilities. Optionally specify a webhook URL to receive delivery status updates. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\MessagesService::sendToContact()
 *
 * @phpstan-type MessageSendToContactParamsShape = array{
 *   contactID: string,
 *   templateID: string,
 *   xAPIKey: string,
 *   xSenderID: string,
 *   templateVariables?: array<string,string>|null,
 * }
 */
final class MessageSendToContactParams implements BaseModel
{
    /** @use SdkModel<MessageSendToContactParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The unique identifier of the contact to send the message to.
     */
    #[Required('contactId')]
    public string $contactID;

    /**
     * The unique identifier of the template to use for the message.
     */
    #[Required('templateId')]
    public string $templateID;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * Optional key-value pairs of template variables to replace in the template body. For example, if your template contains "Hello {{name}}", you would provide { "name": "John Doe" }.
     *
     * @var array<string,string>|null $templateVariables
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $templateVariables;

    /**
     * `new MessageSendToContactParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageSendToContactParams::with(
     *   contactID: ..., templateID: ..., xAPIKey: ..., xSenderID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageSendToContactParams)
     *   ->withContactID(...)
     *   ->withTemplateID(...)
     *   ->withXAPIKey(...)
     *   ->withXSenderID(...)
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
        string $contactID,
        string $templateID,
        string $xAPIKey,
        string $xSenderID,
        ?array $templateVariables = null,
    ): self {
        $self = new self;

        $self['contactID'] = $contactID;
        $self['templateID'] = $templateID;
        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

        null !== $templateVariables && $self['templateVariables'] = $templateVariables;

        return $self;
    }

    /**
     * The unique identifier of the contact to send the message to.
     */
    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

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

    public function withXAPIKey(string $xAPIKey): self
    {
        $self = clone $this;
        $self['xAPIKey'] = $xAPIKey;

        return $self;
    }

    public function withXSenderID(string $xSenderID): self
    {
        $self = clone $this;
        $self['xSenderID'] = $xSenderID;

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
