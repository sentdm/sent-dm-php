<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Contacts\ContactDeleteParams\Body;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Dissociates a contact from the authenticated customer. Inherited contacts cannot be deleted.
 *
 * @see SentDm\Services\ContactsService::delete()
 *
 * @phpstan-import-type BodyShape from \SentDm\Contacts\ContactDeleteParams\Body
 *
 * @phpstan-type ContactDeleteParamsShape = array{
 *   body: Body|BodyShape, xProfileID?: string|null
 * }
 */
final class ContactDeleteParams implements BaseModel
{
    /** @use SdkModel<ContactDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Request to delete/dissociate a contact.
     */
    #[Required]
    public Body $body;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new ContactDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactDeleteParams::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactDeleteParams)->withBody(...)
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
     * @param Body|BodyShape $body
     */
    public static function with(
        Body|array $body,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        $self['body'] = $body;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Request to delete/dissociate a contact.
     *
     * @param Body|BodyShape $body
     */
    public function withBody(Body|array $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
