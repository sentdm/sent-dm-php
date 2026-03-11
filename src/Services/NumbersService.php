<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Numbers\NumberLookupResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\NumbersContract;

/**
 * Manage and lookup phone numbers.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class NumbersService implements NumbersContract
{
    /**
     * @api
     */
    public NumbersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new NumbersRawService($client);
    }

    /**
     * @api
     *
     * Retrieves detailed information about a phone number including carrier, line type, porting status, and VoIP detection. Uses the customer's messaging provider for rich data, with fallback to the internal index.
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function lookup(
        string $phoneNumber,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): NumberLookupResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->lookup($phoneNumber, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
