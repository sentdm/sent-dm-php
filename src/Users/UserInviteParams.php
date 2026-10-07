<?php

declare(strict_types=1);

namespace SentDm\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Sends an invitation to a user to join the organization or profile with a specific role. Requires admin role. The user will receive an invitation email with a token to accept. Invitation tokens expire after 7 days.
 *
 * @see SentDm\Services\UsersService::invite()
 *
 * @phpstan-type UserInviteParamsShape = array{
 *   apiKey?: string|null,
 *   email?: string|null,
 *   name?: string|null,
 *   role?: string|null,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class UserInviteParams implements BaseModel
{
    /** @use SdkModel<UserInviteParamsShape> */
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
     * User email address (required).
     */
    #[Optional]
    public ?string $email;

    /**
     * User full name (required).
     */
    #[Optional]
    public ?string $name;

    /**
     * User role: admin, billing, or developer (required).
     */
    #[Optional]
    public ?string $role;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $idempotencyKey;

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
        ?string $email = null,
        ?string $name = null,
        ?string $role = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $apiKey && $self['apiKey'] = $apiKey;
        null !== $email && $self['email'] = $email;
        null !== $name && $self['name'] = $name;
        null !== $role && $self['role'] = $role;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
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
     * User email address (required).
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * User full name (required).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * User role: admin, billing, or developer (required).
     */
    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

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

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
