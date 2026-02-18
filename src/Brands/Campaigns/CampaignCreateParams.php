<?php

declare(strict_types=1);

namespace SentDm\Brands\Campaigns;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new campaign scoped under a specific brand. The campaign is linked to the specified brand. Each campaign must include at least one use case with sample messages.
 *
 * @see SentDm\Services\Brands\CampaignsService::create()
 *
 * @phpstan-import-type CampaignDataShape from \SentDm\Brands\Campaigns\CampaignData
 *
 * @phpstan-type CampaignCreateParamsShape = array{
 *   campaign: CampaignData|CampaignDataShape,
 *   testMode?: bool|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class CampaignCreateParams implements BaseModel
{
    /** @use SdkModel<CampaignCreateParamsShape> */
    use SdkModel;
    use SdkParams;

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
     * `new CampaignCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CampaignCreateParams::with(campaign: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CampaignCreateParams)->withCampaign(...)
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
        CampaignData|array $campaign,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        $self['campaign'] = $campaign;

        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

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
