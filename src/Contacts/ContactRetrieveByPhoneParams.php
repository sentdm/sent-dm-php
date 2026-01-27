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
 * @phpstan-type ContactRetrieveByPhoneParamsShape = array{phoneNumber: string}
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

    /**
     * `new ContactRetrieveByPhoneParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactRetrieveByPhoneParams::with(phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactRetrieveByPhoneParams)->withPhoneNumber(...)
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
    public static function with(string $phoneNumber): self
    {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;

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
}
