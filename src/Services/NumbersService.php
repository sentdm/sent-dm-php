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
 * What a phone number actually is, before you send to it.
 *
 * A lookup returns the number's country, line type and carrier, which is what decides whether it is reachable on a channel and what it costs. Worth doing on import rather than on send: a landline in a contact list is a message that can never be delivered.
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
