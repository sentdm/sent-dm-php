<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a specific contact by their unique identifier for the authenticated customer. The customer ID is extracted from the authentication token. Returns detailed contact information including phone number and creation timestamp.
 *
 * @see SentDm\Services\ContactsService::retrieveID()
 *
 * @phpstan-type ContactRetrieveIDParamsShape = array{
 *   id: string, xAPIKey: string, xSenderID: string
 * }
 */
final class ContactRetrieveIDParams implements BaseModel
{
    /** @use SdkModel<ContactRetrieveIDParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The unique identifier (GUID) of the resource to retrieve.
     */
    #[Required]
    public string $id;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * `new ContactRetrieveIDParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactRetrieveIDParams::with(id: ..., xAPIKey: ..., xSenderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactRetrieveIDParams)->withID(...)->withXAPIKey(...)->withXSenderID(...)
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
        string $id,
        string $xAPIKey,
        string $xSenderID
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

        return $self;
    }

    /**
     * The unique identifier (GUID) of the resource to retrieve.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
