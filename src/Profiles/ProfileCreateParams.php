<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Brands\BrandData;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileCreateParams\BillingContact;
use SentDm\Profiles\ProfileCreateParams\PaymentDetails;
use SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount;

/**
 * Creates a new sender profile within an organization. Profiles represent different brands, departments, or use cases, each with their own messaging configuration and settings. Requires admin role in the organization.
 *
 * ## WhatsApp Business Account
 *
 * Every profile must be linked to a WhatsApp Business Account. There are two ways to do this:
 *
 * **1. Inherit from organization (default)** — Omit the `whatsapp_business_account` field. The profile will share the organization's WhatsApp Business Account, which must have been set up via WhatsApp Embedded Signup. This is the recommended path for most use cases.
 *
 * **2. Direct credentials** — Provide a `whatsapp_business_account` object with `waba_id`, `phone_number_id`, and `access_token`. Use this when the profile needs its own independent WhatsApp Business Account. Obtain these from Meta Business Manager by creating a System User with `whatsapp_business_messaging` and `whatsapp_business_management` permissions.
 *
 * If the `whatsapp_business_account` field is omitted and the organization has no WhatsApp Business Account configured, the request will be rejected with HTTP 422.
 *
 * ## Brand
 *
 * Include the optional `brand` field to create the brand for this profile at the same time. Cannot be used when `inherit_tcr_brand` is `true`.
 *
 * ## Payment Details
 *
 * When `billing_model` is `"profile"` or `"profile_and_organization"` you may include a `payment_details` object containing the card number, expiry (MM/YY), CVC, and billing ZIP code. Payment details are **never stored** on our servers and are forwarded directly to the payment processor. Providing `payment_details` when `billing_model` is `"organization"` is not allowed.
 *
 * @see SentDm\Services\ProfilesService::create()
 *
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileCreateParams\BillingContact
 * @phpstan-import-type BrandDataShape from \SentDm\Brands\BrandData
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileCreateParams\PaymentDetails
 * @phpstan-import-type WhatsappBusinessAccountShape from \SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount
 *
 * @phpstan-type ProfileCreateParamsShape = array{
 *   allowContactSharing?: bool|null,
 *   allowTemplateSharing?: bool|null,
 *   billingContact?: null|BillingContact|BillingContactShape,
 *   billingModel?: string|null,
 *   brand?: null|BrandData|BrandDataShape,
 *   description?: string|null,
 *   icon?: string|null,
 *   inheritContacts?: bool|null,
 *   inheritTcrBrand?: bool|null,
 *   inheritTcrCampaign?: bool|null,
 *   inheritTemplates?: bool|null,
 *   name?: string|null,
 *   paymentDetails?: null|PaymentDetails|PaymentDetailsShape,
 *   sandbox?: bool|null,
 *   shortName?: string|null,
 *   whatsappBusinessAccount?: null|WhatsappBusinessAccount|WhatsappBusinessAccountShape,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
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
     * Billing contact for this profile. Required when billing_model is "profile" or "profile_and_organization".
     * Identifies who receives invoices and who is responsible for payment.
     */
    #[Optional('billing_contact', nullable: true)]
    public ?BillingContact $billingContact;

    /**
     * Billing model: profile, organization, or profile_and_organization (default: profile).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     */
    #[Optional('billing_model', nullable: true)]
    public ?string $billingModel;

    /**
     * Brand and KYC information for this profile (optional).
     * When provided, creates the brand associated with this profile.
     * Cannot be set when inherit_tcr_brand is true.
     */
    #[Optional(nullable: true)]
    public ?BrandData $brand;

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
     * Profile short name/abbreviation (optional). Must be 3–11 characters, contain only letters, numbers,
     * and spaces, and include at least one letter. Example: "SALES", "Mkt 2", "Support1".
     */
    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    /**
     * Direct WhatsApp Business Account credentials for this profile.
     * When provided, the profile uses its own WhatsApp Business Account instead of inheriting from the organization.
     * When omitted, the profile inherits the organization's WhatsApp Business Account (requires the organization
     * to have completed WhatsApp Embedded Signup).
     */
    #[Optional('whatsapp_business_account', nullable: true)]
    public ?WhatsappBusinessAccount $whatsappBusinessAccount;

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
     * @param BillingContact|BillingContactShape|null $billingContact
     * @param BrandData|BrandDataShape|null $brand
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails
     * @param WhatsappBusinessAccount|WhatsappBusinessAccountShape|null $whatsappBusinessAccount
     */
    public static function with(
        ?bool $allowContactSharing = null,
        ?bool $allowTemplateSharing = null,
        BillingContact|array|null $billingContact = null,
        ?string $billingModel = null,
        BrandData|array|null $brand = null,
        ?string $description = null,
        ?string $icon = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $name = null,
        PaymentDetails|array|null $paymentDetails = null,
        ?bool $sandbox = null,
        ?string $shortName = null,
        WhatsappBusinessAccount|array|null $whatsappBusinessAccount = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $allowContactSharing && $self['allowContactSharing'] = $allowContactSharing;
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
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $whatsappBusinessAccount && $self['whatsappBusinessAccount'] = $whatsappBusinessAccount;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
     * Billing contact for this profile. Required when billing_model is "profile" or "profile_and_organization".
     * Identifies who receives invoices and who is responsible for payment.
     *
     * @param BillingContact|BillingContactShape|null $billingContact
     */
    public function withBillingContact(
        BillingContact|array|null $billingContact
    ): self {
        $self = clone $this;
        $self['billingContact'] = $billingContact;

        return $self;
    }

    /**
     * Billing model: profile, organization, or profile_and_organization (default: profile).
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
     * When provided, creates the brand associated with this profile.
     * Cannot be set when inherit_tcr_brand is true.
     *
     * @param BrandData|BrandDataShape|null $brand
     */
    public function withBrand(BrandData|array|null $brand): self
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
     * Direct WhatsApp Business Account credentials for this profile.
     * When provided, the profile uses its own WhatsApp Business Account instead of inheriting from the organization.
     * When omitted, the profile inherits the organization's WhatsApp Business Account (requires the organization
     * to have completed WhatsApp Embedded Signup).
     *
     * @param WhatsappBusinessAccount|WhatsappBusinessAccountShape|null $whatsappBusinessAccount
     */
    public function withWhatsappBusinessAccount(
        WhatsappBusinessAccount|array|null $whatsappBusinessAccount
    ): self {
        $self = clone $this;
        $self['whatsappBusinessAccount'] = $whatsappBusinessAccount;

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
