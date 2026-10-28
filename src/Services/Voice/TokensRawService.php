<?php

declare(strict_types=1);

namespace SentDm\Services\Voice;

use SentDm\Client;
use SentDm\Core\Contracts\BaseResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Voice\TokensRawContract;
use SentDm\Voice\Tokens\APIResponseOfVoiceToken;
use SentDm\Voice\Tokens\TokenCreateParams;

/**
 * Phone calls from the numbers you hold, driven by your own callback URL.
 *
 * `POST /v3/channels/voice` enables a number for calls, with the callback URL Sent asks what to do with each call on it, and `POST /v3/voice/tokens` mints a short-lived token that lets a user of your app place and receive calls as that number. When a call arrives or a caller presses a key, a signed question is POSTed to the callback URL and the answer decides the call; `POST /v3/channels/voice/{number}/test` checks the URL answers the way we need before a real call reaches it, and `POST /v3/channels/voice/{number}/rotate-secret` replaces the signing secret. The call events themselves (`call.completed` and the rest) arrive through your webhooks.
 *
 * Every call is a record under `/v3/voice/calls`: read it, list its recordings once one is ready, hang it up, start or stop recording, and add, mute or remove conference participants while it is live. A leg to a phone number runs for at most what your balance affords at the destination's rate.
 *
 * **Voice agents.** `POST /v3/voice/agents` creates an agent that answers calls through the Sent Voice Gateway: `session_type` says whether Sent carries the call as text (speech recognised and spoken for the agent) or as audio, `websocket_url` is where the gateway dials the agent for each call (leave it out and the agent dials in with your API key), and `tools`, `transfer_targets`, `fallback` and `limits` say what it may do on a call. The agent's `signing_secret` is shown on create and on `POST /v3/voice/agents/{id}/rotate-secret` only. Voices and languages for text sessions come from `GET /v3/voice/voices`. A number takes calls to an agent once it is bound to it on `/v3/channels/voice`.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class TokensRawService implements TokensRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Mints a short-lived token for one of your app users. Call this from your backend and return the token to your app, which passes it to the voice client SDK to register. The identity is bound to the given number, or to your default app-call number when omitted, and calls placed by that identity are routed through the bound number. Minting again re-binds the identity, so an identity can move between numbers.
     *
     * @param array{
     *   identity?: string,
     *   number?: string|null,
     *   sandbox?: bool,
     *   ttl?: int|null,
     *   idempotencyKey?: string,
     *   xProfileID?: string,
     * }|TokenCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIResponseOfVoiceToken>
     *
     * @throws APIException
     */
    public function create(
        array|TokenCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TokenCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'idempotencyKey' => 'Idempotency-Key', 'xProfileID' => 'x-profile-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v3/voice/tokens',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: APIResponseOfVoiceToken::class,
        );
    }
}
