<?php

declare(strict_types=1);

namespace SentDm\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Removes a user's access to an organization or profile. Requires admin role. You cannot remove yourself or remove the last admin.
 *
 * @see SentDm\Services\UsersService::remove()
 *
 * @phpstan-type UserRemoveParamsShape = array{
 *   testMode?: bool|null, userID?: string|null
 * }
 */
final class UserRemoveParams implements BaseModel
{
    /** @use SdkModel<UserRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    /**
     * User ID from route parameter.
     */
    #[Optional('user_id')]
    public ?string $userID;

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
        ?bool $testMode = null,
        ?string $userID = null
    ): self {
        $self = new self;

        null !== $testMode && $self['testMode'] = $testMode;
        null !== $userID && $self['userID'] = $userID;

        return $self;
    }

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withTestMode(bool $testMode): self
    {
        $self = clone $this;
        $self['testMode'] = $testMode;

        return $self;
    }

    /**
     * User ID from route parameter.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
