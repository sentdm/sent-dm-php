<?php

declare(strict_types=1);

namespace SentDm\Services\Brands;

use SentDm\Brands\Campaigns\APIResponseTcrCampaignWithUseCases;
use SentDm\Brands\Campaigns\CampaignCreateParams;
use SentDm\Brands\Campaigns\CampaignData;
use SentDm\Brands\Campaigns\CampaignDeleteParams;
use SentDm\Brands\Campaigns\CampaignDeleteParams\Body;
use SentDm\Brands\Campaigns\CampaignListResponse;
use SentDm\Brands\Campaigns\CampaignUpdateParams;
use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Brands\CampaignsRawContract;

/**
 * @phpstan-import-type BodyShape from \SentDm\Brands\Campaigns\CampaignDeleteParams\Body
 * @phpstan-import-type CampaignDataShape from \SentDm\Brands\Campaigns\CampaignData
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
     * Creates a new campaign scoped under a specific brand. The campaign is linked to the specified brand. Each campaign must include at least one use case with sample messages.
     *
     * @param string $brandID Path param: Brand ID from route
     * @param array{
     *   campaign: CampaignData|CampaignDataShape,
     *   testMode?: bool,
     *   idempotencyKey?: string,
     * }|CampaignCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTcrCampaignWithUseCases>
     *
     * @throws APIException
     */
    public function create(
        string $brandID,
        array|CampaignCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CampaignCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v3/brands/%1$s/campaigns', $brandID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseTcrCampaignWithUseCases::class,
        );
    }

    /**
     * @api
     *
     * Updates an existing campaign scoped under a specific brand. Cannot update campaigns that have already been submitted to TCR.
     *
     * @param string $campaignID Path param: Campaign ID from route
     * @param array{
     *   brandID: string,
     *   campaign: CampaignData|CampaignDataShape,
     *   testMode?: bool,
     *   idempotencyKey?: string,
     * }|CampaignUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseTcrCampaignWithUseCases>
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
        $brandID = $parsed['brandID'];
        unset($parsed['brandID']);
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['v3/brands/%1$s/campaigns/%2$s', $brandID, $campaignID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['brandID']),
            ),
            options: $options,
            convert: APIResponseTcrCampaignWithUseCases::class,
        );
    }

    /**
     * @api
     *
     * Retrieves all campaigns linked to a specific brand, including their use cases and sample messages.
     *
     * @param string $brandID Brand ID from route
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CampaignListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $brandID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/brands/%1$s/campaigns', $brandID],
            options: $requestOptions,
            convert: CampaignListResponse::class,
        );
    }

    /**
     * @api
     *
     * Deletes a campaign by ID within a specific brand. The brand must belong to the authenticated customer.
     *
     * @param string $campaignID Path param: Campaign ID from route parameter
     * @param array{brandID: string, body: Body|BodyShape}|CampaignDeleteParams $params
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
        $brandID = $parsed['brandID'];
        unset($parsed['brandID']);

        /** @var array<string,mixed> */
        $body = $parsed['body'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v3/brands/%1$s/campaigns/%2$s', $brandID, $campaignID],
            headers: ['Content-Type' => '*/*'],
            body: (object) array_diff_key($body, array_flip(['brandID'])),
            options: $options,
            convert: null,
        );
    }
}
