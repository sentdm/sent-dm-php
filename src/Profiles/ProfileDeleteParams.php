<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Soft deletes a sender profile. The profile will be marked as deleted but data is retained. Requires admin role in the organization.
 *
 * @see SentDm\Services\ProfilesService::delete()
 *
 * @phpstan-type ProfileDeleteParamsShape = array{
 *   profileID?: string|null, testMode?: bool|null
 * }
 */
final class ProfileDeleteParams implements BaseModel
{
    /** @use SdkModel<ProfileDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Profile ID from route parameter.
     */
    #[Optional('profile_id')]
    public ?string $profileID;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

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
        ?string $profileID = null,
        ?bool $testMode = null
    ): self {
        $self = new self;

        null !== $profileID && $self['profileID'] = $profileID;
        null !== $testMode && $self['testMode'] = $testMode;

        return $self;
    }

    /**
     * Profile ID from route parameter.
     */
    public function withProfileID(string $profileID): self
    {
        $self = clone $this;
        $self['profileID'] = $profileID;

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
}
