<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new sender profile within an organization. Profiles represent different brands, departments, or use cases, each with their own messaging configuration and settings. Requires admin role in the organization.
 *
 * @see SentDm\Services\ProfilesService::create()
 *
 * @phpstan-type ProfileCreateParamsShape = array{
 *   allowContactSharing?: bool|null,
 *   allowTemplateSharing?: bool|null,
 *   billingModel?: string|null,
 *   description?: string|null,
 *   icon?: string|null,
 *   inheritContacts?: bool|null,
 *   inheritTcrBrand?: bool|null,
 *   inheritTcrCampaign?: bool|null,
 *   inheritTemplates?: bool|null,
 *   name?: string|null,
 *   shortName?: string|null,
 *   testMode?: bool|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class ProfileCreateParams implements BaseModel
{
    /** @use SdkModel<ProfileCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Whether contacts are shared across profiles (default: false).
     */
    #[Optional('allow_contact_sharing')]
    public ?bool $allowContactSharing;

    /**
     * Whether templates are shared across profiles (default: false).
     */
    #[Optional('allow_template_sharing')]
    public ?bool $allowTemplateSharing;

    /**
     * Billing model: profile, organization, or profile_and_organization (default: profile).
     */
    #[Optional('billing_model', nullable: true)]
    public ?string $billingModel;

    /**
     * Profile description (optional).
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Profile icon URL (optional).
     */
    #[Optional(nullable: true)]
    public ?string $icon;

    /**
     * Whether this profile inherits contacts from organization (default: true).
     */
    #[Optional('inherit_contacts', nullable: true)]
    public ?bool $inheritContacts;

    /**
     * Whether this profile inherits TCR brand from organization (default: true).
     */
    #[Optional('inherit_tcr_brand', nullable: true)]
    public ?bool $inheritTcrBrand;

    /**
     * Whether this profile inherits TCR campaign from organization (default: true).
     */
    #[Optional('inherit_tcr_campaign', nullable: true)]
    public ?bool $inheritTcrCampaign;

    /**
     * Whether this profile inherits templates from organization (default: true).
     */
    #[Optional('inherit_templates', nullable: true)]
    public ?bool $inheritTemplates;

    /**
     * Profile name (required).
     */
    #[Optional]
    public ?string $name;

    /**
     * Profile short name/abbreviation (optional).
     */
    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    #[Optional]
    public ?string $idempotencyKey;

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
        ?bool $allowContactSharing = null,
        ?bool $allowTemplateSharing = null,
        ?string $billingModel = null,
        ?string $description = null,
        ?string $icon = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $name = null,
        ?string $shortName = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $allowContactSharing && $self['allowContactSharing'] = $allowContactSharing;
        null !== $allowTemplateSharing && $self['allowTemplateSharing'] = $allowTemplateSharing;
        null !== $billingModel && $self['billingModel'] = $billingModel;
        null !== $description && $self['description'] = $description;
        null !== $icon && $self['icon'] = $icon;
        null !== $inheritContacts && $self['inheritContacts'] = $inheritContacts;
        null !== $inheritTcrBrand && $self['inheritTcrBrand'] = $inheritTcrBrand;
        null !== $inheritTcrCampaign && $self['inheritTcrCampaign'] = $inheritTcrCampaign;
        null !== $inheritTemplates && $self['inheritTemplates'] = $inheritTemplates;
        null !== $name && $self['name'] = $name;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Whether contacts are shared across profiles (default: false).
     */
    public function withAllowContactSharing(bool $allowContactSharing): self
    {
        $self = clone $this;
        $self['allowContactSharing'] = $allowContactSharing;

        return $self;
    }

    /**
     * Whether templates are shared across profiles (default: false).
     */
    public function withAllowTemplateSharing(bool $allowTemplateSharing): self
    {
        $self = clone $this;
        $self['allowTemplateSharing'] = $allowTemplateSharing;

        return $self;
    }

    /**
     * Billing model: profile, organization, or profile_and_organization (default: profile).
     */
    public function withBillingModel(?string $billingModel): self
    {
        $self = clone $this;
        $self['billingModel'] = $billingModel;

        return $self;
    }

    /**
     * Profile description (optional).
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Profile icon URL (optional).
     */
    public function withIcon(?string $icon): self
    {
        $self = clone $this;
        $self['icon'] = $icon;

        return $self;
    }

    /**
     * Whether this profile inherits contacts from organization (default: true).
     */
    public function withInheritContacts(?bool $inheritContacts): self
    {
        $self = clone $this;
        $self['inheritContacts'] = $inheritContacts;

        return $self;
    }

    /**
     * Whether this profile inherits TCR brand from organization (default: true).
     */
    public function withInheritTcrBrand(?bool $inheritTcrBrand): self
    {
        $self = clone $this;
        $self['inheritTcrBrand'] = $inheritTcrBrand;

        return $self;
    }

    /**
     * Whether this profile inherits TCR campaign from organization (default: true).
     */
    public function withInheritTcrCampaign(?bool $inheritTcrCampaign): self
    {
        $self = clone $this;
        $self['inheritTcrCampaign'] = $inheritTcrCampaign;

        return $self;
    }

    /**
     * Whether this profile inherits templates from organization (default: true).
     */
    public function withInheritTemplates(?bool $inheritTemplates): self
    {
        $self = clone $this;
        $self['inheritTemplates'] = $inheritTemplates;

        return $self;
    }

    /**
     * Profile name (required).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Profile short name/abbreviation (optional).
     */
    public function withShortName(?string $shortName): self
    {
        $self = clone $this;
        $self['shortName'] = $shortName;

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
