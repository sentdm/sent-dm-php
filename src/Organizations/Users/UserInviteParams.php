<?php

declare(strict_types=1);

namespace SentDm\Organizations\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Invites a user to an organization or sender profile with a specified role. Requires appropriate permissions. The customerId can be either an organization ID or a profile ID.
 *
 * @see SentDm\Services\Organizations\UsersService::invite()
 *
 * @phpstan-type UserInviteParamsShape = array{
 *   email?: string|null,
 *   invitedBy?: string|null,
 *   name?: string|null,
 *   role?: string|null,
 * }
 */
final class UserInviteParams implements BaseModel
{
    /** @use SdkModel<UserInviteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $email;

    #[Optional(nullable: true)]
    public ?string $invitedBy;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?string $role;

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
        ?string $invitedBy = null,
        ?string $name = null,
        ?string $role = null,
    ): self {
        $self = new self;

        null !== $email && $self['email'] = $email;
        null !== $invitedBy && $self['invitedBy'] = $invitedBy;
        null !== $name && $self['name'] = $name;
        null !== $role && $self['role'] = $role;

        return $self;
    }

    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    public function withInvitedBy(?string $invitedBy): self
    {
        $self = clone $this;
        $self['invitedBy'] = $invitedBy;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
