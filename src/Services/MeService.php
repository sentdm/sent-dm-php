<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\Me\MeGetResponse;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\MeContract;

/**
 * Retrieve account details.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class MeService implements MeContract
{
    /**
     * @api
     */
    public MeRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MeRawService($client);
    }

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
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null
    ): MeGetResponse {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
