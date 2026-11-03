<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\Voice\APIResponseOfListOfVoiceNumber;
use SentDm\Channels\Voice\APIResponseOfVoiceCallbackTest;
use SentDm\Channels\Voice\APIResponseOfVoiceNumber;
use SentDm\Channels\Voice\APIResponseOfVoiceNumberCreated;
use SentDm\Channels\Voice\APIResponseOfVoiceSecret;
use SentDm\Channels\Voice\VoiceUpdateParams\Status;
use SentDm\Core\Exceptions\APIException;
use SentDm\Core\Omit;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface VoiceContract
{
    /**
     * @api
     *
     * @param string|null $agentID Body param: One of your voice agents (GET /v3/voice/agents), such as
     * agent_9f2ab000-0000-4000-8000-000000000001, to answer calls to this number. It wins over
     * callback_url for calls to the number, and both may be sent; calls your app places from the
     * number still follow your app. Send it instead of callback_url for a number only an agent answers.
     * @param string|null $areaCode Body param: The US area code a new number should be in, as 212. Only for a request that leaves
     * number out — sending both says two different things about which number to use, and is
     * refused. Omit it too and the number comes from anywhere in the country.
     * @param string|null $callbackURL Body param: Where Sent asks what to do with each call on this number: an absolute HTTP or HTTPS URL on a public
     * host. A signed question is POSTed here when a call arrives or a caller presses a key, and the answer
     * decides the call. Every question is signed with the callback_secret the response returns, the
     * same way your webhooks are signed. Turning the number on again with a different URL replaces it and
     * keeps the secret. Required unless agent_id is sent.
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
        ?string $agentID = null,
        ?string $areaCode = null,
        ?string $callbackURL = null,
        ?bool $defaultForAppCalls = null,
        ?string $number = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceNumberCreated;

    /**
     * @api
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
    ): APIResponseOfVoiceNumber;

    /**
     * @api
     *
     * @param string $number Path param: The number in E.164 format with the plus sign URL-encoded, e.g. %2B12125550100
     * @param string|null|Omit $agentID Body param: One of your voice agents, such as agent_9f2ab000-0000-4000-8000-000000000001, to answer calls to
     * the number, or null to unbind it so the callback URL answers them again. Leave this
     * parameter out entirely to leave the current binding alone. The agent wins over
     * callback_url for calls to the number; calls your app places from it still follow your app.
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
        string|null|Omit $agentID = new Omit,
        ?string $callbackURL = null,
        ?bool $defaultForAppCalls = null,
        ?bool $sandbox = null,
        Status|string|null $status = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfVoiceNumber;

    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfListOfVoiceNumber;

    /**
     * @api
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
    ): APIResponseOfVoiceSecret;

    /**
     * @api
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
    ): APIResponseOfVoiceCallbackTest;
}
