<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Profiles\APIResponseOfProfileDetail;
use SentDm\Profiles\ProfileCompleteParams;
use SentDm\Profiles\ProfileCreateParams;
use SentDm\Profiles\ProfileDeleteParams;
use SentDm\Profiles\ProfileListResponse;
use SentDm\Profiles\ProfileUpdateParams;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ProfilesRawContract;

/**
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
     * @param array{
     *   allowContactSharing?: bool,
     *   allowTemplateSharing?: bool,
     *   billingModel?: string|null,
     *   description?: string|null,
     *   icon?: string|null,
     *   inheritContacts?: bool|null,
     *   inheritTcrBrand?: bool|null,
     *   inheritTcrCampaign?: bool|null,
     *   inheritTemplates?: bool|null,
     *   name?: string,
     *   shortName?: string|null,
     *   testMode?: bool,
     *   idempotencyKey?: string,
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
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

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
     * Retrieves detailed information about a specific sender profile within an organization.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfProfileDetail>
     *
     * @throws APIException
     */
    public function retrieve(
        string $profileID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/profiles/%1$s', $profileID],
            options: $requestOptions,
            convert: APIResponseOfProfileDetail::class,
        );
    }

    /**
     * @api
     *
     * Updates a profile's configuration and settings. Requires admin role in the organization. Only provided fields will be updated (partial update).
     *
     * @param string $profileID_ Path param
     * @param array{
     *   allowContactSharing?: bool|null,
     *   allowNumberChangeDuringOnboarding?: bool|null,
     *   allowTemplateSharing?: bool|null,
     *   billingModel?: string|null,
     *   description?: string|null,
     *   icon?: string|null,
     *   inheritContacts?: bool|null,
     *   inheritTcrBrand?: bool|null,
     *   inheritTcrCampaign?: bool|null,
     *   inheritTemplates?: bool|null,
     *   name?: string|null,
     *   profileID?: string,
     *   sendingPhoneNumber?: string|null,
     *   sendingPhoneNumberProfileID?: string|null,
     *   sendingWhatsappNumberProfileID?: string|null,
     *   shortName?: string|null,
     *   testMode?: bool,
     *   whatsappPhoneNumber?: string|null,
     *   idempotencyKey?: string,
     * }|ProfileUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfProfileDetail>
     *
     * @throws APIException
     */
    public function update(
        string $profileID_,
        array|ProfileUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v3/profiles/%1$s', $profileID_],
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
     * Retrieves all sender profiles within an organization. Profiles represent different brands, departments, or use cases within an organization, each with their own messaging configuration.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/profiles',
            options: $requestOptions,
            convert: ProfileListResponse::class,
        );
    }

    /**
     * @api
     *
     * Soft deletes a sender profile. The profile will be marked as deleted but data is retained. Requires admin role in the organization.
     *
     * @param array{profileID?: string, testMode?: bool}|ProfileDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $profileID_,
        array|ProfileDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/profiles/%1$s', $profileID_],
            headers: ['Content-Type' => '*/*'],
            body: (object) $parsed,
            options: $options,
            convert: null,
        );
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
     * @param array{
     *   webHookURL: string, testMode?: bool, idempotencyKey?: string
     * }|ProfileCompleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
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
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

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
            convert: 'mixed',
        );
    }
}
