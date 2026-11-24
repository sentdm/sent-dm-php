<?php

declare(strict_types=1);

namespace SentDm\Services\Channels;

use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\Markets\APIResponseOfListOfChannelMarket;
use SentDm\Channels\Markets\APIResponseOfMarketNumbers;
use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Channels\SMS\SMSNumberRequest;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Channels\MarketsContract;

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
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 */
final class MarketsService implements MarketsContract
{
    /**
     * @api
     */
    public MarketsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MarketsRawService($client);
    }

    /**
     * @api
     *
     * Reads one market you send in — its sender, where that sender stands, and everything its compliance holds.
     *
     * ## What `compliance` carries
     *
     * A market that registers with a compliance regime reports `brand` — the identity the registration is filed against — and `campaign`, the programme filed against it. Each carries `inherit`, saying whether it is yours or your organization's.
     *
     * `compliance.brand.vetting` is the brand's external vetting at The Campaign Registry, read-only: `score` (0-100, the figure US carriers set 10DLC throughput by), `status` (`PENDING`, `UNSCORE`, `ACTIVE`, `FAILED` or `EXPIRED`; carriers read the score of an `ACTIVE` vet only), `vetted_at` and `expires_at`. It is `null` while no vetting record is held for the brand, and `score` is `null` for a vet that has none yet. A profile on your organization's brand reads your organization's vetting.
     *
     * A market that registers with nobody has neither, so **both keys are absent** rather than null: absent says this market does not ask, where null would say it asks and you supplied nothing. It reports `documents` instead.
     *
     * `GET /v3/compliance/requirements` says what a market demands of any new customer; this says what you gave it.
     *
     * ## Writing it back
     *
     * **`PATCH` this same path**, with the `compliance` object from this response:
     *
     * ```json
     * { "compliance": { "brand": { "tax_id": "12-3456789" } } }
     * ```
     *
     * Nothing else to learn — what comes back can be sent back, an omitted key is left alone. There is no sub-resource for either half: both are singletons of the market, so both are written here.
     *
     * `GET /v3/compliance/requirements` says what a market demands of anybody; this says what you gave it.
     *
     * Send `x-profile-id` with an organization key to read one of your profiles' markets.
     *
     * @param string $type Path param: Sender type: local, mobile, 10dlc (or ten_dlc), toll_free, short_code, alphanumeric. Matched ignoring case.
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until they have markets
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. us
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $type,
        string $channel,
        string $country,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'country' => $country,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($type, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Supplies the market's identity and documents, and answers with the market as stored — the same shape `GET` on this path returns.
     *
     * | To change | Send |
     * | --- | --- |
     * | a `brand` value (US `TEN_DLC`) | `compliance.brand`, as below |
     * | a registration sent back for correction | `compliance.brand` — the identity is accepted even once filed, and the registration goes back for review |
     * | a document, in any market | a multipart file named after the document's key |
     * | a campaign | `PATCH /v3/channels/sms/US/TEN_DLC/campaigns/{id}` — `compliance.campaign` here is `400` |
     * | the numbers | `POST /v3/channels/{channel}/{country}/{type}/numbers` — `numbers` here is `400` |
     *
     * ## Partial, at every level
     *
     * **An omitted key is left alone. An explicit `null` clears it.** Those are different requests, so `{}` changes nothing and is refused rather than silently accepted, and correcting one field does not blank the others.
     *
     * ```json
     * { "compliance": { "brand": { "contact_phone": "+12125550123" } } }
     * ```
     *
     * | Body | Effect |
     * | --- | --- |
     * | `"brand": { … }` | supplies or corrects the identity, and takes one of your own |
     * | `"brand": { "inherit": true }` | runs on your organization's, giving up your own |
     * | `"brand": null` | the same thing, said the short way |
     * | key omitted | left exactly as it is |
     *
     * The brand read on this path, its `id` and `vetting` included, can be sent back unchanged: both are read-only and ignored.
     *
     * ## Every other market
     *
     * Markets that register with no regime have no brand, so `compliance` is `400` there. Their compliance is documents, sent here as multipart.
     *
     * ## Documents
     *
     * Send `multipart/form-data` with **each file named after the compliance key it satisfies** — the key `GET /v3/channels/{channel}/{country}/compliance` lists. A file that matches no document the market asks for is `400` naming the keys that would, and a file the upload rules refuse (empty, too large, an unsupported type) is `422`. `compliance` may ride in the same form as a text part holding its JSON.
     *
     * ## What it will refuse
     *
     * **A filed identity is `409`.** Once the registration has gone to The Campaign Registry they hold a copy, and a local change would diverge from it silently. The exception is a registration sent back for correction: the identity is accepted, and the registration goes back for review. Refiling it with The Campaign Registry stays with Sent.
     *
     * Nothing is submitted to a regime here. Send `x-profile-id` with an organization key to write one of your profiles' markets.
     *
     * @param string $type Path param: Sender type, e.g. 10dlc (or ten_dlc), local or alphanumeric. Only 10dlc in us declares a brand.
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until they have markets
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. us
     * @param MarketCompliance|MarketComplianceShape $compliance Body param: The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     * @param bool $sandbox Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $type,
        string $channel,
        string $country,
        MarketCompliance|array|null $compliance = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'country' => $country,
                'compliance' => $compliance,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($type, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Every market you send SMS in, each with its sender, where that sender stands, and what its compliance holds.
     *
     * The same entries `GET /v3/channels` reports under `sms`, and the same shape `GET /v3/channels/sms/{country}/{type}` returns for one of them — so a list, a member read and the all-channels read cannot describe a market differently.
     *
     * Send `x-profile-id` with an organization key to list one of your profiles' markets.
     *
     * @param string $channel The channel: `sms`. Other channels are `501` until they have markets
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $channel,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfListOfChannelMarket {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($channel, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Adds numbers to a market you hold. They are **added** to what it already asks for, never replacing it — with one exception: a US `TEN_DLC` campaign opened without `numbers` asks for one number in any area code by default, and while it holds no number yet, the first numbers added replace that default. Once it holds one, they are added beside it.
     *
     * ## Where they go
     *
     * - **SMS US `TEN_DLC`**: to **one campaign of your own**, named by `campaign_id` — the `id` of an entry in the market's `compliance.campaigns` (`GET /v3/channels/sms/US/TEN_DLC`). Required: left out it is `400` naming your campaigns in service. One you inherit from your organization is `400`: its numbers are the organization's. One out of service — expired, deactivated or released — is `409`. A campaign the carriers have not approved yet gets its numbers when they do; an approved one gets them now. With everything it asks for, a campaign holds at most 49 numbers, counting one for each sender profile inheriting it.
     * - **`LOCAL`**: to the market, claimed from inventory now; what inventory cannot cover stays pending. No `campaign_id`. A market holds at most 49 numbers.
     * - **Any other sender type** takes no numbers: `400`.
     *
     * ## What to send
     *
     * `numbers` — the list `POST /v3/channels/sms` takes, one entry per area code — and, on US `TEN_DLC`, `campaign_id`, required.
     *
     * Until a number is assigned it reads as `PROVISIONING` in the market's `numbers`, with the area code it was asked for. Returns **the market**, in the shape `GET /v3/channels/sms/{country}/{type}` returns, with `202`.
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`) or `local`
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until their numbers are available
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. `US`
     * @param list<SMSNumberRequest|SMSNumberRequestShape|null> $numbers Body param: The numbers, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * POST adds them to what the market or campaign already asks for; PATCH replaces that list
     * with them, and has to cover every number already held, since none is ever released.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string|null $campaignID Body param: The campaign to add the numbers to, as campaigns[].id reports it. Required on SMS US TEN_DLC,
     * where every number belongs to a campaign; refused on a market without campaigns.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function addNumbers(
        string $type,
        string $channel,
        string $country,
        array $numbers,
        string $idempotencyKey,
        ?string $campaignID = null,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'country' => $country,
                'numbers' => $numbers,
                'idempotencyKey' => $idempotencyKey,
                'campaignID' => $campaignID,
                'sandbox' => $sandbox,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->addNumbers($type, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Every number you hold in one market (country and sender type): `ACTIVE` once it can send, `PROVISIONING` while it is still to be assigned (it then has no `sender_value` yet), `INACTIVE` once it could send and no longer can. US `TEN_DLC` numbers name their `campaign_id`, and `?campaign_id=` keeps one campaign's.
     *
     * A market you do not hold is `404`. Add numbers with `POST` on the same path.
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`), `local`, `mobile`, `toll_free`, `short_code`, `alphanumeric`
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until their numbers are available
     * @param string $country Path param: ISO 3166-1 country code, e.g. `US`
     * @param string|null $campaignID query param: Only the numbers of this campaign (US TEN_DLC); all of the market's when absent
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listNumbers(
        string $type,
        string $channel,
        string $country,
        ?string $campaignID = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfMarketNumbers {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'country' => $country,
                'campaignID' => $campaignID,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listNumbers($type, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Replaces the numbers a market you hold asks for — their area codes and counts — with the list you send. To add to them instead, use `POST` on this path.
     *
     * ## Whose numbers
     *
     * - **SMS US `TEN_DLC`**: **one campaign of your own**, named by `campaign_id` — the `id` of an entry in the market's `compliance.campaigns`. Required. So a campaign sent back for correction can change its area codes without being recreated. One you inherit from your organization is `400`; one out of service is `409`. With everything it asks for, a campaign holds at most 49 numbers, counting one for each sender profile inheriting it.
     * - **`LOCAL`**: the market's own, claimed from inventory now; what inventory cannot cover stays pending. No `campaign_id`.
     * - **Any other sender type** takes no numbers: `400`.
     *
     * ## What to send
     *
     * `numbers` — the list `POST /v3/channels/sms` takes, one entry per area code, an entry without `area_code` meaning any — and, on US `TEN_DLC`, `campaign_id`.
     *
     * **Numbers already assigned are kept.** Nothing is released here, so a list that no longer covers a number already held is `400`, naming how many it leaves out. Lowering a count nothing has filled yet is fine.
     *
     * Until a number is assigned it reads as `PROVISIONING` in the market's `numbers`, with the area code it was asked for. Returns **the market**, in the shape `GET /v3/channels/sms/{country}/{type}` returns.
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`) or `local`
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until their numbers are available
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. `US`
     * @param list<SMSNumberRequest|SMSNumberRequestShape|null> $numbers Body param: The numbers, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * POST adds them to what the market or campaign already asks for; PATCH replaces that list
     * with them, and has to cover every number already held, since none is ever released.
     * @param string|null $campaignID Body param: The campaign to add the numbers to, as campaigns[].id reports it. Required on SMS US TEN_DLC,
     * where every number belongs to a campaign; refused on a market without campaigns.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function replaceNumbers(
        string $type,
        string $channel,
        string $country,
        array $numbers,
        ?string $campaignID = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'country' => $country,
                'numbers' => $numbers,
                'campaignID' => $campaignID,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->replaceNumbers($type, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
