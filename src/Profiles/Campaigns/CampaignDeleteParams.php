<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Deletes a campaign by ID from the brand of the specified profile. The profile must belong to the authenticated organization.
 *
 * @see SentDm\Services\Profiles\CampaignsService::delete()
 *
 * @phpstan-type CampaignDeleteParamsShape = array{
 *   profileID: string, sandbox?: bool|null, xProfileID?: string|null
 * }
 */
final class CampaignDeleteParams implements BaseModel
{
    /** @use SdkModel<CampaignDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $profileID;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new CampaignDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CampaignDeleteParams::with(profileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CampaignDeleteParams)->withProfileID(...)
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
    public static function with(
        string $profileID,
        ?bool $sandbox = null,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        $self['profileID'] = $profileID;

        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withProfileID(string $profileID): self
    {
        $self = clone $this;
        $self['profileID'] = $profileID;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
