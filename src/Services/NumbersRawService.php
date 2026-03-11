<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Numbers\NumberLookupParams;
use SentDm\Numbers\NumberLookupResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\NumbersRawContract;

/**
 * Manage and lookup phone numbers.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class NumbersRawService implements NumbersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieves detailed information about a phone number including carrier, line type, porting status, and VoIP detection. Uses the customer's messaging provider for rich data, with fallback to the internal index.
     *
     * @param array{xProfileID?: string}|NumberLookupParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<NumberLookupResponse>
     *
     * @throws APIException
     */
    public function lookup(
        string $phoneNumber,
        array|NumberLookupParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = NumberLookupParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/numbers/lookup/%1$s', $phoneNumber],
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: NumberLookupResponse::class,
        );
    }
}
