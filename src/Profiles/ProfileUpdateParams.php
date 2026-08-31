<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileUpdateParams\BillingContact;
use SentDm\Profiles\ProfileUpdateParams\Brand;
use SentDm\Profiles\ProfileUpdateParams\PaymentDetails;

/**
 * **Deprecated.** This endpoint is replaced by `/v3/sender-profiles` and will be removed in a future release. It still behaves exactly as before, so nothing needs to change today — but new integrations should use `/v3/sender-profiles`, which models a profile's markets, compliance, brand, campaigns and billing explicitly.
 *
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
 * ## Deprecated fields
 *
 * `sending_phone_number_profile_id` and `sending_whatsapp_number_profile_id` are **accepted and ignored**. Sender borrowing is gone: a profile cannot send from another profile's number, because two profiles behind one sender makes an inbound reply and a delivery receipt ambiguous about whose they are.
 *
 * Sending either **changes nothing and still returns `200`** — they are kept on the contract so an existing integration keeps working. Reads carry both keys too and always answer `null`, which is how you can confirm the value did not take.
 *
 * Give the profile a sender of its own instead — `POST /v3/channels/sms` or `POST /v3/channels/whatsapp`, sent with the `x-profile-id` header naming it.
 *
 * @deprecated
 * @see SentDm\Services\ProfilesService::update()
 *
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileUpdateParams\BillingContact
 * @phpstan-import-type BrandShape from \SentDm\Profiles\ProfileUpdateParams\Brand
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileUpdateParams\PaymentDetails
 *
 * @phpstan-type ProfileUpdateParamsShape = array{
 *   allowContactSharing?: bool|null,
 *   allowNumberChangeDuringOnboarding?: bool|null,
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
     * @deprecated
     *
     * Deprecated. Accepted and ignored. Contact and template sharing between sender profiles is gone
     * — a profile sees only what it owns, and the organization still sees all of its profiles' contacts and
     * templates through read-time widening. The four columns behind these flags were dropped by
     * M260720120000.
     *
     * Retired the same way as SendingPhoneNumberProfileId, and for the same reason: the
     * properties stay bound so an SDK that assigns them keeps compiling, and a 400 would break a
     * working integration over a capability that is gone regardless. Every profile reports all four as
     * false, so a caller that checks its own write can see it did not take.
     */
    #[Optional('allow_contact_sharing', nullable: true)]
    public ?bool $allowContactSharing;

    /**
     * Whether number changes are allowed during onboarding (optional).
     */
    #[Optional('allow_number_change_during_onboarding', nullable: true)]
    public ?bool $allowNumberChangeDuringOnboarding;

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
     * Billing model: profile, organization, or profile_and_organization (optional).
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
     * @deprecated
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
     * @deprecated
     *
     * Deprecated. Accepted and ignored. Sender borrowing is gone: a profile cannot send from another
     * profile's SMS number. Supplying this changes nothing and the request still succeeds.
     *
     * Bound rather than dropped so the property survives on the wire and in a generated client — an SDK
     * that assigns it keeps compiling, which is the compatibility this exists for. It is deliberately not
     * refused: a 400 here would break an integration that is otherwise working, and the capability it
     * asks for is gone either way.
     *
     * The trade-off, stated plainly. A caller asking for borrowing is told it succeeded when
     * nothing happened. What makes that survivable is the read: sending_phone_number_profile_id comes
     * back null on every profile, so a caller that checks its own write can see it did not take. Every
     * request that carries one is logged, so we can tell when nobody is sending it any more and the field can
     * go for real.
     *
     * Give the profile a sender of its own instead: POST /v3/channels/sms with the
     * x-profile-id header naming it.
     */
    #[Optional('sending_phone_number_profile_id', nullable: true)]
    public ?string $sendingPhoneNumberProfileID;

    /**
     * @deprecated
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
     * @param BillingContact|BillingContactShape|null $billingContact
     * @param Brand|BrandShape|null $brand
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails
     */
    public static function with(
        ?bool $allowContactSharing = null,
        ?bool $allowNumberChangeDuringOnboarding = null,
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
     * Deprecated. Accepted and ignored. Contact and template sharing between sender profiles is gone
     * — a profile sees only what it owns, and the organization still sees all of its profiles' contacts and
     * templates through read-time widening. The four columns behind these flags were dropped by
     * M260720120000.
     *
     * Retired the same way as SendingPhoneNumberProfileId, and for the same reason: the
     * properties stay bound so an SDK that assigns them keeps compiling, and a 400 would break a
     * working integration over a capability that is gone regardless. Every profile reports all four as
     * false, so a caller that checks its own write can see it did not take.
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
     * Deprecated. Accepted and ignored. Sender borrowing is gone: a profile cannot send from another
     * profile's SMS number. Supplying this changes nothing and the request still succeeds.
     *
     * Bound rather than dropped so the property survives on the wire and in a generated client — an SDK
     * that assigns it keeps compiling, which is the compatibility this exists for. It is deliberately not
     * refused: a 400 here would break an integration that is otherwise working, and the capability it
     * asks for is gone either way.
     *
     * The trade-off, stated plainly. A caller asking for borrowing is told it succeeded when
     * nothing happened. What makes that survivable is the read: sending_phone_number_profile_id comes
     * back null on every profile, so a caller that checks its own write can see it did not take. Every
     * request that carries one is logged, so we can tell when nobody is sending it any more and the field can
     * go for real.
     *
     * Give the profile a sender of its own instead: POST /v3/channels/sms with the
     * x-profile-id header naming it.
     */
    public function withSendingPhoneNumberProfileID(
        ?string $sendingPhoneNumberProfileID
    ): self {
        $self = clone $this;
        $self['sendingPhoneNumberProfileID'] = $sendingPhoneNumberProfileID;

        return $self;
    }

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
