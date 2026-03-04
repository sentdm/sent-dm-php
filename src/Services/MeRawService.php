<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Me\MeGetResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\MeRawContract;

/**
 * Retrieve account details.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class MeRawService implements MeRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Returns the account associated with the API key. For organization API keys, returns the organization with its profiles. For profile API keys, returns the profile with its settings.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MeGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/me',
            options: $requestOptions,
            convert: MeGetResponse::class,
        );
    }
}
