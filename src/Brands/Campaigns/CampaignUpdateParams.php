<?php

declare(strict_types=1);

namespace SentDm\Brands\Campaigns;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Updates an existing campaign scoped under a specific brand. Cannot update campaigns that have already been submitted to TCR.
 *
 * @see SentDm\Services\Brands\CampaignsService::update()
 *
 * @phpstan-import-type CampaignDataShape from \SentDm\Brands\Campaigns\CampaignData
 *
 * @phpstan-type CampaignUpdateParamsShape = array{
 *   brandID: string,
 *   campaign: CampaignData|CampaignDataShape,
 *   testMode?: bool|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class CampaignUpdateParams implements BaseModel
{
    /** @use SdkModel<CampaignUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $brandID;

    /**
     * Campaign data.
     */
    #[Required]
    public CampaignData $campaign;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    #[Optional]
    public ?string $idempotencyKey;

    /**
     * `new CampaignUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CampaignUpdateParams::with(brandID: ..., campaign: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CampaignUpdateParams)->withBrandID(...)->withCampaign(...)
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
     * @param CampaignData|CampaignDataShape $campaign
     */
    public static function with(
        string $brandID,
        CampaignData|array $campaign,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        $self['brandID'] = $brandID;
        $self['campaign'] = $campaign;

        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withBrandID(string $brandID): self
    {
        $self = clone $this;
        $self['brandID'] = $brandID;

        return $self;
    }

    /**
     * Campaign data.
     *
     * @param CampaignData|CampaignDataShape $campaign
     */
    public function withCampaign(CampaignData|array $campaign): self
    {
        $self = clone $this;
        $self['campaign'] = $campaign;

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

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
