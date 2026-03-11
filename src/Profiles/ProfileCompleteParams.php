<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Final step in profile compliance workflow. Validates all prerequisites (general data, brand, campaigns), connects profile to Telnyx/WhatsApp, and sets status based on configuration. The process runs in the background and calls the provided webhook URL when finished.
 *
 *                 Prerequisites:
 *                 - Profile must be completed
 *                 - If inheritTcrBrand=false: Profile must have existing brand
 *                 - If inheritTcrBrand=true: Parent must have existing brand
 *                 - If TCR application: Must have at least one campaign (own or inherited)
 *                 - If inheritTcrCampaign=false: Profile should have campaigns
 *                 - If inheritTcrCampaign=true: Parent must have campaigns
 *
 *                 Status Logic:
 *                 - If both SMS and WhatsApp channels are missing → SUBMITTED
 *                 - If TCR application and not inheriting brand/campaigns → SUBMITTED
 *                 - If non-TCR with destination country (IsMain=true) → SUBMITTED
 *                 - Otherwise → COMPLETED
 *
 * @see SentDm\Services\ProfilesService::complete()
 *
 * @phpstan-type ProfileCompleteParamsShape = array{
 *   webHookURL: string,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class ProfileCompleteParams implements BaseModel
{
    /** @use SdkModel<ProfileCompleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Webhook URL to call when profile completion finishes (success or failure).
     */
    #[Required('webHookUrl')]
    public string $webHookURL;

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
     * `new ProfileCompleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProfileCompleteParams::with(webHookURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProfileCompleteParams)->withWebHookURL(...)
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
        string $webHookURL,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['webHookURL'] = $webHookURL;

        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Webhook URL to call when profile completion finishes (success or failure).
     */
    public function withWebHookURL(string $webHookURL): self
    {
        $self = clone $this;
        $self['webHookURL'] = $webHookURL;

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
