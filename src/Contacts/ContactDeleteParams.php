<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * **Deprecated.** Use `PATCH /v3/contacts/{id}` with `{"opt_out": true}` instead, and expect this to be removed in a future release. It still behaves exactly as before, so nothing needs to change today.
 *
 * Opting a contact out stops every send to them, which is what deleting one was mostly used for — and it keeps the record of who they were and that they asked. A delete discards the consent history along with the contact, which is the part you need if anyone ever asks why you stopped, or why you started again.
 *
 * Dissociates a contact from the authenticated customer.
 *
 * @deprecated
 * @see SentDm\Services\ContactsService::delete()
 *
 * @phpstan-type ContactDeleteParamsShape = array{
 *   apiKey?: string|null, sandbox?: bool|null, xProfileID?: string|null
 * }
 */
final class ContactDeleteParams implements BaseModel
{
    /** @use SdkModel<ContactDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     */
    #[Optional]
    public ?string $apiKey;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $xProfileID;

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
        ?string $apiKey = null,
        ?bool $sandbox = null,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        null !== $apiKey && $self['apiKey'] = $apiKey;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     */
    public function withAPIKey(string $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
