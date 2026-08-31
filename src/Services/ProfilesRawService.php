<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Profiles\ProfileCompleteParams;
use SentDm\Profiles\ProfileCompleteResponse;
use SentDm\Profiles\ProfileCreateParams;
use SentDm\Profiles\ProfileCreateParams\BillingContact;
use SentDm\Profiles\ProfileCreateParams\Brand;
use SentDm\Profiles\ProfileCreateParams\PaymentDetails;
use SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount;
use SentDm\Profiles\ProfileDeleteParams;
use SentDm\Profiles\ProfileGetResponse;
use SentDm\Profiles\ProfileListParams;
use SentDm\Profiles\ProfileListResponse;
use SentDm\Profiles\ProfileNewResponse;
use SentDm\Profiles\ProfileRetrieveParams;
use SentDm\Profiles\ProfileUpdateParams;
use SentDm\Profiles\ProfileUpdateResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ProfilesRawContract;

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
final class ProfilesRawService implements ProfilesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   allowContactSharing?: bool|null,
     *   allowTemplateSharing?: bool|null,
     *   billingContact?: BillingContact|BillingContactShape|null,
     *   billingModel?: string|null,
     *   brand?: Brand|BrandShape|null,
     *   description?: string|null,
     *   icon?: string|null,
     *   inheritContacts?: bool|null,
     *   inheritTcrBrand?: bool|null,
     *   inheritTcrCampaign?: bool|null,
     *   inheritTemplates?: bool|null,
     *   name?: string,
     *   paymentDetails?: PaymentDetails|PaymentDetailsShape|null,
     *   sandbox?: bool,
     *   shortName?: string|null,
     *   whatsappBusinessAccount?: WhatsappBusinessAccount|WhatsappBusinessAccountShape|null,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ProfileCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ProfileCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/profiles',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: ProfileNewResponse::class,
        );
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
     * @param array{xProfileID?: string}|ProfileRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $profileID,
        array|ProfileRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/profiles/%1$s', $profileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: ProfileGetResponse::class,
        );
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
     * @param array{
     *   allowContactSharing?: bool|null,
     *   allowNumberChangeDuringOnboarding?: bool|null,
     *   allowTemplateSharing?: bool|null,
     *   billingContact?: ProfileUpdateParams\BillingContact|BillingContactShape1|null,
     *   billingModel?: string|null,
     *   brand?: ProfileUpdateParams\Brand|BrandShape1|null,
     *   description?: string|null,
     *   icon?: string|null,
     *   inheritContacts?: bool|null,
     *   inheritTcrBrand?: bool|null,
     *   inheritTcrCampaign?: bool|null,
     *   inheritTemplates?: bool|null,
     *   name?: string|null,
     *   paymentDetails?: ProfileUpdateParams\PaymentDetails|PaymentDetailsShape1|null,
     *   sandbox?: bool,
     *   sendingPhoneNumber?: string|null,
     *   sendingPhoneNumberProfileID?: string|null,
     *   sendingWhatsappNumberProfileID?: string|null,
     *   shortName?: string|null,
     *   whatsappPhoneNumber?: string|null,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ProfileUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $profileID,
        array|ProfileUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v3/profiles/%1$s', $profileID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: ProfileUpdateResponse::class,
        );
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
     * @param array{xProfileID?: string}|ProfileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ProfileListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/profiles',
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: ProfileListResponse::class,
        );
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
     * @param array{sandbox?: bool, xProfileID?: string}|ProfileDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $profileID,
        array|ProfileDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['xProfileID' => 'x-profile-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/profiles/%1$s', $profileID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: null,
        );
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
     * @param array{
     *   webHookURL: string,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|ProfileCompleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileCompleteResponse>
     *
     * @throws APIException
     */
    public function complete(
        string $profileID,
        array|ProfileCompleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileCompleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/profiles/%1$s/complete', $profileID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: ProfileCompleteResponse::class,
        );
    }
}
