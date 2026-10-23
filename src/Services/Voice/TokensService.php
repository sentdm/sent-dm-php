<?php

declare(strict_types=1);

namespace SentDm\Services\Voice;

use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Voice\TokensContract;
use SentDm\Voice\Tokens\APIResponseOfVoiceToken;

/**
 * Phone calls from the numbers you hold, driven by your own callback URL.
 *
 * `POST /v3/channels/voice` enables a number for calls, with the callback URL Sent asks what to do with each call on it, and `POST /v3/voice/tokens` mints a short-lived token that lets a user of your app place and receive calls as that number. When a call arrives or a caller presses a key, a signed question is POSTed to the callback URL and the answer decides the call; `POST /v3/channels/voice/{number}/test` checks the URL answers the way we need before a real call reaches it, and `POST /v3/channels/voice/{number}/rotate-secret` replaces the signing secret. The call events themselves (`call.completed` and the rest) arrive through your webhooks.
 *
 * Every call is a record under `/v3/voice/calls`: read it, list its recordings once one is ready, hang it up, start or stop recording, and add, mute or remove conference participants while it is live. A leg to a phone number runs for at most what your balance affords at the destination's rate.
 *
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
final class TokensService implements TokensContract
{
    /**
     * @api
     */
    public TokensRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TokensRawService($client);
    }

    /**
     * @api
     *
     * Mints a short-lived token for one of your app users. Call this from your backend and return the token to your app, which passes it to the voice client SDK to register. The identity is bound to the given number, or to your default app-call number when omitted, and calls placed by that identity are routed through the bound number. Minting again re-binds the identity, so an identity can move between numbers.
     *
     * @param string $identity Body param: Your identifier for the app user, such as an agent or account id. Letters, digits, hyphens and underscores only, up to 200 characters.
     * @param string|null $number Body param: One of your voice-enabled phone numbers in E.164 format. Calls placed by this identity are routed through that number. Omit to use your default app-call number.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param int|null $ttl Body param: Token lifetime in seconds. Defaults to 600 and cannot exceed 3600.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $identity = null,
        ?string $number = null,
        ?bool $sandbox = null,
        ?int $ttl = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceToken {
        $params = Util::removeNulls(
            [
                'identity' => $identity,
                'number' => $number,
                'sandbox' => $sandbox,
                'ttl' => $ttl,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
