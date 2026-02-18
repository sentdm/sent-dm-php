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
 *   email?: string|null,
 *   name?: string|null,
 *   role?: string|null,
 *   testMode?: bool|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class UserInviteParams implements BaseModel
{
    /** @use SdkModel<UserInviteParamsShape> */
    use SdkModel;
    use SdkParams;

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
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    #[Optional]
    public ?string $idempotencyKey;

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
        ?string $email = null,
        ?string $name = null,
        ?string $role = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $email && $self['email'] = $email;
        null !== $name && $self['name'] = $name;
        null !== $role && $self['role'] = $role;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

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
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withTestMode(bool $testMode): self
    {
        $self = clone $this;
        $self['testMode'] = $testMode;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
