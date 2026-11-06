<?php

declare(strict_types=1);

namespace SentDm\Services\Channels;

use SentDm\Channels\Whatsapp\APIResponseOfWhatsappChannel;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Channels\WhatsappContract;

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
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class WhatsappService implements WhatsappContract
{
    /**
     * @api
     */
    public WhatsappRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WhatsappRawService($client);
    }

    /**
     * @api
     *
     * Connects a WhatsApp Business Account shared with us through a Multi-Partner Solution to the calling sender profile. Send `x-profile-id` for the profile the account belongs to.
     *
     * **Two fields, because everything else is derived.** `waba_id` says which of your organization's shared accounts this is — you hold one per client, and nothing else can say which. `phone_number_id` names the account's number, which is what assigns it to the profile as the number it sends from.
     *
     * The solution the account arrived through, the client business portfolio that owns it, the access token and its expiry are all resolved from your organization. They are not accepted here: the first two are Meta's answer about provenance, and the token is minted per client business and rotates roughly every sixty days, so a value you sent would be stale before it was useful.
     *
     * `phone_number_id` is optional. Omit it to connect the account now and settle the number later — the channel reads as `ACTION_NEEDED` with `reason_code` `CHANNEL_007`, and the profile's WhatsApp messages fail until a number is named. They do not fall back to your organization's account. Call this endpoint again with `phone_number_id` to name one.
     *
     * The same resolution runs behind `channels.whatsapp` on `POST /v3/sender-profiles`, so connecting at create and connecting afterwards fill the same fields.
     *
     * Returns **the account**, not every channel you have — adding one cannot change a market or an RCS agent, and `GET /v3/channels` is the whole picture. Giving an account up is not self-service: ask support, because deregistering a number lands in your own Meta business.
     *
     * @param string|null $phoneNumberID Body param: The Meta phone-number id of the number on WabaId, which assigns it to this profile as the
     * number it sends from. It is not checked against the account here, so name the account's number; it is
     * refused if another profile already uses it.
     *
     * Optional: omit it to connect the account and settle the number later. Nothing picks one on your
     * behalf.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $wabaID Body param: WhatsApp Business Account id — one of the accounts shared into your organization. Required: the
     * organization holds one per client, and nothing but the caller says which is meant here.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $phoneNumberID = null,
        ?bool $sandbox = null,
        ?string $wabaID = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfWhatsappChannel {
        $params = Util::removeNulls(
            [
                'phoneNumberID' => $phoneNumberID,
                'sandbox' => $sandbox,
                'wabaID' => $wabaID,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
