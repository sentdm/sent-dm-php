<?php

declare(strict_types=1);

namespace SentDm\Users\UserListResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * User response for v3 API.
 *
 * @phpstan-type UserShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   email?: string|null,
 *   invitedAt?: \DateTimeInterface|null,
 *   lastLoginAt?: \DateTimeInterface|null,
 *   name?: string|null,
 *   role?: string|null,
 *   status?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class User implements BaseModel
{
    /** @use SdkModel<UserShape> */
    use SdkModel;

    /**
     * User unique identifier.
     */
    #[Optional]
    public ?string $id;

    /**
     * When the user was added to the organization.
     */
    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * User email address.
     */
    #[Optional]
    public ?string $email;

    /**
     * When the user was invited.
     */
    #[Optional('invited_at', nullable: true)]
    public ?\DateTimeInterface $invitedAt;

    /**
     * When the user last logged in.
     */
    #[Optional('last_login_at', nullable: true)]
    public ?\DateTimeInterface $lastLoginAt;

    /**
     * User full name.
     */
    #[Optional]
    public ?string $name;

    /**
     * User role in the organization: admin, billing, developer.
     */
    #[Optional]
    public ?string $role;

    /**
     * User status: active, invited, suspended, rejected.
     */
    #[Optional]
    public ?string $status;

    /**
     * When the user record was last updated.
     */
    #[Optional('updated_at', nullable: true)]
    public ?\DateTimeInterface $updatedAt;

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
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $email = null,
        ?\DateTimeInterface $invitedAt = null,
        ?\DateTimeInterface $lastLoginAt = null,
        ?string $name = null,
        ?string $role = null,
        ?string $status = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $email && $self['email'] = $email;
        null !== $invitedAt && $self['invitedAt'] = $invitedAt;
        null !== $lastLoginAt && $self['lastLoginAt'] = $lastLoginAt;
        null !== $name && $self['name'] = $name;
        null !== $role && $self['role'] = $role;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * User unique identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When the user was added to the organization.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * User email address.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * When the user was invited.
     */
    public function withInvitedAt(?\DateTimeInterface $invitedAt): self
    {
        $self = clone $this;
        $self['invitedAt'] = $invitedAt;

        return $self;
    }

    /**
     * When the user last logged in.
     */
    public function withLastLoginAt(?\DateTimeInterface $lastLoginAt): self
    {
        $self = clone $this;
        $self['lastLoginAt'] = $lastLoginAt;

        return $self;
    }

    /**
     * User full name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * User role in the organization: admin, billing, developer.
     */
    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * User status: active, invited, suspended, rejected.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When the user record was last updated.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
