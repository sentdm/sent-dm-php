<?php

declare(strict_types=1);

namespace SentDm\Users\UserListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Users\UserListResponse\Data\Pagination;
use SentDm\Users\UserListResponse\Data\User;

/**
 * The users in the organization.
 *
 * @phpstan-import-type PaginationShape from \SentDm\Users\UserListResponse\Data\Pagination
 * @phpstan-import-type UserShape from \SentDm\Users\UserListResponse\Data\User
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|Pagination|PaginationShape,
 *   users?: list<User|UserShape>|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Pagination metadata for list responses.
     */
    #[Optional]
    public ?Pagination $pagination;

    /**
     * The users on this page.
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
     * @param Pagination|PaginationShape|null $pagination
     * @param list<User|UserShape>|null $users
     */
    public static function with(
        Pagination|array|null $pagination = null,
        ?array $users = null
    ): self {
        $self = new self;

        null !== $pagination && $self['pagination'] = $pagination;
        null !== $users && $self['users'] = $users;

        return $self;
    }

    /**
     * Pagination metadata for list responses.
     *
     * @param Pagination|PaginationShape $pagination
     */
    public function withPagination(Pagination|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The users on this page.
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
