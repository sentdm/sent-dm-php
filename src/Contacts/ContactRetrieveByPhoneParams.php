<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a contact by their phone number for the authenticated customer. Phone number should be in international format (e.g., +1234567890). The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\ContactsService::retrieveByPhone()
 *
 * @phpstan-type ContactRetrieveByPhoneParamsShape = array{
 *   phoneNumber: string, xAPIKey: string, xSenderID: string
 * }
 */
final class ContactRetrieveByPhoneParams implements BaseModel
{
    /** @use SdkModel<ContactRetrieveByPhoneParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The phone number in international format (e.g., +1234567890).
     */
    #[Required]
    public string $phoneNumber;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * `new ContactRetrieveByPhoneParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactRetrieveByPhoneParams::with(
     *   phoneNumber: ..., xAPIKey: ..., xSenderID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactRetrieveByPhoneParams)
     *   ->withPhoneNumber(...)
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
     */
    public static function with(
        string $phoneNumber,
        string $xAPIKey,
        string $xSenderID
    ): self {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;
        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

        return $self;
    }

    /**
     * The phone number in international format (e.g., +1234567890).
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

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
