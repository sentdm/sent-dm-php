<?php

declare(strict_types=1);

namespace SentDm\Services\Channels;

use SentDm\Channels\Rcs\APIResponseOfRcsAgent;
use SentDm\Channels\Rcs\RcCreateParams\AgentUseCase;
use SentDm\Channels\Rcs\RcsAddress;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Channels\RcsContract;

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
final class RcsService implements RcsContract
{
    /**
     * @api
     */
    public RcsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RcsRawService($client);
    }

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
     * @param AgentUseCase|value-of<AgentUseCase> $agentUseCase Body param: Which kind of traffic the agent carries. One of the accepted use cases; the error names the set.
     * @param string $bannerURL Body param
     * @param string $brandColor Body param: Primary brand colour, as #RRGGBB. Three-digit shorthand is refused: the value is submitted
     * verbatim, so two spellings of one colour is only a way for the stored value to disagree with the form.
     * @param string $brandEmail Body param
     * @param string $brandName Body param: The brand this agent presents over RCS.
     *
     * Not taken from your compliance.brand: a business may present a different brand on RCS than
     * the one its 10DLC registration is filed against, and the carriers vet this one.
     * @param string $brandPhoneNumber Body param: The brand's own number. Also becomes the agent's canonical sending number for routing, which is why it
     * is normalised to E.164 rather than stored as sent.
     * @param string $briefCompanyDescription Body param
     * @param string $companyEin Body param
     * @param string $contactNameAndTitle Body param
     * @param string $customerSupportEmail Body param
     * @param string $customerSupportPhoneNumber Body param
     * @param string $description Body param: What the agent is for, shown to recipients. Capped by the carriers, not by us.
     * @param string $displayName body param: The name the agent shows in the messaging client
     * @param string $entityType Body param
     * @param string $helpMessage Body param
     * @param string $logoURL Body param: Publicly reachable logo. It has to be fetchable without authentication at review time, so a URL behind
     * a login passes this call and fails the review.
     * @param RcsAddress|RcsAddressShape $officialAddress body param: The registered address of the company behind the agent
     * @param string $optInProcessDescription Body param: How recipients opt in, in prose. The carriers read this one.
     * @param string|null $optInScreenshotURL body param: A screenshot of the opt-in, as a publicly fetchable URL
     * @param string $privacyPolicyURL Body param: Required by US carriers. Must be an absolute http(s) URL they can fetch.
     * @param list<string> $sampleMessages body param: Examples of what the agent will send, for the review
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $startMessage Body param
     * @param string $stopMessage Body param
     * @param string $termsAndConditionsURL Body param
     * @param string $websiteURL body param: The brand's own site
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        AgentUseCase|string|null $agentUseCase = null,
        ?string $bannerURL = null,
        ?string $brandColor = null,
        ?string $brandEmail = null,
        ?string $brandName = null,
        ?string $brandPhoneNumber = null,
        ?string $briefCompanyDescription = null,
        ?string $companyEin = null,
        ?string $contactNameAndTitle = null,
        ?string $customerSupportEmail = null,
        ?string $customerSupportPhoneNumber = null,
        ?string $description = null,
        ?string $displayName = null,
        ?string $entityType = null,
        ?string $helpMessage = null,
        ?string $logoURL = null,
        RcsAddress|array|null $officialAddress = null,
        ?string $optInProcessDescription = null,
        ?string $optInScreenshotURL = null,
        ?string $privacyPolicyURL = null,
        ?array $sampleMessages = null,
        ?bool $sandbox = null,
        ?string $startMessage = null,
        ?string $stopMessage = null,
        ?string $termsAndConditionsURL = null,
        ?string $websiteURL = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfRcsAgent {
        $params = Util::removeNulls(
            [
                'agentUseCase' => $agentUseCase,
                'bannerURL' => $bannerURL,
                'brandColor' => $brandColor,
                'brandEmail' => $brandEmail,
                'brandName' => $brandName,
                'brandPhoneNumber' => $brandPhoneNumber,
                'briefCompanyDescription' => $briefCompanyDescription,
                'companyEin' => $companyEin,
                'contactNameAndTitle' => $contactNameAndTitle,
                'customerSupportEmail' => $customerSupportEmail,
                'customerSupportPhoneNumber' => $customerSupportPhoneNumber,
                'description' => $description,
                'displayName' => $displayName,
                'entityType' => $entityType,
                'helpMessage' => $helpMessage,
                'logoURL' => $logoURL,
                'officialAddress' => $officialAddress,
                'optInProcessDescription' => $optInProcessDescription,
                'optInScreenshotURL' => $optInScreenshotURL,
                'privacyPolicyURL' => $privacyPolicyURL,
                'sampleMessages' => $sampleMessages,
                'sandbox' => $sandbox,
                'startMessage' => $startMessage,
                'stopMessage' => $stopMessage,
                'termsAndConditionsURL' => $termsAndConditionsURL,
                'websiteURL' => $websiteURL,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
