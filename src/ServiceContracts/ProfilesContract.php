<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\Profiles\APIResponseOfProfileDetail;
use SentDm\Profiles\BillingContactInfo;
use SentDm\Profiles\BrandsBrandData;
use SentDm\Profiles\PaymentDetails;
use SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount;
use SentDm\Profiles\ProfileDeleteParams\Body;
use SentDm\Profiles\ProfileListResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type WhatsappBusinessAccountShape from \SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount
 * @phpstan-import-type BodyShape from \SentDm\Profiles\ProfileDeleteParams\Body
 * @phpstan-import-type BillingContactInfoShape from \SentDm\Profiles\BillingContactInfo
 * @phpstan-import-type BrandsBrandDataShape from \SentDm\Profiles\BrandsBrandData
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\PaymentDetails
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ProfilesContract
{
    /**
     * @api
     *
     * @param bool $allowContactSharing Body param: Whether contacts are shared across profiles (default: false)
     * @param bool $allowTemplateSharing Body param: Whether templates are shared across profiles (default: false)
     * @param BillingContactInfo|BillingContactInfoShape|null $billingContact Body param: Billing contact information for a profile.
     * Required when billing_model is "profile" or "profile_and_organization".
     * @param string|null $billingModel Body param: Billing model: profile, organization, or profile_and_organization (default: profile).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     * @param BrandsBrandData|BrandsBrandDataShape|null $brand Body param: Brand and KYC data grouped into contact, business, and compliance sections
     * @param string|null $description Body param: Profile description (optional)
     * @param string|null $icon Body param: Profile icon URL (optional)
     * @param bool|null $inheritContacts Body param: Whether this profile inherits contacts from organization (default: true)
     * @param bool|null $inheritTcrBrand Body param: Whether this profile inherits TCR brand from organization (default: true)
     * @param bool|null $inheritTcrCampaign Body param: Whether this profile inherits TCR campaign from organization (default: true)
     * @param bool|null $inheritTemplates Body param: Whether this profile inherits templates from organization (default: true)
     * @param string $name Body param: Profile name (required)
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails Body param: Payment card details for a profile.
     * Accepted when billing_model is "profile" or "profile_and_organization".
     * These details are not stored on our servers and will be forwarded to the payment processor.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $shortName Body param: Profile short name/abbreviation (optional). Must be 3–11 characters, contain only letters, numbers,
     * and spaces, and include at least one letter. Example: "SALES", "Mkt 2", "Support1".
     * @param WhatsappBusinessAccount|WhatsappBusinessAccountShape|null $whatsappBusinessAccount Body param: Direct WhatsApp Business Account credentials for a profile.
     * Use this when the profile should have its own WhatsApp Business Account instead of inheriting from the organization.
     * Credentials must be obtained from Meta Business Manager by creating a System User with
     * whatsapp_business_messaging and whatsapp_business_management scopes.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?bool $allowContactSharing = null,
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
     * @param BillingContactInfo|BillingContactInfoShape|null $billingContact Body param: Billing contact information for a profile.
     * Required when billing_model is "profile" or "profile_and_organization".
     * @param string|null $billingModel Body param: Billing model: profile, organization, or profile_and_organization (optional).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     * @param BrandsBrandData|BrandsBrandDataShape|null $brand Body param: Brand and KYC data grouped into contact, business, and compliance sections
     * @param string|null $description Body param: Profile description (optional)
     * @param string|null $icon Body param: Profile icon URL (optional)
     * @param bool|null $inheritContacts Body param: Whether this profile inherits contacts from organization (optional)
     * @param bool|null $inheritTcrBrand Body param: Whether this profile inherits TCR brand from organization (optional)
     * @param bool|null $inheritTcrCampaign Body param: Whether this profile inherits TCR campaign from organization (optional)
     * @param bool|null $inheritTemplates Body param: Whether this profile inherits templates from organization (optional)
     * @param string|null $name Body param: Profile name (optional)
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails Body param: Payment card details for a profile.
     * Accepted when billing_model is "profile" or "profile_and_organization".
     * These details are not stored on our servers and will be forwarded to the payment processor.
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
    public function completeSetup(
        string $profileID,
        string $webHookURL,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
