<?php

declare(strict_types=1);

namespace SentDm\Users\UserListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Users\UserResponse;
use SentDm\Webhooks\PaginationMeta;

/**
 * The users in the organization.
 *
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 * @phpstan-import-type UserResponseShape from \SentDm\Users\UserResponse
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 *   users?: list<UserResponse|UserResponseShape>|null,
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
    public ?PaginationMeta $pagination;

    /**
     * The users on this page.
     *
     * @var list<UserResponse>|null $users
     */
    #[Optional(list: UserResponse::class)]
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
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     * @param list<UserResponse|UserResponseShape>|null $users
     */
    public static function with(
        PaginationMeta|array|null $pagination = null,
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
     * @param PaginationMeta|PaginationMetaShape $pagination
     */
    public function withPagination(PaginationMeta|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The users on this page.
     *
     * @param list<UserResponse|UserResponseShape> $users
     */
    public function withUsers(array $users): self
    {
        $self = clone $this;
        $self['users'] = $users;

        return $self;
    }
}
