<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Me\MeGetResponse;
use SentDm\Me\MeRetrieveParams;
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
     * Returns the account associated with the provided API key. The response includes account identity, contact information, messaging channel configuration, and — depending on the account type — either a list of child profiles or the profile's own settings.
     *
     * **Account types:**
     * - `organization` — Has child profiles. The `profiles` array is populated.
     * - `user` — Standalone account with no profiles.
     * - `profile` — Child of an organization. Includes `organization_id`, `short_name`, `status`, and `settings`.
     *
     * **Channels:**
     * The `channels` object always includes `sms`, `whatsapp`, and `rcs`. Each channel has a `configured` boolean. Configured channels expose additional details such as `phone_number`.
     *
     * @param array{xProfileID?: string}|MeRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MeGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        array|MeRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MeRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/me',
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: MeGetResponse::class,
        );
    }
}
