<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Profiles\ProfileCompleteResponse;
use SentDm\Profiles\ProfileCreateParams\BillingContact;
use SentDm\Profiles\ProfileCreateParams\Brand;
use SentDm\Profiles\ProfileCreateParams\PaymentDetails;
use SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount;
use SentDm\Profiles\ProfileGetResponse;
use SentDm\Profiles\ProfileListResponse;
use SentDm\Profiles\ProfileNewResponse;
use SentDm\Profiles\ProfileUpdateResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ProfilesContract;
use SentDm\Services\Profiles\CampaignsService;

/**
 * **Deprecated — use Sender Profiles.**.
 *
 * The original profile resource, kept because it has live callers. It still works, and its replacement is `/v3/sender-profiles`, which takes the identity and the campaign in one call instead of across three.
 *
 * New integrations should not start here.
 *
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileCreateParams\BillingContact
 * @phpstan-import-type BrandShape from \SentDm\Profiles\ProfileCreateParams\Brand
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileCreateParams\PaymentDetails
 * @phpstan-import-type WhatsappBusinessAccountShape from \SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileUpdateParams\BillingContact as BillingContactShape1
 * @phpstan-import-type BrandShape from \SentDm\Profiles\ProfileUpdateParams\Brand as BrandShape1
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileUpdateParams\PaymentDetails as PaymentDetailsShape1
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
     * @deprecated
     *
     * @api
     *
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
     * @param bool|null $allowContactSharing Body param: Deprecated. Accepted and ignored. Contact and template sharing between sender profiles is gone
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
     * @param bool|null $allowTemplateSharing Body param
     * @param BillingContact|BillingContactShape|null $billingContact Body param: Billing contact information for a profile.
     * Required when billing_model is "profile" or "profile_and_organization".
     * @param string|null $billingModel Body param: Billing model: profile, organization, or profile_and_organization (default: profile).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     * @param Brand|BrandShape|null $brand Body param: Brand and KYC data grouped into contact, business, and compliance sections
     * @param string|null $description Body param: Profile description (optional)
     * @param string|null $icon Body param: Profile icon URL (optional)
     * @param bool|null $inheritContacts Body param
     * @param bool|null $inheritTcrBrand Body param: Whether this profile inherits TCR brand from organization (default: false)
     * @param bool|null $inheritTcrCampaign Body param: Whether this profile inherits TCR campaign from organization (default: false)
     * @param bool|null $inheritTemplates Body param
     * @param string $name Body param: Profile name (required)
     * @param PaymentDetails|PaymentDetailsShape|null $paymentDetails Body param: Payment card details for this profile (optional).
     * Accepted when billing_model is "profile" or "profile_and_organization".
     * Not persisted on our servers — forwarded to the payment processor.
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
        RequestOptions|array|null $requestOptions = null,
    ): ProfileNewResponse {
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
     * @deprecated
     *
     * @api
     *
     * **Deprecated.** This endpoint is replaced by `/v3/sender-profiles` and will be removed in a future release. It still behaves exactly as before, so nothing needs to change today — but new integrations should use `/v3/sender-profiles`, which models a profile's markets, compliance, brand, campaigns and billing explicitly.
     *
     * Retrieves detailed information about a specific sender profile within an organization, including brand and KYC information if a brand has been configured.
     *
     * @param string $profileID Profile ID from route parameter
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $profileID,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileGetResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($profileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @deprecated
     *
     * @api
     *
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
     * @param string $profileID Path param: Profile ID from route parameter
     * @param bool|null $allowContactSharing Body param: Deprecated. Accepted and ignored. Contact and template sharing between sender profiles is gone
     * — a profile sees only what it owns, and the organization still sees all of its profiles' contacts and
     * templates through read-time widening. The four columns behind these flags were dropped by
     * M260720120000.
     *
     * Retired the same way as SendingPhoneNumberProfileId, and for the same reason: the
     * properties stay bound so an SDK that assigns them keeps compiling, and a 400 would break a
     * working integration over a capability that is gone regardless. Every profile reports all four as
     * false, so a caller that checks its own write can see it did not take.
     * @param bool|null $allowNumberChangeDuringOnboarding Body param: Whether number changes are allowed during onboarding (optional)
     * @param bool|null $allowTemplateSharing Body param
     * @param \SentDm\Profiles\ProfileUpdateParams\BillingContact|BillingContactShape1|null $billingContact Body param: Billing contact information for a profile.
     * Required when billing_model is "profile" or "profile_and_organization".
     * @param string|null $billingModel Body param: Billing model: profile, organization, or profile_and_organization (optional).
     * - "organization": the organization's billing details are used; no profile-level billing info needed.
     * - "profile": the profile is billed independently; billing_contact is required.
     * - "profile_and_organization": the profile is billed first with the organization as fallback; billing_contact is required.
     * @param \SentDm\Profiles\ProfileUpdateParams\Brand|BrandShape1|null $brand Body param: Brand and KYC data grouped into contact, business, and compliance sections
     * @param string|null $description Body param: Profile description (optional)
     * @param string|null $icon Body param: Profile icon URL (optional)
     * @param bool|null $inheritContacts Body param
     * @param bool|null $inheritTcrBrand Body param: Whether this profile inherits TCR brand from organization (optional)
     * @param bool|null $inheritTcrCampaign Body param: Whether this profile inherits TCR campaign from organization (optional)
     * @param bool|null $inheritTemplates Body param
     * @param string|null $name Body param: Profile name (optional)
     * @param \SentDm\Profiles\ProfileUpdateParams\PaymentDetails|PaymentDetailsShape1|null $paymentDetails Body param: Payment card details for this profile (optional).
     * Accepted when billing_model is "profile" or "profile_and_organization".
     * Not persisted on our servers — forwarded to the payment processor.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $sendingPhoneNumber Body param: Direct phone number for SMS sending (optional)
     * @param string|null $sendingPhoneNumberProfileID Body param: Deprecated. Accepted and ignored. Sender borrowing is gone: a profile cannot send from another
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
     * @param string|null $sendingWhatsappNumberProfileID Body param
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
        \SentDm\Profiles\ProfileUpdateParams\Brand|array|null $brand = null,
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
    ): ProfileUpdateResponse {
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
     * @deprecated
     *
     * @api
     *
     * **Deprecated.** This endpoint is replaced by `/v3/sender-profiles` and will be removed in a future release. It still behaves exactly as before, so nothing needs to change today — but new integrations should use `/v3/sender-profiles`, which models a profile's markets, compliance, brand, campaigns and billing explicitly.
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
     * @deprecated
     *
     * @api
     *
     * **Deprecated.** This endpoint is replaced by `/v3/sender-profiles` and will be removed in a future release. It still behaves exactly as before, so nothing needs to change today — but new integrations should use `/v3/sender-profiles`, which models a profile's markets, compliance, brand, campaigns and billing explicitly.
     *
     * Soft deletes a sender profile. The profile will be marked as deleted but data is retained. Anything it still held is released first: phone numbers return to our inventory and can go to whoever asks next, its own WhatsApp account is deregistered, and its routing rules stop being used. Requires admin role in the organization.
     *
     * @param string $profileID Path param: Profile ID from route parameter
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
     * @deprecated
     *
     * @api
     *
     * **Deprecated.** This endpoint is replaced by `/v3/sender-profiles` and will be removed in a future release. It still behaves exactly as before, so nothing needs to change today — but new integrations should use `/v3/sender-profiles`, which models a profile's markets, compliance, brand, campaigns and billing explicitly.
     *
     * Final step in the profile compliance workflow. Validates all prerequisites (KYC, brand, campaigns, required documents), connects the profile to the SMS and WhatsApp channels, and marks it onboarded. Prerequisites are always validated first: if any fail the call returns 400 naming every unmet one, and nothing is started. If they pass and the profile is already onboarded, the call returns 200 and does nothing. Otherwise it returns 202 and calls the provided webhook URL when background processing finishes.
     *
     * Callable with the organization's API key or the profile's own key. The key's user must be an admin or owner of the profile, or of the organization it belongs to.
     *
     * Prerequisites (all but the last are checked before the already-onboarded short-circuit,
     * matching the previous contract; the last is checked after it, so a profile that is already
     * onboarded is never rejected by it):
     * - Profile must have a name, short name, and description (short name max 50 characters, description max 5000)
     * - webHookUrl must be supplied on the request
     * - A KYC form submission is required
     * - A brand is required, either on the profile or inherited from the parent organization
     * - TCR applications must have at least one campaign, own or inherited
     * - Destination countries marked as main must have their required compliance documents uploaded
     * - TCR applications must state whether they inherit the organization's TCR brand and campaign
     *
     * Outcome:
     * - Once the prerequisites pass and background processing succeeds, the profile's conversionFlowStatus becomes ONBOARDED and its public status reads `approved`
     * - A profile with no WhatsApp channel, or one still awaiting TCR registration or country documents, is onboarded like any other. Those are answered by the brand and campaign records, not by a status on the profile
     * - If background processing fails, the profile keeps the status it already had and the webhook reports the reason
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
