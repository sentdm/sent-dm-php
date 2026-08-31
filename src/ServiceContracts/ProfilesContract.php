<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
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

/**
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileCreateParams\BillingContact
 * @phpstan-import-type BrandShape from \SentDm\Profiles\ProfileCreateParams\Brand
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileCreateParams\PaymentDetails
 * @phpstan-import-type WhatsappBusinessAccountShape from \SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount
 * @phpstan-import-type BillingContactShape from \SentDm\Profiles\ProfileUpdateParams\BillingContact as BillingContactShape1
 * @phpstan-import-type BrandShape from \SentDm\Profiles\ProfileUpdateParams\Brand as BrandShape1
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\ProfileUpdateParams\PaymentDetails as PaymentDetailsShape1
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ProfilesContract
{
    /**
     * @deprecated
     *
     * @api
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
    ): ProfileNewResponse;

    /**
     * @deprecated
     *
     * @api
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
    ): ProfileGetResponse;

    /**
     * @deprecated
     *
     * @api
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
    ): ProfileUpdateResponse;

    /**
     * @deprecated
     *
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
     * @deprecated
     *
     * @api
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
    ): mixed;

    /**
     * @deprecated
     *
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
    ): ProfileCompleteResponse;
}
