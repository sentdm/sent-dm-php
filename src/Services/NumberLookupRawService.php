<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\NumberLookup\NumberLookupGetResponse;
use SentDm\NumberLookup\NumberLookupRetrieveParams;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\NumberLookupRawContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class NumberLookupRawService implements NumberLookupRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieves detailed information about a phone number including validation, formatting, country information, and available messaging channels. The customer ID is extracted from the authentication token.
     *
     * @param array{
     *   phoneNumber: string, xAPIKey: string, xSenderID: string
     * }|NumberLookupRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<NumberLookupGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        array|NumberLookupRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = NumberLookupRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['phoneNumber']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v2/number-lookup',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['xAPIKey' => 'x-api-key', 'xSenderID' => 'x-sender-id']
            ),
            options: $options,
            convert: NumberLookupGetResponse::class,
        );
    }
}
