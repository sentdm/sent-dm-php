<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * **Deprecated.** This endpoint is replaced by `/v3/sender-profiles` and will be removed in a future release. It still behaves exactly as before, so nothing needs to change today — but new integrations should use `/v3/sender-profiles`, which models a profile's markets, compliance, brand, campaigns and billing explicitly.
 *
 * Retrieves all campaigns linked to the profile's brand, including use cases and sample messages. Returns inherited campaigns if inherit_tcr_campaign=true.
 *
 * @deprecated
 * @see SentDm\Services\Profiles\CampaignsService::list()
 *
 * @phpstan-type CampaignListParamsShape = array{xProfileID?: string|null}
 */
final class CampaignListParams implements BaseModel
{
    /** @use SdkModel<CampaignListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $xProfileID = null): self
    {
        $self = new self;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
