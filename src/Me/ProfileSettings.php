<?php

declare(strict_types=1);

namespace SentDm\Me;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Profile configuration settings.
 *
 * @phpstan-type ProfileSettingsShape = array{
 *   allowContactSharing?: bool|null,
 *   allowTemplateSharing?: bool|null,
 *   billingModel?: string|null,
 *   inheritContacts?: bool|null,
 *   inheritTcrBrand?: bool|null,
 *   inheritTcrCampaign?: bool|null,
 *   inheritTemplates?: bool|null,
 * }
 */
final class ProfileSettings implements BaseModel
{
    /** @use SdkModel<ProfileSettingsShape> */
    use SdkModel;

    /**
     * Whether contacts are shared across profiles in the organization.
     */
    #[Optional('allow_contact_sharing', nullable: true)]
    public ?bool $allowContactSharing;

    /**
     * Whether templates are shared across profiles in the organization.
     */
    #[Optional('allow_template_sharing', nullable: true)]
    public ?bool $allowTemplateSharing;

    /**
     * Billing model: profile, organization, or profile_and_organization.
     */
    #[Optional('billing_model', nullable: true)]
    public ?string $billingModel;

    /**
     * Whether this profile inherits contacts from the organization.
     */
    #[Optional('inherit_contacts', nullable: true)]
    public ?bool $inheritContacts;

    /**
     * Whether this profile inherits TCR brand from the organization.
     */
    #[Optional('inherit_tcr_brand', nullable: true)]
    public ?bool $inheritTcrBrand;

    /**
     * Whether this profile inherits TCR campaign from the organization.
     */
    #[Optional('inherit_tcr_campaign', nullable: true)]
    public ?bool $inheritTcrCampaign;

    /**
     * Whether this profile inherits templates from the organization.
     */
    #[Optional('inherit_templates', nullable: true)]
    public ?bool $inheritTemplates;

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
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
    ): self {
        $self = new self;

        null !== $allowContactSharing && $self['allowContactSharing'] = $allowContactSharing;
        null !== $allowTemplateSharing && $self['allowTemplateSharing'] = $allowTemplateSharing;
        null !== $billingModel && $self['billingModel'] = $billingModel;
        null !== $inheritContacts && $self['inheritContacts'] = $inheritContacts;
        null !== $inheritTcrBrand && $self['inheritTcrBrand'] = $inheritTcrBrand;
        null !== $inheritTcrCampaign && $self['inheritTcrCampaign'] = $inheritTcrCampaign;
        null !== $inheritTemplates && $self['inheritTemplates'] = $inheritTemplates;

        return $self;
    }

    /**
     * Whether contacts are shared across profiles in the organization.
     */
    public function withAllowContactSharing(?bool $allowContactSharing): self
    {
        $self = clone $this;
        $self['allowContactSharing'] = $allowContactSharing;

        return $self;
    }

    /**
     * Whether templates are shared across profiles in the organization.
     */
    public function withAllowTemplateSharing(?bool $allowTemplateSharing): self
    {
        $self = clone $this;
        $self['allowTemplateSharing'] = $allowTemplateSharing;

        return $self;
    }

    /**
     * Billing model: profile, organization, or profile_and_organization.
     */
    public function withBillingModel(?string $billingModel): self
    {
        $self = clone $this;
        $self['billingModel'] = $billingModel;

        return $self;
    }

    /**
     * Whether this profile inherits contacts from the organization.
     */
    public function withInheritContacts(?bool $inheritContacts): self
    {
        $self = clone $this;
        $self['inheritContacts'] = $inheritContacts;

        return $self;
    }

    /**
     * Whether this profile inherits TCR brand from the organization.
     */
    public function withInheritTcrBrand(?bool $inheritTcrBrand): self
    {
        $self = clone $this;
        $self['inheritTcrBrand'] = $inheritTcrBrand;

        return $self;
    }

    /**
     * Whether this profile inherits TCR campaign from the organization.
     */
    public function withInheritTcrCampaign(?bool $inheritTcrCampaign): self
    {
        $self = clone $this;
        $self['inheritTcrCampaign'] = $inheritTcrCampaign;

        return $self;
    }

    /**
     * Whether this profile inherits templates from the organization.
     */
    public function withInheritTemplates(?bool $inheritTemplates): self
    {
        $self = clone $this;
        $self['inheritTemplates'] = $inheritTemplates;

        return $self;
    }
}
