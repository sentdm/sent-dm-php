<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new campaign scoped under the brand of the specified profile. Each campaign must include at least one use case with sample messages.
 *
 * @see SentDm\Services\Profiles\CampaignsService::create()
 *
 * @phpstan-import-type CampaignDataShape from \SentDm\Profiles\Campaigns\CampaignData
 *
 * @phpstan-type CampaignCreateParamsShape = array{
 *   campaign: CampaignData|CampaignDataShape,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
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
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

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
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['campaign'] = $campaign;

        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
