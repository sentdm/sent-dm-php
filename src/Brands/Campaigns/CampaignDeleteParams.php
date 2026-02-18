<?php

declare(strict_types=1);

namespace SentDm\Brands\Campaigns;

use SentDm\Brands\Campaigns\CampaignDeleteParams\Body;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Deletes a campaign by ID within a specific brand. The brand must belong to the authenticated customer.
 *
 * @see SentDm\Services\Brands\CampaignsService::delete()
 *
 * @phpstan-import-type BodyShape from \SentDm\Brands\Campaigns\CampaignDeleteParams\Body
 *
 * @phpstan-type CampaignDeleteParamsShape = array{
 *   brandID: string, body: Body|BodyShape
 * }
 */
final class CampaignDeleteParams implements BaseModel
{
    /** @use SdkModel<CampaignDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $brandID;

    /**
     * Request to delete a campaign from a brand.
     */
    #[Required]
    public Body $body;

    /**
     * `new CampaignDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CampaignDeleteParams::with(brandID: ..., body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CampaignDeleteParams)->withBrandID(...)->withBody(...)
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
    public static function with(string $brandID, Body|array $body): self
    {
        $self = new self;

        $self['brandID'] = $brandID;
        $self['body'] = $body;

        return $self;
    }

    public function withBrandID(string $brandID): self
    {
        $self = clone $this;
        $self['brandID'] = $brandID;

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
}
