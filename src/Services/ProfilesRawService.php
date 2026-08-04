<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Profiles\APIResponseOfProfileDetail;
use SentDm\Profiles\BillingContactInfo;
use SentDm\Profiles\BrandsBrandData;
use SentDm\Profiles\PaymentDetails;
use SentDm\Profiles\ProfileCompleteParams;
use SentDm\Profiles\ProfileCompleteResponse;
use SentDm\Profiles\ProfileCreateParams;
use SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount;
use SentDm\Profiles\ProfileDeleteParams;
use SentDm\Profiles\ProfileListParams;
use SentDm\Profiles\ProfileListResponse;
use SentDm\Profiles\ProfileRetrieveParams;
use SentDm\Profiles\ProfileUpdateParams;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ProfilesRawContract;

/**
 * Manage organization profiles.
 *
 * @phpstan-import-type WhatsappBusinessAccountShape from \SentDm\Profiles\ProfileCreateParams\WhatsappBusinessAccount
 * @phpstan-import-type BillingContactInfoShape from \SentDm\Profiles\BillingContactInfo
 * @phpstan-import-type BrandsBrandDataShape from \SentDm\Profiles\BrandsBrandData
 * @phpstan-import-type PaymentDetailsShape from \SentDm\Profiles\PaymentDetails
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
     * @param array{
     *   allowContactSharing?: bool,
     *   allowTemplateSharing?: bool,
     *   billingContact?: BillingContactInfo|BillingContactInfoShape|null,
     *   billingModel?: string|null,
     *   brand?: BrandsBrandData|BrandsBrandDataShape|null,
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
     * @return BaseResponse<APIResponseOfProfileDetail>
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
            convert: APIResponseOfProfileDetail::class,
        );
    }

    /**
     * @api
     *
     * Retrieves detailed information about a specific sender profile within an organization, including brand and KYC information if a brand has been configured.
     *
     * @param array{xProfileID?: string}|ProfileRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfProfileDetail>
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
            convert: APIResponseOfProfileDetail::class,
        );
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
     * @param array{
     *   allowContactSharing?: bool|null,
     *   allowNumberChangeDuringOnboarding?: bool|null,
     *   allowTemplateSharing?: bool|null,
     *   billingContact?: BillingContactInfo|BillingContactInfoShape|null,
     *   billingModel?: string|null,
     *   brand?: BrandsBrandData|BrandsBrandDataShape|null,
     *   description?: string|null,
     *   icon?: string|null,
     *   inheritContacts?: bool|null,
     *   inheritTcrBrand?: bool|null,
     *   inheritTcrCampaign?: bool|null,
     *   inheritTemplates?: bool|null,
     *   name?: string|null,
     *   paymentDetails?: PaymentDetails|PaymentDetailsShape|null,
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
     * @return BaseResponse<APIResponseOfProfileDetail>
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
            convert: APIResponseOfProfileDetail::class,
        );
    }

    /**
     * @api
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
     * @api
     *
     * Soft deletes a sender profile. The profile will be marked as deleted but data is retained. Requires admin role in the organization.
     *
     * @param string $profileID Path param
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
     * @api
     *
     * Final step in the profile compliance workflow. Validates all prerequisites (KYC, brand, campaigns, required documents), connects the profile to the SMS and WhatsApp channels, and sets its status based on configuration. Prerequisites are always validated first: if any fail the call returns 400. If they pass and the profile is already completed, the call returns 200 and does nothing. Otherwise it returns 202 and calls the provided webhook URL when background processing finishes.
     *
     * Prerequisites:
     * - Profile must have a name, short name, and description (short name max 50 characters, description max 5000)
     * - webHookUrl must be supplied on the request
     * - A KYC form submission is required
     * - A brand is required, either on the profile or inherited from the parent organization
     * - TCR applications must have at least one campaign, own or inherited
     * - Destination countries marked as main must have their required compliance documents uploaded
     *
     * Resulting status:
     * - If either the SMS or WhatsApp channel is unconfigured, the profile is SUBMITTED
     * - For a TCR application that inherits both its brand and its campaigns, the profile is COMPLETED
     * - For a TCR application that owns either its brand or its campaigns, the profile is COMPLETED once both have been submitted to TCR, and SUBMITTED until then
     * - For a non-TCR application, the profile is SUBMITTED when a main destination country is set, and COMPLETED otherwise
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
