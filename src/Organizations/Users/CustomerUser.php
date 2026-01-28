<?php

declare(strict_types=1);

namespace SentDm\Organizations\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type CustomerUserShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   customerID?: string|null,
 *   email?: string|null,
 *   invitationSentAt?: \DateTimeInterface|null,
 *   invitationToken?: string|null,
 *   invitationTokenExpiresAt?: \DateTimeInterface|null,
 *   lastLoginAt?: \DateTimeInterface|null,
 *   name?: string|null,
 *   role?: string|null,
 *   status?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class CustomerUser implements BaseModel
{
    /** @use SdkModel<CustomerUserShape> */
    use SdkModel;

    /**
     * Unique identifier.
     */
    #[Optional]
    public ?string $id;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional('customerId')]
    public ?string $customerID;

    #[Optional]
    public ?string $email;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $invitationSentAt;

    #[Optional(nullable: true)]
    public ?string $invitationToken;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $invitationTokenExpiresAt;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $lastLoginAt;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?string $role;

    #[Optional]
    public ?string $status;

    #[Optional(nullable: true)]
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
        ?string $customerID = null,
        ?string $email = null,
        ?\DateTimeInterface $invitationSentAt = null,
        ?string $invitationToken = null,
        ?\DateTimeInterface $invitationTokenExpiresAt = null,
        ?\DateTimeInterface $lastLoginAt = null,
        ?string $name = null,
        ?string $role = null,
        ?string $status = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $email && $self['email'] = $email;
        null !== $invitationSentAt && $self['invitationSentAt'] = $invitationSentAt;
        null !== $invitationToken && $self['invitationToken'] = $invitationToken;
        null !== $invitationTokenExpiresAt && $self['invitationTokenExpiresAt'] = $invitationTokenExpiresAt;
        null !== $lastLoginAt && $self['lastLoginAt'] = $lastLoginAt;
        null !== $name && $self['name'] = $name;
        null !== $role && $self['role'] = $role;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Unique identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    public function withInvitationSentAt(
        ?\DateTimeInterface $invitationSentAt
    ): self {
        $self = clone $this;
        $self['invitationSentAt'] = $invitationSentAt;

        return $self;
    }

    public function withInvitationToken(?string $invitationToken): self
    {
        $self = clone $this;
        $self['invitationToken'] = $invitationToken;

        return $self;
    }

    public function withInvitationTokenExpiresAt(
        ?\DateTimeInterface $invitationTokenExpiresAt
    ): self {
        $self = clone $this;
        $self['invitationTokenExpiresAt'] = $invitationTokenExpiresAt;

        return $self;
    }

    public function withLastLoginAt(?\DateTimeInterface $lastLoginAt): self
    {
        $self = clone $this;
        $self['lastLoginAt'] = $lastLoginAt;

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

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
