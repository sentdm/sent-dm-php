<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Brands\BrandData;
use SentDm\Core\Exceptions\APIException;
use SentDm\Profiles\APIResponseOfProfileDetail;
use SentDm\Profiles\ProfileCreateParams\BillingContact;
use SentDm\Profiles\ProfileCreateParams\PaymentDetails;
use SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount;
use SentDm\Profiles\ProfileDeleteParams\Body;
use SentDm\Profiles\ProfileListResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileCreateParams\BillingContact
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileCreateParams\PaymentDetails
 * @phpstan-import-type WhatsappBusinessAccountShape from \SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileUpdateParams\BillingContact as BillingContactShape1
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileUpdateParams\PaymentDetails as PaymentDetailsShape1
 * @phpstan-import-type BodyShape from \SentDm\Profiles\ProfileDeleteParams\Body
 * @phpstan-import-type BrandDataShape from \SentDm\Brands\BrandData
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ProfilesContract
{
    /**
     * @api
     *
     * @param bool $allowContactSharing Body param: Whether contacts are shared across profiles (default: false)
     * @param bool $allowTemplateSharing Body param: Whether templates are shared across profiles (default: false)
     * @param BillingContact|BillingContactShape|null $billingContact Body param: Billing contact for this profile. Required when billing_model is "profile" or "profile_and_organization".
     * Identifies who receives invoices and who is responsible for payment.
     * @param string|null $billingModel Body param: Billing model: profile, organization, or profile_and_organization (default: profile).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     * @param BrandData|BrandDataShape|null $brand Body param: Brand and KYC information for this profile (optional).
     * When provided, creates the brand associated with this profile.
     * Cannot be set when inherit_tcr_brand is true.
     * @param string|null $description Body param: Profile description (optional)
     * @param string|null $icon Body param: Profile icon URL (optional)
     * @param bool|null $inheritContacts Body param: Whether this profile inherits contacts from organization (default: true)
     * @param bool|null $inheritTcrBrand Body param: Whether this profile inherits TCR brand from organization (default: true)
     * @param bool|null $inheritTcrCampaign Body param: Whether this profile inherits TCR campaign from organization (default: true)
     * @param bool|null $inheritTemplates Body param: Whether this profile inherits templates from organization (default: true)
     * @param string $name Body param: Profile name (required)
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails Body param: Payment card details for this profile (optional).
     * Accepted when billing_model is "profile" or "profile_and_organization".
     * Not persisted on our servers — forwarded to the payment processor.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $shortName Body param: Profile short name/abbreviation (optional). Must be 3–11 characters, contain only letters, numbers,
     * and spaces, and include at least one letter. Example: "SALES", "Mkt 2", "Support1".
     * @param WhatsappBusinessAccount|WhatsappBusinessAccountShape|null $whatsappBusinessAccount Body param: Direct WhatsApp Business Account credentials for this profile.
     * When provided, the profile uses its own WhatsApp Business Account instead of inheriting from the organization.
     * When omitted, the profile inherits the organization's WhatsApp Business Account (requires the organization
     * to have completed WhatsApp Embedded Signup).
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
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
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfProfileDetail;

    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $profileID,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfProfileDetail;

    /**
     * @api
     *
     * @param string $profileID Path param
     * @param bool|null $allowContactSharing Body param: Whether contacts are shared across profiles (optional)
     * @param bool|null $allowNumberChangeDuringOnboarding Body param: Whether number changes are allowed during onboarding (optional)
     * @param bool|null $allowTemplateSharing Body param: Whether templates are shared across profiles (optional)
     * @param \SentDm\Profiles\ProfileUpdateParams\BillingContact|BillingContactShape1|null $billingContact Body param: Billing contact for this profile. Required when billing_model is "profile" or "profile_and_organization"
     * and no billing contact has been configured yet. Identifies who receives invoices and who is responsible for payment.
     * @param string|null $billingModel Body param: Billing model: profile, organization, or profile_and_organization (optional).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     * @param BrandData|BrandDataShape|null $brand Body param: Brand and KYC information for this profile (optional).
     * When provided, creates or updates the brand associated with this profile.
     * Cannot be set when inherit_tcr_brand is true.
     * Once a brand has been submitted to TCR it cannot be modified.
     * @param string|null $description Body param: Profile description (optional)
     * @param string|null $icon Body param: Profile icon URL (optional)
     * @param bool|null $inheritContacts Body param: Whether this profile inherits contacts from organization (optional)
     * @param bool|null $inheritTcrBrand Body param: Whether this profile inherits TCR brand from organization (optional)
     * @param bool|null $inheritTcrCampaign Body param: Whether this profile inherits TCR campaign from organization (optional)
     * @param bool|null $inheritTemplates Body param: Whether this profile inherits templates from organization (optional)
     * @param string|null $name Body param: Profile name (optional)
     * @param \SentDm\Profiles\ProfileUpdateParams\PaymentDetails|PaymentDetailsShape1|null $paymentDetails Body param: Payment card details for this profile (optional).
     * Accepted when billing_model is "profile" or "profile_and_organization".
     * Not persisted on our servers — forwarded to the payment processor.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $sendingPhoneNumber Body param: Direct phone number for SMS sending (optional)
     * @param string|null $sendingPhoneNumberProfileID Body param: Reference to another profile to use for SMS/Telnyx configuration (optional)
     * @param string|null $sendingWhatsappNumberProfileID Body param: Reference to another profile to use for WhatsApp configuration (optional)
     * @param string|null $shortName Body param: Profile short name/abbreviation (optional). Must be 3–11 characters, contain only letters, numbers,
     * and spaces, and include at least one letter. Example: "SALES", "Mkt 2", "Support1".
     * @param string|null $whatsappPhoneNumber Body param: Direct phone number for WhatsApp sending (optional)
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $profileID,
        ?bool $allowContactSharing = null,
        ?bool $allowNumberChangeDuringOnboarding = null,
        ?bool $allowTemplateSharing = null,
        \SentDm\Profiles\ProfileUpdateParams\BillingContact|array|null $billingContact = null,
        ?string $billingModel = null,
        BrandData|array|null $brand = null,
        ?string $description = null,
        ?string $icon = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $name = null,
        \SentDm\Profiles\ProfileUpdateParams\PaymentDetails|array|null $paymentDetails = null,
        ?bool $sandbox = null,
        ?string $sendingPhoneNumber = null,
        ?string $sendingPhoneNumberProfileID = null,
        ?string $sendingWhatsappNumberProfileID = null,
        ?string $shortName = null,
        ?string $whatsappPhoneNumber = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfProfileDetail;

    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileListResponse;

    /**
     * @api
     *
     * @param string $profileID Path param
     * @param Body|BodyShape $body Body param: Request to delete a profile
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $profileID,
        Body|array $body,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $profileID Path param: Profile ID from route
     * @param string $webHookURL Body param: Webhook URL to call when profile completion finishes (success or failure)
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function complete(
        string $profileID,
        string $webHookURL,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
