<?php

declare(strict_types=1);

namespace SentDm\Organizations\Users;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Removes a user from an organization or sender profile. Requires admin permissions. This action permanently deletes the user association.
 *
 * @see SentDm\Services\Organizations\UsersService::delete()
 *
 * @phpstan-type UserDeleteParamsShape = array{customerID: string}
 */
final class UserDeleteParams implements BaseModel
{
    /** @use SdkModel<UserDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $customerID;

    /**
     * `new UserDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserDeleteParams::with(customerID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserDeleteParams)->withCustomerID(...)
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
    public static function with(string $customerID): self
    {
        $self = new self;

        $self['customerID'] = $customerID;

        return $self;
    }

    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }
}
