<?php

declare(strict_types=1);

namespace SentDm\Services\Profiles;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Profiles\Campaigns\APIResponseOfTcrCampaignWithUseCases;
use SentDm\Profiles\Campaigns\CampaignCreateParams;
use SentDm\Profiles\Campaigns\CampaignData;
use SentDm\Profiles\Campaigns\CampaignDeleteParams;
use SentDm\Profiles\Campaigns\CampaignListParams;
use SentDm\Profiles\Campaigns\CampaignListResponse;
use SentDm\Profiles\Campaigns\CampaignUpdateParams;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Profiles\CampaignsRawContract;

/**
 * Manage organization profiles.
 *
 * @phpstan-import-type CampaignDataShape from \SentDm\Profiles\Campaigns\CampaignData
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class CampaignsRawService implements CampaignsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Creates a new campaign scoped under the brand of the specified profile. Each campaign must include at least one use case with sample messages.
     *
     * @param string $profileID Path param: Profile ID from route
     * @param array{
     *   campaign: CampaignData|CampaignDataShape,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|CampaignCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfTcrCampaignWithUseCases>
     *
     * @throws APIException
     */
    public function create(
        string $profileID,
        array|CampaignCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CampaignCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/profiles/%1$s/campaigns', $profileID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfTcrCampaignWithUseCases::class,
        );
    }

    /**
     * @api
     *
     * Updates an existing campaign under the brand of the specified profile. Cannot update campaigns that have already been submitted to TCR.
     *
     * @param string $campaignID Path param: Campaign ID from route
     * @param array{
     *   profileID: string,
     *   campaign: CampaignData|CampaignDataShape,
     *   sandbox?: bool,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|CampaignUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfTcrCampaignWithUseCases>
     *
     * @throws APIException
     */
    public function update(
        string $campaignID,
        array|CampaignUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CampaignUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $profileID = $parsed['profileID'];
        unset($parsed['profileID']);
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['v3/profiles/%1$s/campaigns/%2$s', $profileID, $campaignID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['profileID']),
            ),
            options: $options,
            convert: APIResponseOfTcrCampaignWithUseCases::class,
        );
    }

    /**
     * @api
     *
     * Retrieves all campaigns linked to the profile's brand, including use cases and sample messages. Returns inherited campaigns if inherit_tcr_campaign=true.
     *
     * @param string $profileID Profile ID from route
     * @param array{xProfileID?: string}|CampaignListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $profileID,
        array|CampaignListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CampaignListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/profiles/%1$s/campaigns', $profileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: CampaignListResponse::class,
        );
    }

    /**
     * @api
     *
     * Deletes a campaign by ID from the brand of the specified profile. The profile must belong to the authenticated organization.
     *
     * @param string $campaignID Path param: Campaign ID from route parameter
     * @param array{
     *   profileID: string, sandbox?: bool, xProfileID?: string
     * }|CampaignDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $campaignID,
        array|CampaignDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CampaignDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $profileID = $parsed['profileID'];
        unset($parsed['profileID']);
        $header_params = ['xProfileID' => 'x-profile-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/profiles/%1$s/campaigns/%2$s', $profileID, $campaignID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['profileID']),
            ),
            options: $options,
            convert: null,
        );
    }
}
