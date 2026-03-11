<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\Campaigns\CampaignDeleteParams\Body;

/**
 * Deletes a campaign by ID from the brand of the specified profile. The profile must belong to the authenticated organization.
 *
 * @see SentDm\Services\Profiles\CampaignsService::delete()
 *
 * @phpstan-import-type BodyShape from \SentDm\Profiles\Campaigns\CampaignDeleteParams\Body
 *
 * @phpstan-type CampaignDeleteParamsShape = array{
 *   profileID: string, body: Body|BodyShape, xProfileID?: string|null
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
     * Request to delete a campaign from a brand.
     */
    #[Required]
    public Body $body;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new CampaignDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CampaignDeleteParams::with(profileID: ..., body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CampaignDeleteParams)->withProfileID(...)->withBody(...)
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
        string $profileID,
        Body|array $body,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        $self['profileID'] = $profileID;
        $self['body'] = $body;

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
     * Request to delete a campaign from a brand.
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
