<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Lookup\LookupGetPhoneInfoResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\LookupRawContract;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class LookupRawService implements LookupRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Validates a phone number and retrieves formatting, country, and timezone information from the internal index. Provider-agnostic and works for all customers.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LookupGetPhoneInfoResponse>
     *
     * @throws APIException
     */
    public function retrievePhoneInfo(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v3/lookup/number/%1$s', $phoneNumber],
            options: $requestOptions,
            convert: LookupGetPhoneInfoResponse::class,
        );
    }
}
