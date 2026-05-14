<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileGetResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileGetResponse\Data\BillingContact;
use SentDm\Profiles\ProfileGetResponse\Data\Brand;

/**
 * Detailed profile response for v3 API.
 *
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileGetResponse\Data\BillingContact
 * @phpstan-import-type BrandShape from \SentDm\Profiles\ProfileGetResponse\Data\Brand
 *
 * @phpstan-type DataShape = array{
 *   id?: string|null,
 *   allowContactSharing?: bool|null,
 *   allowNumberChangeDuringOnboarding?: bool|null,
 *   allowTemplateSharing?: bool|null,
 *   billingContact?: null|BillingContact|BillingContactShape,
 *   billingModel?: string|null,
 *   brand?: null|Brand|BrandShape,
 *   createdAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   email?: string|null,
 *   icon?: string|null,
 *   inheritContacts?: bool|null,
 *   inheritTcrBrand?: bool|null,
 *   inheritTcrCampaign?: bool|null,
 *   inheritTemplates?: bool|null,
 *   name?: string|null,
 *   organizationID?: string|null,
 *   sendingPhoneNumber?: string|null,
 *   sendingPhoneNumberProfileID?: string|null,
 *   sendingWhatsappNumberProfileID?: string|null,
 *   shortName?: string|null,
 *   status?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   wabaID?: string|null,
 *   whatsappPhoneNumber?: string|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Profile unique identifier.
     */
    #[Optional]
    public ?string $id;

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
     * Billing contact info returned in profile responses.
     */
    #[Optional('billing_contact', nullable: true)]
    public ?BillingContact $billingContact;

    /**
     * Billing model: profile, organization, or profile_and_organization.
     */
    #[Optional('billing_model')]
    public ?string $billingModel;

    /**
     * Brand response with nested contact, business, and compliance sections — mirrors the request structure.
     */
    #[Optional(nullable: true)]
    public ?Brand $brand;

    /**
     * When the profile was created.
     */
    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * Profile description.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Profile email (inherited from organization).
     */
    #[Optional(nullable: true)]
    public ?string $email;

    /**
     * Profile icon URL.
     */
    #[Optional(nullable: true)]
    public ?string $icon;

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
     * Profile name.
     */
    #[Optional]
    public ?string $name;

    /**
     * Parent organization ID.
     */
    #[Optional('organization_id', nullable: true)]
    public ?string $organizationID;

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
     * Profile short name/abbreviation. 3–11 characters: letters, numbers, and spaces only, with at least one letter.
     */
    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    /**
     * Profile setup status: incomplete, pending_review, approved, rejected.
     */
    #[Optional]
    public ?string $status;

    /**
     * When the profile was last updated.
     */
    #[Optional('updated_at', nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    /**
     * WhatsApp Business Account ID associated with this profile.
     * Present whether the WABA is inherited from the organization or configured directly.
     */
    #[Optional('waba_id', nullable: true)]
    public ?string $wabaID;

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
     *
     * @param BillingContact|BillingContactShape|null $billingContact
     * @param Brand|BrandShape|null $brand
     */
    public static function with(
        ?string $id = null,
        ?bool $allowContactSharing = null,
        ?bool $allowNumberChangeDuringOnboarding = null,
        ?bool $allowTemplateSharing = null,
        BillingContact|array|null $billingContact = null,
        ?string $billingModel = null,
        Brand|array|null $brand = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $description = null,
        ?string $email = null,
        ?string $icon = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $name = null,
        ?string $organizationID = null,
        ?string $sendingPhoneNumber = null,
        ?string $sendingPhoneNumberProfileID = null,
        ?string $sendingWhatsappNumberProfileID = null,
        ?string $shortName = null,
        ?string $status = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $wabaID = null,
        ?string $whatsappPhoneNumber = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $allowContactSharing && $self['allowContactSharing'] = $allowContactSharing;
        null !== $allowNumberChangeDuringOnboarding && $self['allowNumberChangeDuringOnboarding'] = $allowNumberChangeDuringOnboarding;
        null !== $allowTemplateSharing && $self['allowTemplateSharing'] = $allowTemplateSharing;
        null !== $billingContact && $self['billingContact'] = $billingContact;
        null !== $billingModel && $self['billingModel'] = $billingModel;
        null !== $brand && $self['brand'] = $brand;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $email && $self['email'] = $email;
        null !== $icon && $self['icon'] = $icon;
        null !== $inheritContacts && $self['inheritContacts'] = $inheritContacts;
        null !== $inheritTcrBrand && $self['inheritTcrBrand'] = $inheritTcrBrand;
        null !== $inheritTcrCampaign && $self['inheritTcrCampaign'] = $inheritTcrCampaign;
        null !== $inheritTemplates && $self['inheritTemplates'] = $inheritTemplates;
        null !== $name && $self['name'] = $name;
        null !== $organizationID && $self['organizationID'] = $organizationID;
        null !== $sendingPhoneNumber && $self['sendingPhoneNumber'] = $sendingPhoneNumber;
        null !== $sendingPhoneNumberProfileID && $self['sendingPhoneNumberProfileID'] = $sendingPhoneNumberProfileID;
        null !== $sendingWhatsappNumberProfileID && $self['sendingWhatsappNumberProfileID'] = $sendingWhatsappNumberProfileID;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $wabaID && $self['wabaID'] = $wabaID;
        null !== $whatsappPhoneNumber && $self['whatsappPhoneNumber'] = $whatsappPhoneNumber;

        return $self;
    }

    /**
     * Profile unique identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
     * Billing contact info returned in profile responses.
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
     * Billing model: profile, organization, or profile_and_organization.
     */
    public function withBillingModel(string $billingModel): self
    {
        $self = clone $this;
        $self['billingModel'] = $billingModel;

        return $self;
    }

    /**
     * Brand response with nested contact, business, and compliance sections — mirrors the request structure.
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
     * When the profile was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Profile description.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Profile email (inherited from organization).
     */
    public function withEmail(?string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Profile icon URL.
     */
    public function withIcon(?string $icon): self
    {
        $self = clone $this;
        $self['icon'] = $icon;

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
     * Profile name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Parent organization ID.
     */
    public function withOrganizationID(?string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

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
     * Profile short name/abbreviation. 3–11 characters: letters, numbers, and spaces only, with at least one letter.
     */
    public function withShortName(?string $shortName): self
    {
        $self = clone $this;
        $self['shortName'] = $shortName;

        return $self;
    }

    /**
     * Profile setup status: incomplete, pending_review, approved, rejected.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When the profile was last updated.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * WhatsApp Business Account ID associated with this profile.
     * Present whether the WABA is inherited from the organization or configured directly.
     */
    public function withWabaID(?string $wabaID): self
    {
        $self = clone $this;
        $self['wabaID'] = $wabaID;

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
