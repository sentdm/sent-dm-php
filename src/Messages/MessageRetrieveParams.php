<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves comprehensive details about a specific message using the message ID. Returns complete message data including delivery status, channel information, template details, contact information, and pricing. The customer ID is extracted from the authentication token to ensure the message belongs to the authenticated customer.
 *
 * @see SentDm\Services\MessagesService::retrieve()
 *
 * @phpstan-type MessageRetrieveParamsShape = array{
 *   xAPIKey: string, xSenderID: string
 * }
 */
final class MessageRetrieveParams implements BaseModel
{
    /** @use SdkModel<MessageRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * `new MessageRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageRetrieveParams::with(xAPIKey: ..., xSenderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageRetrieveParams)->withXAPIKey(...)->withXSenderID(...)
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
    public static function with(string $xAPIKey, string $xSenderID): self
    {
        $self = new self;

        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

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
}
