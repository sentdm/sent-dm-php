<?php

declare(strict_types=1);

namespace SentDm\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Users\UserRemoveParams\Body;

/**
 * Removes a user's access to an organization or profile. Requires admin role. You cannot remove yourself or remove the last admin.
 *
 * @see SentDm\Services\UsersService::remove()
 *
 * @phpstan-import-type BodyShape from \SentDm\Users\UserRemoveParams\Body
 *
 * @phpstan-type UserRemoveParamsShape = array{
 *   body: Body|BodyShape, xProfileID?: string|null
 * }
 */
final class UserRemoveParams implements BaseModel
{
    /** @use SdkModel<UserRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Request to remove a user from an organization.
     */
    #[Required]
    public Body $body;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new UserRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRemoveParams::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRemoveParams)->withBody(...)
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
     *
     * @param Body|BodyShape $body
     */
    public static function with(
        Body|array $body,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        $self['body'] = $body;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Request to remove a user from an organization.
     *
     * @param Body|BodyShape $body
     */
    public function withBody(Body|array $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
