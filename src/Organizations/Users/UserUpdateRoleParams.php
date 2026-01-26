<?php

declare(strict_types=1);

namespace SentDm\Organizations\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Updates a user's role within an organization or sender profile. Requires admin permissions. Valid roles are: admin, billing, developer.
 *
 * @see SentDm\Services\Organizations\UsersService::updateRole()
 *
 * @phpstan-type UserUpdateRoleParamsShape = array{
 *   customerID: string, role?: string|null
 * }
 */
final class UserUpdateRoleParams implements BaseModel
{
    /** @use SdkModel<UserUpdateRoleParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $customerID;

    #[Optional]
    public ?string $role;

    /**
     * `new UserUpdateRoleParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserUpdateRoleParams::with(customerID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserUpdateRoleParams)->withCustomerID(...)
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
    public static function with(string $customerID, ?string $role = null): self
    {
        $self = new self;

        $self['customerID'] = $customerID;

        null !== $role && $self['role'] = $role;

        return $self;
    }

    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
