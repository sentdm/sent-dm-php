<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileDetail;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Profile configuration settings.
 *
 * @phpstan-type SettingsShape = array{
 *   allowContactSharing?: bool|null,
 *   allowNumberChangeDuringOnboarding?: bool|null,
 *   allowTemplateSharing?: bool|null,
 *   billingModel?: string|null,
 *   inheritContacts?: bool|null,
 *   inheritTcrBrand?: bool|null,
 *   inheritTcrCampaign?: bool|null,
 *   inheritTemplates?: bool|null,
 *   sendingPhoneNumber?: string|null,
 *   sendingPhoneNumberProfileID?: string|null,
 *   sendingWhatsappNumberProfileID?: string|null,
 *   whatsappPhoneNumber?: string|null,
 * }
 */
final class Settings implements BaseModel
{
    /** @use SdkModel<SettingsShape> */
    use SdkModel;

    /**
     * Whether contacts are shared across profiles in the organization.
     */
    #[Optional('allow_contact_sharing')]
    public ?bool $allowContactSharing;

    /**
     * Whether number changes are allowed during onboarding.
     */
    #[Optional('allow_number_change_during_onboarding', nullable: true)]
    public ?bool $allowNumberChangeDuringOnboarding;

    /**
     * Whether templates are shared across profiles in the organization.
     */
    #[Optional('allow_template_sharing')]
    public ?bool $allowTemplateSharing;

    /**
     * Billing model: profile, organization, or profile_and_organization.
     */
    #[Optional('billing_model')]
    public ?string $billingModel;

    /**
     * Whether this profile inherits contacts from the organization.
     */
    #[Optional('inherit_contacts')]
    public ?bool $inheritContacts;

    /**
     * Whether this profile inherits TCR brand from the organization.
     */
    #[Optional('inherit_tcr_brand')]
    public ?bool $inheritTcrBrand;

    /**
     * Whether this profile inherits TCR campaign from the organization.
     */
    #[Optional('inherit_tcr_campaign')]
    public ?bool $inheritTcrCampaign;

    /**
     * Whether this profile inherits templates from the organization.
     */
    #[Optional('inherit_templates')]
    public ?bool $inheritTemplates;

    /**
     * Direct SMS phone number.
     */
    #[Optional('sending_phone_number', nullable: true)]
    public ?string $sendingPhoneNumber;

    /**
     * Reference to another profile for SMS/Telnyx configuration.
     */
    #[Optional('sending_phone_number_profile_id', nullable: true)]
    public ?string $sendingPhoneNumberProfileID;

    /**
     * Reference to another profile for WhatsApp configuration.
     */
    #[Optional('sending_whatsapp_number_profile_id', nullable: true)]
    public ?string $sendingWhatsappNumberProfileID;

