<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Updates a profile's configuration and settings. Requires admin role in the organization. Only provided fields will be updated (partial update).
 *
 * @see SentDm\Services\ProfilesService::update()
 *
 * @phpstan-type ProfileUpdateParamsShape = array{
 *   allowContactSharing?: bool|null,
 *   allowNumberChangeDuringOnboarding?: bool|null,
 *   allowTemplateSharing?: bool|null,
 *   billingModel?: string|null,
 *   description?: string|null,
 *   icon?: string|null,
 *   inheritContacts?: bool|null,
 *   inheritTcrBrand?: bool|null,
 *   inheritTcrCampaign?: bool|null,
 *   inheritTemplates?: bool|null,
 *   name?: string|null,
 *   profileID?: string|null,
 *   sendingPhoneNumber?: string|null,
 *   sendingPhoneNumberProfileID?: string|null,
 *   sendingWhatsappNumberProfileID?: string|null,
 *   shortName?: string|null,
 *   testMode?: bool|null,
 *   whatsappPhoneNumber?: string|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class ProfileUpdateParams implements BaseModel
{
    /** @use SdkModel<ProfileUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Whether contacts are shared across profiles (optional).
     */
    #[Optional('allow_contact_sharing', nullable: true)]
    public ?bool $allowContactSharing;

    /**
     * Whether number changes are allowed during onboarding (optional).
     */
    #[Optional('allow_number_change_during_onboarding', nullable: true)]
    public ?bool $allowNumberChangeDuringOnboarding;

    /**
     * Whether templates are shared across profiles (optional).
     */
    #[Optional('allow_template_sharing', nullable: true)]
    public ?bool $allowTemplateSharing;

    /**
     * Billing model: profile, organization, or profile_and_organization (optional).
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
     * Whether this profile inherits contacts from organization (optional).
     */
    #[Optional('inherit_contacts', nullable: true)]
    public ?bool $inheritContacts;

    /**
     * Whether this profile inherits TCR brand from organization (optional).
     */
    #[Optional('inherit_tcr_brand', nullable: true)]
    public ?bool $inheritTcrBrand;

    /**
     * Whether this profile inherits TCR campaign from organization (optional).
     */
    #[Optional('inherit_tcr_campaign', nullable: true)]
    public ?bool $inheritTcrCampaign;

    /**
     * Whether this profile inherits templates from organization (optional).
     */
    #[Optional('inherit_templates', nullable: true)]
    public ?bool $inheritTemplates;

    /**
     * Profile name (optional).
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Profile ID from route parameter.
     */
    #[Optional('profile_id')]
    public ?string $profileID;

    /**
     * Direct phone number for SMS sending (optional).
     */
    #[Optional('sending_phone_number', nullable: true)]
    public ?string $sendingPhoneNumber;

    /**
     * Reference to another profile to use for SMS/Telnyx configuration (optional).
     */
    #[Optional('sending_phone_number_profile_id', nullable: true)]
    public ?string $sendingPhoneNumberProfileID;

    /**
     * Reference to another profile to use for WhatsApp configuration (optional).
     */
    #[Optional('sending_whatsapp_number_profile_id', nullable: true)]
    public ?string $sendingWhatsappNumberProfileID;

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

    /**
     * Direct phone number for WhatsApp sending (optional).
     */
    #[Optional('whatsapp_phone_number', nullable: true)]
    public ?string $whatsappPhoneNumber;

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
        ?bool $allowNumberChangeDuringOnboarding = null,
        ?bool $allowTemplateSharing = null,
        ?string $billingModel = null,
        ?string $description = null,
        ?string $icon = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $name = null,
        ?string $profileID = null,
        ?string $sendingPhoneNumber = null,
        ?string $sendingPhoneNumberProfileID = null,
        ?string $sendingWhatsappNumberProfileID = null,
        ?string $shortName = null,
        ?bool $testMode = null,
        ?string $whatsappPhoneNumber = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $allowContactSharing && $self['allowContactSharing'] = $allowContactSharing;
        null !== $allowNumberChangeDuringOnboarding && $self['allowNumberChangeDuringOnboarding'] = $allowNumberChangeDuringOnboarding;
        null !== $allowTemplateSharing && $self['allowTemplateSharing'] = $allowTemplateSharing;
        null !== $billingModel && $self['billingModel'] = $billingModel;
        null !== $description && $self['description'] = $description;
        null !== $icon && $self['icon'] = $icon;
        null !== $inheritContacts && $self['inheritContacts'] = $inheritContacts;
        null !== $inheritTcrBrand && $self['inheritTcrBrand'] = $inheritTcrBrand;
        null !== $inheritTcrCampaign && $self['inheritTcrCampaign'] = $inheritTcrCampaign;
        null !== $inheritTemplates && $self['inheritTemplates'] = $inheritTemplates;
        null !== $name && $self['name'] = $name;
        null !== $profileID && $self['profileID'] = $profileID;
        null !== $sendingPhoneNumber && $self['sendingPhoneNumber'] = $sendingPhoneNumber;
        null !== $sendingPhoneNumberProfileID && $self['sendingPhoneNumberProfileID'] = $sendingPhoneNumberProfileID;
        null !== $sendingWhatsappNumberProfileID && $self['sendingWhatsappNumberProfileID'] = $sendingWhatsappNumberProfileID;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $whatsappPhoneNumber && $self['whatsappPhoneNumber'] = $whatsappPhoneNumber;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Whether contacts are shared across profiles (optional).
     */
    public function withAllowContactSharing(?bool $allowContactSharing): self
    {
        $self = clone $this;
        $self['allowContactSharing'] = $allowContactSharing;

        return $self;
    }

    /**
     * Whether number changes are allowed during onboarding (optional).
     */
    public function withAllowNumberChangeDuringOnboarding(
        ?bool $allowNumberChangeDuringOnboarding
    ): self {
        $self = clone $this;
        $self['allowNumberChangeDuringOnboarding'] = $allowNumberChangeDuringOnboarding;

        return $self;
    }

    /**
     * Whether templates are shared across profiles (optional).
     */
    public function withAllowTemplateSharing(?bool $allowTemplateSharing): self
    {
        $self = clone $this;
        $self['allowTemplateSharing'] = $allowTemplateSharing;

        return $self;
    }

    /**
     * Billing model: profile, organization, or profile_and_organization (optional).
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
     * Whether this profile inherits contacts from organization (optional).
     */
    public function withInheritContacts(?bool $inheritContacts): self
    {
        $self = clone $this;
        $self['inheritContacts'] = $inheritContacts;

        return $self;
    }

    /**
     * Whether this profile inherits TCR brand from organization (optional).
     */
    public function withInheritTcrBrand(?bool $inheritTcrBrand): self
    {
        $self = clone $this;
        $self['inheritTcrBrand'] = $inheritTcrBrand;

        return $self;
    }

    /**
     * Whether this profile inherits TCR campaign from organization (optional).
     */
    public function withInheritTcrCampaign(?bool $inheritTcrCampaign): self
    {
        $self = clone $this;
        $self['inheritTcrCampaign'] = $inheritTcrCampaign;

        return $self;
    }

    /**
     * Whether this profile inherits templates from organization (optional).
     */
    public function withInheritTemplates(?bool $inheritTemplates): self
    {
        $self = clone $this;
        $self['inheritTemplates'] = $inheritTemplates;

        return $self;
    }

    /**
     * Profile name (optional).
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Profile ID from route parameter.
     */
    public function withProfileID(string $profileID): self
    {
        $self = clone $this;
        $self['profileID'] = $profileID;

        return $self;
    }

    /**
     * Direct phone number for SMS sending (optional).
     */
    public function withSendingPhoneNumber(?string $sendingPhoneNumber): self
    {
        $self = clone $this;
        $self['sendingPhoneNumber'] = $sendingPhoneNumber;

        return $self;
    }

    /**
     * Reference to another profile to use for SMS/Telnyx configuration (optional).
     */
    public function withSendingPhoneNumberProfileID(
        ?string $sendingPhoneNumberProfileID
    ): self {
        $self = clone $this;
        $self['sendingPhoneNumberProfileID'] = $sendingPhoneNumberProfileID;

        return $self;
    }

    /**
     * Reference to another profile to use for WhatsApp configuration (optional).
     */
    public function withSendingWhatsappNumberProfileID(
        ?string $sendingWhatsappNumberProfileID
    ): self {
        $self = clone $this;
        $self['sendingWhatsappNumberProfileID'] = $sendingWhatsappNumberProfileID;

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

    /**
     * Direct phone number for WhatsApp sending (optional).
     */
    public function withWhatsappPhoneNumber(?string $whatsappPhoneNumber): self
    {
        $self = clone $this;
        $self['whatsappPhoneNumber'] = $whatsappPhoneNumber;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
