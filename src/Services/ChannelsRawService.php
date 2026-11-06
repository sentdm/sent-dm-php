<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Channels\APIResponseOfChannelsState;
use SentDm\Channels\ChannelListParams;
use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\ChannelsRawContract;

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
final class ChannelsRawService implements ChannelsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Every market you send SMS in, your WhatsApp account, your RCS agent and the numbers you carry phone calls on — with each one's status, and what each market has supplied.
     *
     * **Status lives on the channel, never on you or your brand.** An identity has no lifecycle; what has one is the registration of a sender in a market and the approval of a channel. So a customer live in one country and mid-registration in another reports exactly that, rather than one flattened answer.
     *
     * `sms[n].compliance` carries what each market holds: `brand` and `campaign` for markets that register with a compliance regime such as US TEN_DLC, and `documents` for markets that pre-register an alphanumeric or similar sender. Absent means the market registers with nobody and nothing has been supplied. `GET /v3/compliance/requirements` says what a market demands of any new customer; this says what you gave it.
     *
     * Send `x-profile-id` with an organization key to read one of your profiles' channels.
     *
     * @param array{xProfileID?: string}|ChannelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfChannelsState>
     *
     * @throws APIException
     */
    public function list(
        array|ChannelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ChannelListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v3/channels',
            headers: Util::array_transform_keys(
                $parsed,
                ['xProfileID' => 'x-profile-id']
            ),
            options: $options,
            convert: APIResponseOfChannelsState::class,
        );
    }
}
