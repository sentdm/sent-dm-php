<?php

declare(strict_types=1);

namespace SentDm\Users\UserListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Users\UserListResponse\Data\User;

/**
 * List of users response.
 *
 * @phpstan-import-type UserShape from \SentDm\Users\UserListResponse\Data\User
 *
 * @phpstan-type DataShape = array{users?: list<User|UserShape>|null}
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * List of users in the organization.
     *
     * @var list<User>|null $users
     */
    #[Optional(list: User::class)]
    public ?array $users;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<User|UserShape>|null $users
     */
    public static function with(?array $users = null): self
    {
        $self = new self;

        null !== $users && $self['users'] = $users;

        return $self;
    }

    /**
     * List of users in the organization.
     *
     * @param list<User|UserShape> $users
     */
    public function withUsers(array $users): self
    {
        $self = clone $this;
        $self['users'] = $users;

        return $self;
    }
}
