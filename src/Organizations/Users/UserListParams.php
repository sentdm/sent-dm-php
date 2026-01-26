<?php

declare(strict_types=1);

namespace SentDm\Organizations\Users;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves all users associated with an organization or sender profile. Requires appropriate permissions. Supports pagination.
 *
 * @see SentDm\Services\Organizations\UsersService::list()
 *
 * @phpstan-type UserListParamsShape = array{page: int, pageSize: int}
 */
final class UserListParams implements BaseModel
{
    /** @use SdkModel<UserListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public int $page;

    #[Required]
    public int $pageSize;

    /**
     * `new UserListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserListParams::with(page: ..., pageSize: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserListParams)->withPage(...)->withPageSize(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(int $page, int $pageSize): self
    {
        $self = new self;

        $self['page'] = $page;
        $self['pageSize'] = $pageSize;

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
}
