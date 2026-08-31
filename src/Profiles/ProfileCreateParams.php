<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileCreateParams\BillingContact;
use SentDm\Profiles\ProfileCreateParams\Brand;
use SentDm\Profiles\ProfileCreateParams\PaymentDetails;
use SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount;

/**
 * **Deprecated.** This endpoint is replaced by `/v3/sender-profiles` and will be removed in a future release. It still behaves exactly as before, so nothing needs to change today — but new integrations should use `/v3/sender-profiles`, which models a profile's markets, compliance, brand, campaigns and billing explicitly.
 *
 * Creates a new sender profile within an organization. Profiles represent different brands, departments, or use cases, each with their own messaging configuration and settings. Requires admin role in the organization.
 *
 * ## WhatsApp Business Account
 *
 * Every profile owns its own WhatsApp Business Account — accounts are never shared between profiles or inherited from the organization. Provide a `whatsapp_business_account` object with `waba_id`, `phone_number_id`, and `access_token`. Obtain these from Meta Business Manager by creating a System User with `whatsapp_business_messaging` and `whatsapp_business_management` permissions.
 *
 * Omit the field and the profile is created without WhatsApp, staying incomplete until it has an account of its own.
 *
 * ## Brand
 *
 * Include the optional `brand` field to create the brand for this profile at the same time. Cannot be used when `inherit_tcr_brand` is `true`.
 *
 * ## Payment Details
 *
 * When `billing_model` is `"profile"` or `"profile_and_organization"` you may include a `payment_details` object containing the card number, expiry (MM/YY), CVC, and billing ZIP code. Payment details are **never stored** on our servers and are forwarded directly to the payment processor. Providing `payment_details` when `billing_model` is `"organization"` is not allowed.
 *
 * @deprecated
 * @see SentDm\Services\ProfilesService::create()
 *
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileCreateParams\BillingContact
 * @phpstan-import-type BrandShape from \SentDm\Profiles\ProfileCreateParams\Brand
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileCreateParams\PaymentDetails
 * @phpstan-import-type WhatsappBusinessAccountShape from \SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount
 *
 * @phpstan-type ProfileCreateParamsShape = array{
 *   allowContactSharing?: bool|null,
 *   allowTemplateSharing?: bool|null,
 *   billingContact?: null|BillingContact|BillingContactShape,
 *   billingModel?: string|null,
 *   brand?: null|Brand|BrandShape,
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
     * @deprecated
     *
     * Deprecated. Accepted and ignored. Contact and template sharing between sender profiles is gone
     * — a profile sees only what it owns, and the organization still sees all of its profiles' contacts and
     * templates through read-time widening. The four columns behind these flags were dropped by
     * M260720120000.
     *
     * Bound rather than dropped so the properties survive on the wire and in a generated client: an
     * SDK that assigns them keeps compiling, which is the compatibility this exists for. Deliberately not
     * refused either — a 400 would break an integration that is otherwise working, and the capability
     * they ask for is gone either way. Same rule as SendingPhoneNumberProfileId.
     *
     * The read is what makes this survivable: every profile reports all four as false, so a
     * caller that checks its own write can see it did not take. Requests carrying one are logged, so we can
     * tell when nobody sends them any more and the fields can go for real.
     */
    #[Optional('allow_contact_sharing', nullable: true)]
    public ?bool $allowContactSharing;

    /**
     * @deprecated
     */
    #[Optional('allow_template_sharing', nullable: true)]
    public ?bool $allowTemplateSharing;

    /**
     * Billing contact information for a profile.
     * Required when billing_model is "profile" or "profile_and_organization".
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
     * Brand and KYC data grouped into contact, business, and compliance sections.
     */
    #[Optional(nullable: true)]
    public ?Brand $brand;

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
     * @deprecated
     */
    #[Optional('inherit_contacts', nullable: true)]
    public ?bool $inheritContacts;

    /**
     * Whether this profile inherits TCR brand from organization (default: false).
     */
    #[Optional('inherit_tcr_brand', nullable: true)]
    public ?bool $inheritTcrBrand;

    /**
     * Whether this profile inherits TCR campaign from organization (default: false).
     */
    #[Optional('inherit_tcr_campaign', nullable: true)]
    public ?bool $inheritTcrCampaign;

    /**
     * @deprecated
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
     * Direct WhatsApp Business Account credentials for a profile.
     * Use this when the profile should have its own WhatsApp Business Account instead of inheriting from the organization.
     * Credentials must be obtained from Meta Business Manager by creating a System User with
     * whatsapp_business_messaging and whatsapp_business_management scopes.
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
     * @param Brand|BrandShape|null $brand
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails
     * @param WhatsappBusinessAccount|WhatsappBusinessAccountShape|null $whatsappBusinessAccount
     */
    public static function with(
        ?bool $allowContactSharing = null,
        ?bool $allowTemplateSharing = null,
        BillingContact|array|null $billingContact = null,
        ?string $billingModel = null,
        Brand|array|null $brand = null,
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
     * Deprecated. Accepted and ignored. Contact and template sharing between sender profiles is gone
     * — a profile sees only what it owns, and the organization still sees all of its profiles' contacts and
     * templates through read-time widening. The four columns behind these flags were dropped by
     * M260720120000.
     *
     * Bound rather than dropped so the properties survive on the wire and in a generated client: an
     * SDK that assigns them keeps compiling, which is the compatibility this exists for. Deliberately not
     * refused either — a 400 would break an integration that is otherwise working, and the capability
     * they ask for is gone either way. Same rule as SendingPhoneNumberProfileId.
     *
     * The read is what makes this survivable: every profile reports all four as false, so a
     * caller that checks its own write can see it did not take. Requests carrying one are logged, so we can
     * tell when nobody sends them any more and the fields can go for real.
     */
    public function withAllowContactSharing(?bool $allowContactSharing): self
    {
        $self = clone $this;
        $self['allowContactSharing'] = $allowContactSharing;

        return $self;
    }

    public function withAllowTemplateSharing(?bool $allowTemplateSharing): self
    {
        $self = clone $this;
        $self['allowTemplateSharing'] = $allowTemplateSharing;

        return $self;
    }

    /**
     * Billing contact information for a profile.
     * Required when billing_model is "profile" or "profile_and_organization".
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
     * Brand and KYC data grouped into contact, business, and compliance sections.
     *
     * @param Brand|BrandShape|null $brand
     */
    public function withBrand(Brand|array|null $brand): self
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

    public function withInheritContacts(?bool $inheritContacts): self
    {
        $self = clone $this;
        $self['inheritContacts'] = $inheritContacts;

        return $self;
    }

    /**
     * Whether this profile inherits TCR brand from organization (default: false).
     */
    public function withInheritTcrBrand(?bool $inheritTcrBrand): self
    {
        $self = clone $this;
        $self['inheritTcrBrand'] = $inheritTcrBrand;

        return $self;
    }

    /**
     * Whether this profile inherits TCR campaign from organization (default: false).
     */
    public function withInheritTcrCampaign(?bool $inheritTcrCampaign): self
    {
        $self = clone $this;
        $self['inheritTcrCampaign'] = $inheritTcrCampaign;

        return $self;
    }

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
     * Direct WhatsApp Business Account credentials for a profile.
     * Use this when the profile should have its own WhatsApp Business Account instead of inheriting from the organization.
     * Credentials must be obtained from Meta Business Manager by creating a System User with
     * whatsapp_business_messaging and whatsapp_business_management scopes.
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
