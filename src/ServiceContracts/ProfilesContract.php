<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Core\Exceptions\APIException;
use SentDm\Profiles\APIResponseOfProfileDetail;
use SentDm\Profiles\ProfileListResponse;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface ProfilesContract
{
    /**
     * @api
     *
     * @param bool $allowContactSharing Body param: Whether contacts are shared across profiles (default: false)
     * @param bool $allowTemplateSharing Body param: Whether templates are shared across profiles (default: false)
     * @param string|null $billingModel Body param: Billing model: profile, organization, or profile_and_organization (default: profile)
     * @param string|null $description Body param: Profile description (optional)
     * @param string|null $icon Body param: Profile icon URL (optional)
     * @param bool|null $inheritContacts Body param: Whether this profile inherits contacts from organization (default: true)
     * @param bool|null $inheritTcrBrand Body param: Whether this profile inherits TCR brand from organization (default: true)
     * @param bool|null $inheritTcrCampaign Body param: Whether this profile inherits TCR campaign from organization (default: true)
     * @param bool|null $inheritTemplates Body param: Whether this profile inherits templates from organization (default: true)
     * @param string $name Body param: Profile name (required)
     * @param string|null $shortName Body param: Profile short name/abbreviation (optional)
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?bool $allowContactSharing = null,
        ?bool $allowTemplateSharing = null,
        ?string $billingModel = null,
        ?string $description = null,
        ?string $icon = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $name = null,
        ?string $shortName = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfProfileDetail;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $profileID,
        RequestOptions|array|null $requestOptions = null
    ): APIResponseOfProfileDetail;

    /**
     * @api
     *
     * @param string $profileID_ Path param
     * @param bool|null $allowContactSharing Body param: Whether contacts are shared across profiles (optional)
     * @param bool|null $allowNumberChangeDuringOnboarding Body param: Whether number changes are allowed during onboarding (optional)
     * @param bool|null $allowTemplateSharing Body param: Whether templates are shared across profiles (optional)
     * @param string|null $billingModel Body param: Billing model: profile, organization, or profile_and_organization (optional)
     * @param string|null $description Body param: Profile description (optional)
     * @param string|null $icon Body param: Profile icon URL (optional)
     * @param bool|null $inheritContacts Body param: Whether this profile inherits contacts from organization (optional)
     * @param bool|null $inheritTcrBrand Body param: Whether this profile inherits TCR brand from organization (optional)
     * @param bool|null $inheritTcrCampaign Body param: Whether this profile inherits TCR campaign from organization (optional)
     * @param bool|null $inheritTemplates Body param: Whether this profile inherits templates from organization (optional)
     * @param string|null $name Body param: Profile name (optional)
     * @param string $profileID Body param: Profile ID from route parameter
     * @param string|null $sendingPhoneNumber Body param: Direct phone number for SMS sending (optional)
     * @param string|null $sendingPhoneNumberProfileID Body param: Reference to another profile to use for SMS/Telnyx configuration (optional)
     * @param string|null $sendingWhatsappNumberProfileID Body param: Reference to another profile to use for WhatsApp configuration (optional)
     * @param string|null $shortName Body param: Profile short name/abbreviation (optional)
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $whatsappPhoneNumber Body param: Direct phone number for WhatsApp sending (optional)
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $profileID_,
        ?bool $allowContactSharing = null,
        ?bool $allowNumberChangeDuringOnboarding = null,
        ?bool $allowTemplateSharing = null,
        ?string $billingModel = null,
        ?string $description = null,
        ?string $icon = null,
        ?bool $inheritContacts = null,
        ?bool $inheritTcrBrand = null,
        ?bool $inheritTcrCampaign = null,
        ?bool $inheritTemplates = null,
        ?string $name = null,
        ?string $profileID = null,
        ?string $sendingPhoneNumber = null,
        ?string $sendingPhoneNumberProfileID = null,
        ?string $sendingWhatsappNumberProfileID = null,
        ?string $shortName = null,
        ?bool $testMode = null,
        ?string $whatsappPhoneNumber = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfProfileDetail;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): ProfileListResponse;

    /**
     * @api
     *
     * @param string $profileID Profile ID from route parameter
     * @param bool $testMode Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $profileID_,
        ?string $profileID = null,
        ?bool $testMode = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $profileID Path param: Profile ID from route
     * @param string $webHookURL Body param: Webhook URL to call when profile completion finishes (success or failure)
     * @param bool $testMode Body param: Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function complete(
        string $profileID,
        string $webHookURL,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
