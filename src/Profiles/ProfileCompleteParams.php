<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Final step in the profile compliance workflow. Validates all prerequisites (KYC, brand, campaigns, required documents), connects the profile to the SMS and WhatsApp channels, and sets its status based on configuration. Prerequisites are always validated first: if any fail the call returns 400. If they pass and the profile is already completed, the call returns 200 and does nothing. Otherwise it returns 202 and calls the provided webhook URL when background processing finishes.
 *
 * Prerequisites:
 * - Profile must have a name, short name, and description (short name max 50 characters, description max 5000)
 * - webHookUrl must be supplied on the request
 * - A KYC form submission is required
 * - A brand is required, either on the profile or inherited from the parent organization
 * - TCR applications must have at least one campaign, own or inherited
 * - Destination countries marked as main must have their required compliance documents uploaded
 *
 * Resulting status:
 * - If either the SMS or WhatsApp channel is unconfigured, the profile is SUBMITTED
 * - For a TCR application that inherits both its brand and its campaigns, the profile is COMPLETED
 * - For a TCR application that owns either its brand or its campaigns, the profile is COMPLETED once both have been submitted to TCR, and SUBMITTED until then
 * - For a non-TCR application, the profile is SUBMITTED when a main destination country is set, and COMPLETED otherwise
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
