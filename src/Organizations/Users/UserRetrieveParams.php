<?php

declare(strict_types=1);

namespace SentDm\Organizations\Users;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a specific user by their ID. Requires appropriate permissions. The customerId can be either an organization ID or a profile ID.
 *
 * @see SentDm\Services\Organizations\UsersService::retrieve()
 *
 * @phpstan-type UserRetrieveParamsShape = array{customerID: string}
 */
final class UserRetrieveParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $customerID;

    /**
     * `new UserRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRetrieveParams::with(customerID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRetrieveParams)->withCustomerID(...)
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
