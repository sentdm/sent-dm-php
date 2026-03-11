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
 * ## Brand Management
 *
 * Include the optional `brand` field to create or update the brand associated with this profile. The brand holds KYC and TCR compliance data (legal business info, contact details, messaging vertical). Once a brand has been submitted to TCR it cannot be modified. Setting `inherit_tcr_brand: true` and providing `brand` in the same request is not allowed.
 *
 * ## Payment Details
 *
 * When `billing_model` is `"profile"` or `"profile_and_organization"` you may include a `payment_details` object containing the card number, expiry (MM/YY), CVC, and billing ZIP code. Payment details are **never stored** on our servers and are forwarded directly to the payment processor. Providing `payment_details` when `billing_model` is `"organization"` is not allowed.
 *
 * @see SentDm\Services\ProfilesService::update()
 *
 * @phpstan-import-type BillingContactInfoShape from \SentDm\Profiles\BillingContactInfo
 * @phpstan-import-type BrandsBrandDataShape from \SentDm\Profiles\BrandsBrandData
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\PaymentDetails
 *
 * @phpstan-type ProfileUpdateParamsShape = array{
 *   allowContactSharing?: bool|null,
 *   allowNumberChangeDuringOnboarding?: bool|null,
 *   allowTemplateSharing?: bool|null,
 *   billingContact?: null|BillingContactInfo|BillingContactInfoShape,
 *   billingModel?: string|null,
 *   brand?: null|BrandsBrandData|BrandsBrandDataShape,
 *   description?: string|null,
 *   icon?: string|null,
 *   inheritContacts?: bool|null,
 *   inheritTcrBrand?: bool|null,
 *   inheritTcrCampaign?: bool|null,
 *   inheritTemplates?: bool|null,
 *   name?: string|null,
 *   paymentDetails?: null|PaymentDetails|PaymentDetailsShape,
 *   sandbox?: bool|null,
 *   sendingPhoneNumber?: string|null,
 *   sendingPhoneNumberProfileID?: string|null,
 *   sendingWhatsappNumberProfileID?: string|null,
 *   shortName?: string|null,
 *   whatsappPhoneNumber?: string|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
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
     * Billing contact for this profile. Required when billing_model is "profile" or "profile_and_organization"
     * and no billing contact has been configured yet. Identifies who receives invoices and who is responsible for payment.
     */
    #[Optional('billing_contact', nullable: true)]
    public ?BillingContactInfo $billingContact;

    /**
     * Billing model: profile, organization, or profile_and_organization (optional).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     */
    #[Optional('billing_model', nullable: true)]
    public ?string $billingModel;

    /**
     * Brand and KYC information for this profile (optional).
     * When provided, creates or updates the brand associated with this profile.
     * Cannot be set when inherit_tcr_brand is true.
     * Once a brand has been submitted to TCR it cannot be modified.
     */
    #[Optional(nullable: true)]
    public ?BrandsBrandData $brand;

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
     * Payment card details for this profile (optional).
     * Accepted when billing_model is "profile" or "profile_and_organization".
     * Not persisted on our servers — forwarded to the payment processor.
     */
    #[Optional('payment_details', nullable: true)]
    public ?PaymentDetails $paymentDetails;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

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
     * Profile short name/abbreviation (optional). Must be 3–11 characters, contain only letters, numbers,
     * and spaces, and include at least one letter. Example: "SALES", "Mkt 2", "Support1".
     */
    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    /**
     * Direct phone number for WhatsApp sending (optional).
     */
    #[Optional('whatsapp_phone_number', nullable: true)]
    public ?string $whatsappPhoneNumber;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BillingContactInfo|BillingContactInfoShape|null $billingContact
     * @param BrandsBrandData|BrandsBrandDataShape|null $brand
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails
     */
    public static function with(
        ?bool $allowContactSharing = null,
        ?bool $allowNumberChangeDuringOnboarding = null,
        ?bool $allowTemplateSharing = null,
        BillingContactInfo|array|null $billingContact = null,
        ?string $billingModel = null,
        BrandsBrandData|array|null $brand = null,
        ?string $description = null,
        ?string $icon = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $name = null,
        PaymentDetails|array|null $paymentDetails = null,
        ?bool $sandbox = null,
        ?string $sendingPhoneNumber = null,
        ?string $sendingPhoneNumberProfileID = null,
        ?string $sendingWhatsappNumberProfileID = null,
        ?string $shortName = null,
        ?string $whatsappPhoneNumber = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $allowContactSharing && $self['allowContactSharing'] = $allowContactSharing;
        null !== $allowNumberChangeDuringOnboarding && $self['allowNumberChangeDuringOnboarding'] = $allowNumberChangeDuringOnboarding;
        null !== $allowTemplateSharing && $self['allowTemplateSharing'] = $allowTemplateSharing;
        null !== $billingContact && $self['billingContact'] = $billingContact;
        null !== $billingModel && $self['billingModel'] = $billingModel;
        null !== $brand && $self['brand'] = $brand;
        null !== $description && $self['description'] = $description;
        null !== $icon && $self['icon'] = $icon;
        null !== $inheritContacts && $self['inheritContacts'] = $inheritContacts;
        null !== $inheritTcrBrand && $self['inheritTcrBrand'] = $inheritTcrBrand;
        null !== $inheritTcrCampaign && $self['inheritTcrCampaign'] = $inheritTcrCampaign;
        null !== $inheritTemplates && $self['inheritTemplates'] = $inheritTemplates;
        null !== $name && $self['name'] = $name;
        null !== $paymentDetails && $self['paymentDetails'] = $paymentDetails;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $sendingPhoneNumber && $self['sendingPhoneNumber'] = $sendingPhoneNumber;
        null !== $sendingPhoneNumberProfileID && $self['sendingPhoneNumberProfileID'] = $sendingPhoneNumberProfileID;
        null !== $sendingWhatsappNumberProfileID && $self['sendingWhatsappNumberProfileID'] = $sendingWhatsappNumberProfileID;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $whatsappPhoneNumber && $self['whatsappPhoneNumber'] = $whatsappPhoneNumber;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
     * Billing contact for this profile. Required when billing_model is "profile" or "profile_and_organization"
     * and no billing contact has been configured yet. Identifies who receives invoices and who is responsible for payment.
     *
     * @param BillingContactInfo|BillingContactInfoShape|null $billingContact
     */
    public function withBillingContact(
        BillingContactInfo|array|null $billingContact
    ): self {
        $self = clone $this;
        $self['billingContact'] = $billingContact;

        return $self;
    }

    /**
     * Billing model: profile, organization, or profile_and_organization (optional).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     */
    public function withBillingModel(?string $billingModel): self
    {
        $self = clone $this;
        $self['billingModel'] = $billingModel;

        return $self;
    }

    /**
     * Brand and KYC information for this profile (optional).
     * When provided, creates or updates the brand associated with this profile.
     * Cannot be set when inherit_tcr_brand is true.
     * Once a brand has been submitted to TCR it cannot be modified.
     *
     * @param BrandsBrandData|BrandsBrandDataShape|null $brand
     */
    public function withBrand(BrandsBrandData|array|null $brand): self
    {
        $self = clone $this;
        $self['brand'] = $brand;

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
     * Payment card details for this profile (optional).
     * Accepted when billing_model is "profile" or "profile_and_organization".
     * Not persisted on our servers — forwarded to the payment processor.
     *
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails
     */
    public function withPaymentDetails(
        PaymentDetails|array|null $paymentDetails
    ): self {
        $self = clone $this;
        $self['paymentDetails'] = $paymentDetails;

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
     * Profile short name/abbreviation (optional). Must be 3–11 characters, contain only letters, numbers,
     * and spaces, and include at least one letter. Example: "SALES", "Mkt 2", "Support1".
     */
    public function withShortName(?string $shortName): self
    {
        $self = clone $this;
        $self['shortName'] = $shortName;

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

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
