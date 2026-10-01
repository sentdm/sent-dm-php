<?php

declare(strict_types=1);

namespace SentDm\Services\Channels;

use SentDm\Channels\Voice\APIResponseOfListOfVoiceNumber;
use SentDm\Channels\Voice\APIResponseOfVoiceCallbackTest;
use SentDm\Channels\Voice\APIResponseOfVoiceNumber;
use SentDm\Channels\Voice\APIResponseOfVoiceNumberCreated;
use SentDm\Channels\Voice\APIResponseOfVoiceSecret;
use SentDm\Channels\Voice\APIResponseOfVoiceToken;
use SentDm\Channels\Voice\VoiceUpdateParams\Status;
use SentDm\Client;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Util;
use SentDm\RequestOptions;
use SentDm\ServiceContracts\Channels\VoiceContract;

/**
 * The senders you send from, one per channel.
 *
 * **SMS is a list of markets**, each keyed by `(country, number_type)` — a customer can hold `us/10dlc` and `gb/alphanumeric` at once, so a market is addressed by the pair rather than by country alone. **WhatsApp and RCS are single**: a customer has one business account and one agent. **Voice is per number**: each number you hold can carry phone calls on its own (`POST /v3/channels/voice`), each with the callback URL Sent asks what to do with its calls, one of them is the default line for calls placed from your app, and voice tokens are minted under `POST /v3/channels/voice/tokens`. Read your voice numbers with `GET /v3/channels/voice` and change one with `PATCH /v3/channels/voice/{number}`.
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
final class VoiceService implements VoiceContract
{
    /**
     * @api
     */
    public VoiceRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new VoiceRawService($client);
    }

    /**
     * @api
     *
     * Adds voice to one of the numbers you hold, or gives you a new one. Send `number` for a number that is already yours (see `GET /v3/channels`); leave it out to be given a new US number, optionally in a particular `area_code`. Sending both is refused. Nothing registers, so the number can carry calls as soon as this returns.
     *
     * What happens on a call is decided by your `callback_url`: when a call arrives on the number, or a caller presses a key on a menu, Sent POSTs a signed question there and follows the answer. The response carries the `callback_secret` the questions are signed with, the one time it is shown without rotating; verify a question the way you verify a webhook. `POST /v3/channels/voice/{number}/test` sends a test question and reports the verdict.
     *
     * Your first voice number becomes the line app-originated calls are placed from when a voice token names no number; send `default_for_app_calls: true` to give that role to another number. A number you turned off earlier is turned back on, and the same number with a different `callback_url` has its URL replaced and keeps its secret.
     *
     * Read the number's settings with `GET /v3/channels/voice` and change them with `PATCH /v3/channels/voice/{number}`.
     *
     * With `sandbox: true` the request is validated and a simulated number reported with `202`; nothing is written and no number is bought.
     *
     * @param string $callbackURL Body param: Where Sent asks what to do with each call on this number: an absolute HTTP or HTTPS URL on a public
     * host. A signed question is POSTed here when a call arrives or a caller presses a key, and the answer
     * decides the call. Every question is signed with the callback_secret the response returns, the
     * same way your webhooks are signed. Turning the number on again with a different URL replaces it and
     * keeps the secret.
     * @param string|null $areaCode Body param: The US area code a new number should be in, as 212. Only for a request that leaves
     * number out — sending both says two different things about which number to use, and is
     * refused. Omit it too and the number comes from anywhere in the country.
     * @param bool|null $defaultForAppCalls Body param: Make this the line app-originated calls are placed from when a voice token names no number.
     * Omit it and your first voice number takes that role; a later one leaves it where it is.
     * @param string|null $number Body param: One of your phone numbers, in E.164 format. Leave the field out entirely to be given a new one
     * instead; sending it empty is a refused request rather than a request for a new number.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $callbackURL,
        ?string $areaCode = null,
        ?bool $defaultForAppCalls = null,
        ?string $number = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceNumberCreated {
        $params = Util::removeNulls(
            [
                'callbackURL' => $callbackURL,
                'areaCode' => $areaCode,
                'defaultForAppCalls' => $defaultForAppCalls,
                'number' => $number,
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Reads one of your voice numbers, active or inactive: its status, whether it is the default line for calls placed from your app, and its callback URL. The signing secret is not on this read.
     *
     * The same shape `GET /v3/channels/voice` lists, and the same shape `PATCH` on this path accepts and returns, so what comes back can be sent back.
     *
     * The number is the E.164 value in the path with the plus sign URL-encoded (`%2B`).
     *
     * @param string $number The number in E.164 format with the plus sign URL-encoded, e.g. %2B12125550100
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $number,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceNumber {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($number, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Changes one of your voice numbers and answers with the number as stored, the same shape `GET` on this path returns, so what comes back can be sent back.
     *
     * ## What it changes
     *
     * | Body | Effect |
     * | --- | --- |
     * | `"status": "ACTIVE"` | turns calls on again for a number you turned off; the callback URL and the secret it had are kept |
     * | `"status": "INACTIVE"` | turns calls off; the callback URL and the secret stay on the number |
     * | `"default_for_app_calls": true` | makes this the line app-originated calls are placed from when a voice token names no number |
     * | `"callback_url": "https://example.com/voice"` | replaces where Sent asks what to do with each call on the number; the signing secret is kept, and a number that was waiting for its first URL is turned on |
     * | key omitted | left exactly as it is |
     *
     * `status` is matched ignoring case. Any combination is accepted: `status: "ACTIVE"` with `default_for_app_calls: true` turns a number on as the new default, and a `callback_url` sent with either status is written too. A body that names none of the three is refused.
     *
     * ## What it will refuse
     *
     * **`default_for_app_calls: false` is `400`.** An account with active voice numbers always has exactly one default, so the default moves by giving it to another number.
     *
     * **Turning the default line off is `409`** while other active voice numbers remain. Move the default to another number first. Turning off your last voice number is allowed; that turns phone calls off.
     *
     * **Making an inactive number the default is `400`.** Send `status: "ACTIVE"` in the same call.
     *
     * A number added without a `callback_url` is `INACTIVE` for that one reason, so sending it a `callback_url` turns it on by itself, and it becomes your default line if you have no other active voice number. A number you turned off while it had a URL stays off.
     *
     * **A number you never turned voice on for is `404`.** Add it with `POST /v3/channels/voice`.
     *
     * The number is the E.164 value in the path with the plus sign URL-encoded (`%2B`).
     *
     * With `sandbox: true` nothing is written: the request is validated against the stored number and the number is reported with `200` as it would read after the change.
     *
     * @param string $number Path param: The number in E.164 format with the plus sign URL-encoded, e.g. %2B12125550100
     * @param string|null $callbackURL Body param: A new callback URL for the number, active or not: an absolute HTTP or HTTPS URL on a public host,
     * where Sent asks what to do with each call. The signing secret is kept.
     * @param bool|null $defaultForAppCalls Body param: true makes this the line app-originated calls are placed from when a voice token names no
     * number. false is refused: an account with active voice numbers always has exactly one
     * default, so the default moves by giving it to another number.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param Status|value-of<Status>|null $status Body param: ACTIVE turns calls on for the number again, INACTIVE turns them off. Matched
     * ignoring case. Turning the default line off is refused while other active voice numbers remain.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $number,
        ?string $callbackURL = null,
        ?bool $defaultForAppCalls = null,
        ?bool $sandbox = null,
        Status|string|null $status = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceNumber {
        $params = Util::removeNulls(
            [
                'callbackURL' => $callbackURL,
                'defaultForAppCalls' => $defaultForAppCalls,
                'sandbox' => $sandbox,
                'status' => $status,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($number, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Every number you turned phone calls on for, active or inactive, oldest first. Each entry carries the number's status, whether it is the default line for calls placed from your app, and its callback URL. The signing secret is never on a read; it is shown when voice is turned on and by `POST /v3/channels/voice/{number}/rotate-secret`.
     *
     * The same entries `GET /v3/channels` reports under `voice`, and the same shape `GET /v3/channels/voice/{number}` returns for one of them. Change a number with `PATCH /v3/channels/voice/{number}`.
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null
    ): APIResponseOfListOfVoiceNumber {
        $params = Util::removeNulls(['xProfileID' => $xProfileID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
    public function createToken(
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
        $response = $this->raw->createToken(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Generates a new signing secret for the questions Sent sends to this number's callback URL and returns it. The previous secret stops signing immediately, so update your backend before the next call reaches it. The number is the E.164 value in the path with the plus sign URL-encoded (`%2B`).
     *
     * With `sandbox: true` a secret is generated and returned with `202`, and nothing is written.
     *
     * @param string $number Path param: The voice number from the route, in E.164 format with the plus sign URL-encoded (%2B),
     * for example /v3/channels/voice/%2B12025550123/rotate-secret.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $number,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceSecret {
        $params = Util::removeNulls(
            [
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->rotateSecret($number, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sends a synthetic call.request question, flagged "test": true, to the number's callback URL, signed with that number's real secret, and reports what came back. Use it to build and debug your callback endpoint without placing calls: no call is placed, nothing is billed, and nothing is stored. One attempt with the same deadline as a live call, no retry. The outcome is ok when your endpoint answered 2xx with a valid answer; otherwise it is timeout, connection_failed, http_error or invalid_answer, with the reason and, for an invalid answer, the field at fault. The number is the E.164 value in the path with the plus sign URL-encoded (`%2B`).
     *
     * With `sandbox: true` nothing is sent: the verdict comes back ok with `202` and no request or response in it.
     *
     * @param string $number Path param: The voice number from the route, in E.164 format with the plus sign URL-encoded (%2B),
     * for example /v3/channels/voice/%2B12025550123/test. The test question goes to this
     * number's callback URL and is signed with this number's secret.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $number,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceCallbackTest {
        $params = Util::removeNulls(
            [
                'sandbox' => $sandbox,
                'idempotencyKey' => $idempotencyKey,
                'xProfileID' => $xProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->test($number, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
