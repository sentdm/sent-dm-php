<?php

declare(strict_types=1);

namespace SentDm\Organizations\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CustomerUserShape from \SentDm\Organizations\Users\CustomerUser
 *
 * @phpstan-type UserListResponseShape = array{
 *   page?: int|null,
 *   pageSize?: int|null,
 *   totalCount?: int|null,
 *   users?: list<CustomerUser|CustomerUserShape>|null,
 * }
 */
final class UserListResponse implements BaseModel
{
    /** @use SdkModel<UserListResponseShape> */
    use SdkModel;

    #[Optional]
    public ?int $page;

    #[Optional]
    public ?int $pageSize;

    #[Optional]
    public ?int $totalCount;

    /** @var list<CustomerUser>|null $users */
    #[Optional(list: CustomerUser::class)]
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
     * @param list<CustomerUser|CustomerUserShape>|null $users
     */
    public static function with(
        ?int $page = null,
        ?int $pageSize = null,
        ?int $totalCount = null,
        ?array $users = null,
    ): self {
        $self = new self;

        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $totalCount && $self['totalCount'] = $totalCount;
        null !== $users && $self['users'] = $users;

        return $self;
    }

    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    public function withTotalCount(int $totalCount): self
    {
        $self = clone $this;
        $self['totalCount'] = $totalCount;

        return $self;
    }

    /**
     * @param list<CustomerUser|CustomerUserShape> $users
     */
    public function withUsers(array $users): self
    {
        $self = clone $this;
        $self['users'] = $users;

        return $self;
    }
}