    /**
     * Direct WhatsApp phone number.
     */
    #[Optional('whatsapp_phone_number', nullable: true)]
    public ?string $whatsappPhoneNumber;

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
        ?bool $allowNumberChangeDuringOnboarding = null,
        ?bool $allowTemplateSharing = null,
        ?string $billingModel = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $sendingPhoneNumber = null,
        ?string $sendingPhoneNumberProfileID = null,
        ?string $sendingWhatsappNumberProfileID = null,
        ?string $whatsappPhoneNumber = null,
    ): self {
        $self = new self;

        null !== $allowContactSharing && $self['allowContactSharing'] = $allowContactSharing;
        null !== $allowNumberChangeDuringOnboarding && $self['allowNumberChangeDuringOnboarding'] = $allowNumberChangeDuringOnboarding;
        null !== $allowTemplateSharing && $self['allowTemplateSharing'] = $allowTemplateSharing;
        null !== $billingModel && $self['billingModel'] = $billingModel;
        null !== $inheritContacts && $self['inheritContacts'] = $inheritContacts;
        null !== $inheritTcrBrand && $self['inheritTcrBrand'] = $inheritTcrBrand;
        null !== $inheritTcrCampaign && $self['inheritTcrCampaign'] = $inheritTcrCampaign;
        null !== $inheritTemplates && $self['inheritTemplates'] = $inheritTemplates;
        null !== $sendingPhoneNumber && $self['sendingPhoneNumber'] = $sendingPhoneNumber;
        null !== $sendingPhoneNumberProfileID && $self['sendingPhoneNumberProfileID'] = $sendingPhoneNumberProfileID;
        null !== $sendingWhatsappNumberProfileID && $self['sendingWhatsappNumberProfileID'] = $sendingWhatsappNumberProfileID;
        null !== $whatsappPhoneNumber && $self['whatsappPhoneNumber'] = $whatsappPhoneNumber;

        return $self;
    }

    /**
     * Whether contacts are shared across profiles in the organization.
     */
    public function withAllowContactSharing(bool $allowContactSharing): self
    {
        $self = clone $this;
        $self['allowContactSharing'] = $allowContactSharing;

        return $self;
    }

    /**
     * Whether number changes are allowed during onboarding.
     */
    public function withAllowNumberChangeDuringOnboarding(
        ?bool $allowNumberChangeDuringOnboarding
    ): self {
        $self = clone $this;
        $self['allowNumberChangeDuringOnboarding'] = $allowNumberChangeDuringOnboarding;

        return $self;
    }

    /**
     * Whether templates are shared across profiles in the organization.
     */
    public function withAllowTemplateSharing(bool $allowTemplateSharing): self
    {
        $self = clone $this;
        $self['allowTemplateSharing'] = $allowTemplateSharing;

        return $self;
    }

    /**
     * Billing model: profile, organization, or profile_and_organization.
     */
    public function withBillingModel(string $billingModel): self
    {
        $self = clone $this;
        $self['billingModel'] = $billingModel;

        return $self;
    }

    /**
     * Whether this profile inherits contacts from the organization.
     */
    public function withInheritContacts(bool $inheritContacts): self
    {
        $self = clone $this;
        $self['inheritContacts'] = $inheritContacts;

        return $self;
    }

    /**
     * Whether this profile inherits TCR brand from the organization.
     */
    public function withInheritTcrBrand(bool $inheritTcrBrand): self
    {
        $self = clone $this;
        $self['inheritTcrBrand'] = $inheritTcrBrand;

        return $self;
    }

    /**
     * Whether this profile inherits TCR campaign from the organization.
     */
    public function withInheritTcrCampaign(bool $inheritTcrCampaign): self
    {
        $self = clone $this;
        $self['inheritTcrCampaign'] = $inheritTcrCampaign;

        return $self;
    }

    /**
     * Whether this profile inherits templates from the organization.
     */
    public function withInheritTemplates(bool $inheritTemplates): self
    {
        $self = clone $this;
        $self['inheritTemplates'] = $inheritTemplates;

        return $self;
    }

    /**
     * Direct SMS phone number.
     */
    public function withSendingPhoneNumber(?string $sendingPhoneNumber): self
    {
        $self = clone $this;
        $self['sendingPhoneNumber'] = $sendingPhoneNumber;

        return $self;
    }

    /**
     * Reference to another profile for SMS/Telnyx configuration.
     */
    public function withSendingPhoneNumberProfileID(
        ?string $sendingPhoneNumberProfileID
    ): self {
        $self = clone $this;
        $self['sendingPhoneNumberProfileID'] = $sendingPhoneNumberProfileID;

        return $self;
    }

    /**
     * Reference to another profile for WhatsApp configuration.
     */
    public function withSendingWhatsappNumberProfileID(
        ?string $sendingWhatsappNumberProfileID
    ): self {
        $self = clone $this;
        $self['sendingWhatsappNumberProfileID'] = $sendingWhatsappNumberProfileID;

        return $self;
    }

    /**
     * Direct WhatsApp phone number.
     */
    public function withWhatsappPhoneNumber(?string $whatsappPhoneNumber): self
    {
        $self = clone $this;
        $self['whatsappPhoneNumber'] = $whatsappPhoneNumber;

        return $self;
    }
}
