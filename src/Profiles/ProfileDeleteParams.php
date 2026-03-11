<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileDeleteParams\Body;

/**
 * Soft deletes a sender profile. The profile will be marked as deleted but data is retained. Requires admin role in the organization.
 *
 * @see SentDm\Services\ProfilesService::delete()
 *
 * @phpstan-import-type BodyShape from \SentDm\Profiles\ProfileDeleteParams\Body
 *
 * @phpstan-type ProfileDeleteParamsShape = array{
 *   body: Body|BodyShape, xProfileID?: string|null
 * }
 */
final class ProfileDeleteParams implements BaseModel
{
    /** @use SdkModel<ProfileDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Request to delete a profile.
     */
    #[Required]
    public Body $body;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new ProfileDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProfileDeleteParams::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProfileDeleteParams)->withBody(...)
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
     * Request to delete a profile.
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
