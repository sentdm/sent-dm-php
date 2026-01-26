<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
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
     * @param array{phoneNumber: string}|NumberLookupRetrieveParams $params
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v2/number-lookup',
            query: $parsed,
            options: $options,
            convert: NumberLookupGetResponse::class,
        );
    }
}
