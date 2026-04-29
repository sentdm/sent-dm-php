<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Profiles\APIResponseOfProfileDetail;
use SentDm\Profiles\BillingContactInfo;
use SentDm\Profiles\BrandsBrandData;
use SentDm\Profiles\PaymentDetails;
use SentDm\Profiles\ProfileCompleteResponse;
use SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount;
use SentDm\Profiles\ProfileListResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ProfilesContract;
use SentDm\Services\Profiles\CampaignsService;

/**
 * Manage organization profiles.
 *
 * @phpstan-import-type WhatsappBusinessAccountShape from \SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount
 * @phpstan-import-type BillingContactInfoShape from \SentDm\Profiles\BillingContactInfo
 * @phpstan-import-type BrandsBrandDataShape from \SentDm\Profiles\BrandsBrandData
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\PaymentDetails
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class ProfilesService implements ProfilesContract
{
    /**
     * @api
     */
    public ProfilesRawService $raw;

    /**
     * @api
     */
    public CampaignsService $campaigns;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ProfilesRawService($client);
        $this->campaigns = new CampaignsService($client);
    }

    /**
     * @api
     *
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
    ): APIResponseOfProfileDetail {
        $params = Util::removeNulls(
            [
                'allowContactSharing' => $allowContactSharing,
                'allowTemplateSharing' => $allowTemplateSharing,
                'billingContact' => $billingContact,
                'billingModel' => $billingModel,
                'brand' => $brand,
                'description' => $description,
                'icon' => $icon,
                'inheritContacts' => $inheritContacts,
                'inheritTcrBrand' => $inheritTcrBrand,
                'inheritTcrCampaign' => $inheritTcrCampaign,
                'inheritTemplates' => $inheritTemplates,
                'name' => $name,
                'paymentDetails' => $paymentDetails,
                'sandbox' => $sandbox,
                'shortName' => $shortName,
                'whatsappBusinessAccount' => $whatsappBusinessAccount,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves detailed information about a specific sender profile within an organization, including brand and KYC information if a brand has been configured.
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
    ): APIResponseOfProfileDetail {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($profileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
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
    ): APIResponseOfProfileDetail {
        $params = Util::removeNulls(
            [
                'allowContactSharing' => $allowContactSharing,
                'allowNumberChangeDuringOnboarding' => $allowNumberChangeDuringOnboarding,
                'allowTemplateSharing' => $allowTemplateSharing,
                'billingContact' => $billingContact,
                'billingModel' => $billingModel,
                'brand' => $brand,
                'description' => $description,
                'icon' => $icon,
                'inheritContacts' => $inheritContacts,
                'inheritTcrBrand' => $inheritTcrBrand,
                'inheritTcrCampaign' => $inheritTcrCampaign,
                'inheritTemplates' => $inheritTemplates,
                'name' => $name,
                'paymentDetails' => $paymentDetails,
                'sandbox' => $sandbox,
                'sendingPhoneNumber' => $sendingPhoneNumber,
                'sendingPhoneNumberProfileID' => $sendingPhoneNumberProfileID,
                'sendingWhatsappNumberProfileID' => $sendingWhatsappNumberProfileID,
                'shortName' => $shortName,
                'whatsappPhoneNumber' => $whatsappPhoneNumber,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($profileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieves all sender profiles within an organization, including brand information for each profile. Profiles represent different brands, departments, or use cases within an organization, each with their own messaging configuration.
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null
    ): ProfileListResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Soft deletes a sender profile. The profile will be marked as deleted but data is retained. Requires admin role in the organization.
     *
     * @param string $profileID Path param
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $profileID,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(
            ['sandbox' => $sandbox, 'xProfileID' => $xProfileID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($profileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Final step in profile compliance workflow. Validates all prerequisites (general data, brand, campaigns), connects profile to Telnyx/WhatsApp, and sets status based on configuration. The process runs in the background and calls the provided webhook URL when finished.
     *
     *                 Prerequisites:
     *                 - Profile must be completed
     *                 - If inheritTcrBrand=false: Profile must have existing brand
     *                 - If inheritTcrBrand=true: Parent must have existing brand
     *                 - If TCR application: Must have at least one campaign (own or inherited)
     *                 - If inheritTcrCampaign=false: Profile should have campaigns
     *                 - If inheritTcrCampaign=true: Parent must have campaigns
     *
     *                 Status Logic:
     *                 - If both SMS and WhatsApp channels are missing → SUBMITTED
     *                 - If TCR application and not inheriting brand/campaigns → SUBMITTED
     *                 - If non-TCR with destination country (IsMain=true) → SUBMITTED
     *                 - Otherwise → COMPLETED
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
    ): ProfileCompleteResponse {
        $params = Util::removeNulls(
            [
                'webHookURL' => $webHookURL,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->complete($profileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
