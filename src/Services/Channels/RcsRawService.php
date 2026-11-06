<?php

declare(strict_types=1);

namespace SentDm\Services\Channels;

use SentDm\Channels\Rcs\APIResponseOfRcsAgent;
use SentDm\Channels\Rcs\RcCreateParams;
use SentDm\Channels\Rcs\RcCreateParams\AgentUseCase;
use SentDm\Channels\Rcs\RcsAddress;
use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Channels\RcsRawContract;

/**
 * The senders you send from, one per channel.
 *
 * **SMS is a list of markets**, each keyed by `(country, number_type)` — a customer can hold `us/10dlc` and `gb/alphanumeric` at once, so a market is addressed by the pair rather than by country alone. **WhatsApp and RCS are single**: a customer has one business account and one agent. **Voice is per number**: each number you hold can carry phone calls on its own (`POST /v3/channels/voice`), each with the callback URL Sent asks what to do with its calls, one of them is the default line for calls placed from your app, and voice tokens are minted with `POST /v3/voice/tokens`. Read your voice numbers with `GET /v3/channels/voice` and change one with `PATCH /v3/channels/voice/{number}`.
 *
 * ## Compliance lives on the market
 *
 * Adding a market records everything that market registers with, in its `compliance` object. Only **US `TEN_DLC`** registers with a regime — The Campaign Registry — and it is the only market whose compliance carries `brand` and `campaign`. Everywhere else compliance is documents, and many markets ask for none at all.
 *
 * `GET` and `PATCH` on a market return and accept the same shape, so what comes back can be sent back: an omitted key is left alone, and a key reported in `requirements` is the path into the body that clears it.
 *
 * Call `GET /v3/compliance/requirements` first — it answers what a market demands before you hold it, with a body you can fill in and post.
 *
 * @phpstan-import-type RcsAddressShape from \SentDm\Channels\Rcs\RcsAddress
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class RcsRawService implements RcsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Asks for an RCS agent and records the order form the carriers vet it against. Always `202`: an agent is approved by the carriers, not by this call, and nothing here can make that happen sooner.
     *
     * ## What it asks for
     *
     * The RCS Agent Order Form — the same one our team fills in on your behalf today, so nothing has to be collected from you twice. **All fields are required** and must be submitted together so the carrier review has everything it needs. The only exception is `opt_in_screenshot_url`.
     *
     * **Agent identity:** `display_name`, `description`, `agent_use_case` (must be one of the accepted use cases; the error names the set), `brand_color` (six-digit hex, `#RRGGBB`).
     *
     * **Brand identity:** `brand_name` — the brand this agent presents. Not taken from `compliance.brand`: a business may present a different brand on RCS than the one its 10DLC registration is filed against, and the carriers vet this one. `privacy_policy_url`, `terms_and_conditions_url`, `website_url`, `logo_url`, and `banner_url` must be absolute `http(s)` URLs that the carriers can fetch without authentication. The form specifies 224×224 px and 50 KB for the logo and 1440×448 px and 200 KB for the banner; these cannot be checked without the image bytes.
     *
     * **Contact details:** `brand_phone_number`, `customer_support_phone_number`, `brand_email`, `customer_support_email`, `contact_name_and_title`.
     *
     * **Company:** `company_ein`, `entity_type`, `official_address` (street, city, state, postal_code, country), `brief_company_description`.
     *
     * **Consent and messages:** `opt_in_process_description`, `start_message`, `help_message`, `stop_message`, `sample_messages` (at least one example message).
     *
     * **Optional:** `opt_in_screenshot_url` (validated as an http(s) URL if supplied).
     *
     * Anything supplied is checked against accepted values rather than passed through: a value the provider rejects would otherwise surface days later, to somebody who cannot fix it without asking you.
     *
     * **A customer has one agent.** Asking again while you have one is `409`.
     *
     * ## What comes back, and what does not
     *
     * Returns **the agent** — the form as stored, plus `id` and `status`. Not your other channels, which this call cannot have changed.
     *
     * `status` is `PROVISIONING` until the agent is handed to the carriers and approved. **`GET /v3/channels` reports `rcs: null` until then** — a channel row is what routing reads to decide you are sendable, and writing one for an unapproved agent would claim a channel that cannot carry traffic.
     *
     * Send `x-profile-id` with an organization key to ask for one of your profiles' agents.
     *
     * @param array{
     *   agentUseCase?: AgentUseCase|value-of<AgentUseCase>,
     *   bannerURL?: string,
     *   brandColor?: string,
     *   brandEmail?: string,
     *   brandName?: string,
     *   brandPhoneNumber?: string,
     *   briefCompanyDescription?: string,
     *   companyEin?: string,
     *   contactNameAndTitle?: string,
     *   customerSupportEmail?: string,
     *   customerSupportPhoneNumber?: string,
     *   description?: string,
     *   displayName?: string,
     *   entityType?: string,
     *   helpMessage?: string,
     *   logoURL?: string,
     *   officialAddress?: RcsAddress|RcsAddressShape,
     *   optInProcessDescription?: string,
     *   optInScreenshotURL?: string|null,
     *   privacyPolicyURL?: string,
     *   sampleMessages?: list<string>,
     *   sandbox?: bool,
     *   startMessage?: string,
     *   stopMessage?: string,
     *   termsAndConditionsURL?: string,
     *   websiteURL?: string,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|RcCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfRcsAgent>
     *
     * @throws APIException
     */
    public function create(
        array|RcCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RcCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/channels/rcs',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfRcsAgent::class,
        );
    }
}
