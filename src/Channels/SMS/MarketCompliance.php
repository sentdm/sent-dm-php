<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Channels\SMS\MarketCompliance\Brand;
use SentDm\Channels\SMS\MarketCompliance\Campaign;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
 *
 * @phpstan-import-type BrandShape from \SentDm\Channels\SMS\MarketCompliance\Brand
 * @phpstan-import-type CampaignShape from \SentDm\Channels\SMS\MarketCompliance\Campaign
 *
 * @phpstan-type MarketComplianceShape = array{
 *   brand?: null|Brand|BrandShape, campaign?: null|Campaign|CampaignShape
 * }
 */
final class MarketCompliance implements BaseModel
{
    /** @use SdkModel<MarketComplianceShape> */
    use SdkModel;

    /**
     * Business identity. The identity the registration is filed against. Omit to have none; { "inherit": true } to register under your organization's.
     */
    #[Optional]
    public ?Brand $brand;

    /**
     * Messaging campaign. What the programme sends and how recipients consented. Omit to run on your organization's; supplying it takes one of your own. { "inherit": true } says so outright. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional]
    public ?Campaign $campaign;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Brand|BrandShape|null $brand
     * @param Campaign|CampaignShape|null $campaign
     */
    public static function with(
        Brand|array|null $brand = null,
        Campaign|array|null $campaign = null
    ): self {
        $self = new self;

        null !== $brand && $self['brand'] = $brand;
        null !== $campaign && $self['campaign'] = $campaign;

        return $self;
    }

    /**
     * Business identity. The identity the registration is filed against. Omit to have none; { "inherit": true } to register under your organization's.
     *
     * @param Brand|BrandShape $brand
     */
    public function withBrand(Brand|array $brand): self
    {
        $self = clone $this;
        $self['brand'] = $brand;

        return $self;
    }

    /**
     * Messaging campaign. What the programme sends and how recipients consented. Omit to run on your organization's; supplying it takes one of your own. { "inherit": true } says so outright. Required when `compliance.campaign.inherit != true`.
     *
     * @param Campaign|CampaignShape $campaign
     */
    public function withCampaign(Campaign|array $campaign): self
    {
        $self = clone $this;
        $self['campaign'] = $campaign;

        return $self;
    }
}
