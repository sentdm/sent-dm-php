<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Lookup\LookupGetPhoneInfoResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\LookupContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class LookupService implements LookupContract
{
    /**
     * @api
     */
    public LookupRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new LookupRawService($client);
    }

    /**
     * @api
     *
     * Validates a phone number and retrieves formatting, country, and timezone information from the internal index. Provider-agnostic and works for all customers.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrievePhoneInfo(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): LookupGetPhoneInfoResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrievePhoneInfo($phoneNumber, requestOptions: $requestOptions);

        return $response->parse();
    }
}
