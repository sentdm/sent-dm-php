<?php

declare(strict_types=1);

namespace SentDm\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Updates a user's role in the organization or profile. Requires admin role. You cannot change your own role or demote the last admin.
 *
 * @see SentDm\Services\UsersService::updateRole()
 *
 * @phpstan-type UserUpdateRoleParamsShape = array{
 *   role?: string|null,
 *   testMode?: bool|null,
 *   userID?: string|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class UserUpdateRoleParams implements BaseModel
{
    /** @use SdkModel<UserUpdateRoleParamsShape> */
    use SdkModel;
    use SdkParams;

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

    /**
     * User ID from route parameter.
     */
    #[Optional('user_id')]
    public ?string $userID;

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
        ?string $role = null,
        ?bool $testMode = null,
        ?string $userID = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $role && $self['role'] = $role;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $userID && $self['userID'] = $userID;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

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

    /**
     * User ID from route parameter.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
