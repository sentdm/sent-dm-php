<?php

declare(strict_types=1);

namespace SentDm\Services\Channels;

use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Channels\SMS\SMSCreateParams\NumberType;
use SentDm\Channels\SMS\SMSNumberRequest;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Channels\SMSContract;
use SentDm\Services\Channels\SMS\TenDlcService;

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
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class SMSService implements SMSContract
{
    /**
     * @api
     */
    public SMSRawService $raw;

    /**
     * @api
     */
    public TenDlcService $tenDlc;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SMSRawService($client);
        $this->tenDlc = new TenDlcService($client);
    }

    /**
     * @api
     *
     * Gives the customer a sender in one country — the first market it sends in, and the fifth. Two addresses, one call: `POST /v3/channels/sms` with `country` and `number_type` in the body, or `POST /v3/channels/sms/{country}/{type}` with the market as the path (the path wins over the body).
     *
     * ## What to have in place first
     *
     * **Call `GET /v3/channels/sms/{country}/compliance` first.** It lists every sender type the country offers and, for each, the compliance values and documents to send, with their formats and options. You never have to track forty countries' rules yourself.
     *
     * **A market that registers with a compliance regime needs an identity, and this call takes one.** US `TEN_DLC` registers with The Campaign Registry and files that registration against a business identity. Send it in `compliance.brand` and it is recorded here, before the registration that attaches to it — so a customer with no identity reaches a first 10DLC market in one call.
     *
     * `{ "inherit": true }` runs on your organization's instead. A market with neither — none stored, none sent — is `400`, because accepting it would write a channel that could never register and leave it provisioning for ever with nothing saying why.
     *
     * **Everything the regime wants arrives in this request's `compliance`**, as two declared objects: `brand` — the identity the registration is filed against — and `campaign`, with the use case, the consent narrative, the volume, the sample messages and the keywords. There is nothing to set up first. Nothing is submitted here either: the rows are what a submission is later assembled from, and filing is externally rejectable so it happens on its own path.
     *
     * **Your own brand has to be complete here.** It must carry every field the regime asks of it, counting what you already hold — send the rest in this request. A missing one is `400` naming each field, rather than a `202` for a market that could never be filed. A brand you inherit is asked for nothing.
     *
     * **A campaign of your own is optional here.** Sent, it has to be complete in the same way, and the `numbers` you ask for go on it. Omitted, no campaign is written and `numbers` and `area_codes` are refused (`400`), because numbers belong to a campaign: the market reads `ACTION_NEEDED` until you add one with `POST /v3/channels/sms/US/TEN_DLC/campaigns`, then its numbers with `POST /v3/channels/sms/US/TEN_DLC/numbers`.
     *
     * A market that registers with nobody — an alphanumeric sender in most countries — needs neither, and may need documents instead.
     *
     * ## Sending it
     *
     * Takes the same fields `channels.sms` takes on `POST /v3/sender-profiles`, because it is the same work, and both run one provisioning path. `compliance` is top-level and answers for the market in this request, carrying `brand` and `campaign` where the market registers.
     *
     * **Accepts multipart as well as JSON**, with each file named after the compliance key it satisfies — a market that pre-registers its sender needs its documents at the same moment it needs the sender. Every required document must be attached to this request; a missing or invalid file is rejected before the market is added.
     *
     * **`area_codes` puts the sender somewhere specific**, in your order of preference, for a `LOCAL` sender in any country or a US `TEN_DLC` sender — a 10DLC number is an ordinary local long code bound to a registered campaign, so both take the same codes out of the same inventory. It is honoured exactly: you get a number in one of the codes you named or you get none, never one in a code you left out.
     *
     * ## Several numbers
     *
     * **`numbers` lists the numbers you want, one entry per area code**, e.g. `[{"area_code": "212", "quantity": 2}, {"quantity": 1}]` for two numbers in 212 and one in any area code. `quantity` defaults to 1, and an entry without `area_code` means any area code. Omit `numbers` for one number. It is for `LOCAL` and `TEN_DLC` only and cannot be combined with `area_codes`. A market holds at most 49 numbers.
     *
     * US `TEN_DLC` numbers belong to the market's campaign and are assigned when the campaign is approved, not at request time. Until then they read as `PROVISIONING` in the response's `numbers`, each with the area code it was asked for. A profile inheriting your organization's campaign cannot request `numbers` (`400`).
     *
     * **This call opens a market once. A market you already hold is `409`**, with a sender or still waiting for one, and nothing is added to it here: change its compliance with `PATCH /v3/channels/sms/{country}/{type}`, add numbers (and their area codes) with `POST /v3/channels/sms/{country}/{type}/numbers`, and on US `TEN_DLC` add a campaign with `POST /v3/channels/sms/US/TEN_DLC/campaigns`. The `409` names them. A market is a `(country, sender_type)` pair, so a **second sender type in a country you already send in is fine** — `US TOLL_FREE` alongside `US TEN_DLC` is the ordinary case. Two of the same type is not.
     *
     * One exception: while a market's sender type is still unassigned, adding any type to that country is `409`, because the market you have may be about to become the one you asked for.
     *
     * Returns **the market**, in the shape `GET` and `PATCH` on `/v3/channels/sms/{country}/{type}` use — so what this answers can be read back and written back without reshaping. Not every channel you have: adding a market cannot change an RCS agent or a WhatsApp account, and `GET /v3/channels` is the whole picture. `201` when the market is ready; `202` while a sender or a registration is still outstanding.
     *
     * Send `x-profile-id` with an organization key to add a market to one of your profiles.
     *
     * @param NumberType|value-of<NumberType> $numberType Body param: Sender type. Decides the provisioning flow and what compliance is asked for.
     *
     * [Required] so the published document says so. The validator has always demanded it, but
     * requiredness reached the schema by matching a rule to a property name — which works for country,
     * whose wire name is its camel-cased C# name, and silently does not for number_type. A client
     * generating a request from our OpenAPI therefore sent what the document called sufficient and was
     * answered 400.
     * @param list<string>|null $areaCodes Body param: The area codes to put this sender in, in your own order of preference, e.g. ["415", "628"]
     * for the US or ["20"] for London. Omit it and a number is claimed anywhere in the country.
     *
     * Ordered, and the order is the request. The claim tries each code in turn and stops at the
     * first that yields a number. Nothing sorts the list and a code listed twice is refused.
     *
     * One to fifty entries, each the area code as digits: 415, with the trunk prefix as
     * 020, or with the country's dialing prefix as +1415 (all are stored as the bare code). A
     * dialing prefix from a different country than country is refused. Each code is checked against
     * the country's numbering plan: it must start real local or mobile numbers there, so toll-free and
     * premium ranges, service codes and another country's codes are refused with a reason.
     *
     * LOCAL senders in any country, and US TEN_DLC senders. No other sender type
     * has a geographic area code, and the list is refused with one rather than accepted and dropped.
     *
     * Honoured exactly or not at all. Ask for 415 and you get a 415 number or you
     * get none, never a neighbouring code you did not name. A miss leaves the market with no sender yet and
     * the codes recorded on it, so it is filled when stock appears rather than filled now from somewhere else.
     * Many countries outside North America require address or business documents before a local number can
     * be bought, which can delay or prevent the fill.
     * @param MarketCompliance|MarketComplianceShape $compliance Body param: The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     * @param list<SMSNumberRequest|SMSNumberRequestShape>|null $numbers Body param: The numbers to assign, one entry per area code, e.g.
     * [{"area_code": "212", "quantity": 2}, {"area_code": "415"}, {"quantity": 1}]: two numbers in 212,
     * one in 415 and one in any area code. quantity defaults to 1, and an entry without
     * area_code means any area code. Omit numbers for one number.
     *
     * Only with LOCAL or TEN_DLC, and not together with area_codes. Each area code is
     * validated against country the same way area_codes is and may appear once, and at most one
     * entry may leave area_code out. On a LOCAL market you already hold, this adds the numbers to
     * it. US TEN_DLC numbers are assigned when the campaign is approved, not at request time. Not
     * available when the profile inherits the organization's campaign.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $senderValue Body param: The sender's identity where the caller chooses it. Required when number_type is
     * ALPHANUMERIC; optional for carrier-assigned types, which are procured afterwards.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        NumberType|string $numberType,
        ?array $areaCodes = null,
        MarketCompliance|array|null $compliance = null,
        ?array $numbers = null,
        ?bool $sandbox = null,
        ?string $senderValue = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket {
        $params = Util::removeNulls(
            [
                'numberType' => $numberType,
                'areaCodes' => $areaCodes,
                'compliance' => $compliance,
                'numbers' => $numbers,
                'sandbox' => $sandbox,
                'senderValue' => $senderValue,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
