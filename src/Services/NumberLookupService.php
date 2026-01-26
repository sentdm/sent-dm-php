<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\NumberLookup\NumberLookupGetResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\NumberLookupContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class NumberLookupService implements NumberLookupContract
{
    /**
     * @api
     */
    public NumberLookupRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new NumberLookupRawService($client);
    }

    /**
     * @api
     *
     * Retrieves detailed information about a phone number including validation, formatting, country information, and available messaging channels. The customer ID is extracted from the authentication token.
     *
     * @param string $phoneNumber Query param
     * @param string $xAPIKey Header param
     * @param string $xSenderID Header param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $phoneNumber,
        string $xAPIKey,
        string $xSenderID,
        RequestOptions|array|null $requestOptions = null,
    ): NumberLookupGetResponse {
        $params = Util::removeNulls(
            [
                'phoneNumber' => $phoneNumber,
                'xAPIKey' => $xAPIKey,
                'xSenderID' => $xSenderID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
