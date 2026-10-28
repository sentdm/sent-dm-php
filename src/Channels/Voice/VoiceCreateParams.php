<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Adds voice to one of the numbers you hold, or gives you a new one. Send `number` for a number that is already yours (see `GET /v3/channels`); leave it out to be given a new US number, optionally in a particular `area_code`. Sending both is refused. Nothing registers, so the number can carry calls as soon as this returns.
 *
 * What happens on a call is decided by your `callback_url`: when a call arrives on the number, or a caller presses a key on a menu, Sent POSTs a signed question there and follows the answer. The response carries the `callback_secret` the questions are signed with, the one time it is shown without rotating; verify a question the way you verify a webhook. `POST /v3/channels/voice/{number}/test` sends a test question and reports the verdict.
 *
 * Send `agent_id` instead of `callback_url`, or with it, to have one of your voice agents (`GET /v3/voice/agents`) answer calls to the number. The agent wins over the callback URL for calls to the number; calls your app places from it still follow your app. `routes_to` in the response says which answers, and reads `agent_pending` while the number is still being moved to the agent. Calls follow the move within about an hour, as the provider applies it on its own clock. While numbers cannot be bound to agents, a request with `agent_id` is refused with `502` before any number is obtained or anything is written; send `callback_url` instead.
 *
 * Your first voice number becomes the line app-originated calls are placed from when a voice token names no number; send `default_for_app_calls: true` to give that role to another number. A number you turned off earlier is turned back on, and the same number with a different `callback_url` has its URL replaced and keeps its secret.
 *
 * Read the number's settings with `GET /v3/channels/voice` and change them with `PATCH /v3/channels/voice/{number}`.
 *
 * With `sandbox: true` the request is validated and a simulated number reported with `202`; nothing is written and no number is bought.
 *
 * @see SentDm\Services\Channels\VoiceService::create()
 *
 * @phpstan-type VoiceCreateParamsShape = array{
 *   agentID?: string|null,
 *   areaCode?: string|null,
 *   callbackURL?: string|null,
 *   defaultForAppCalls?: bool|null,
 *   number?: string|null,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class VoiceCreateParams implements BaseModel
{
    /** @use SdkModel<VoiceCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * One of your voice agents (GET /v3/voice/agents), such as
     * agent_9f2ab000-0000-4000-8000-000000000001, to answer calls to this number. It wins over
     * callback_url for calls to the number, and both may be sent; calls your app places from the
     * number still follow your app. Send it instead of callback_url for a number only an agent answers.
     */
    #[Optional('agent_id', nullable: true)]
    public ?string $agentID;

    /**
     * The US area code a new number should be in, as 212. Only for a request that leaves
     * number out — sending both says two different things about which number to use, and is
     * refused. Omit it too and the number comes from anywhere in the country.
     */
    #[Optional('area_code', nullable: true)]
    public ?string $areaCode;

    /**
     * Where Sent asks what to do with each call on this number: an absolute HTTP or HTTPS URL on a public
     * host. A signed question is POSTed here when a call arrives or a caller presses a key, and the answer
     * decides the call. Every question is signed with the callback_secret the response returns, the
     * same way your webhooks are signed. Turning the number on again with a different URL replaces it and
     * keeps the secret. Required unless agent_id is sent.
     */
    #[Optional('callback_url', nullable: true)]
    public ?string $callbackURL;

    /**
     * Make this the line app-originated calls are placed from when a voice token names no number.
     * Omit it and your first voice number takes that role; a later one leaves it where it is.
     */
    #[Optional('default_for_app_calls', nullable: true)]
    public ?bool $defaultForAppCalls;

    /**
     * One of your phone numbers, in E.164 format. Leave the field out entirely to be given a new one
     * instead; sending it empty is a refused request rather than a request for a new number.
     */
    #[Optional(nullable: true)]
    public ?string $number;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $agentID = null,
        ?string $areaCode = null,
        ?string $callbackURL = null,
        ?bool $defaultForAppCalls = null,
        ?string $number = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $agentID && $self['agentID'] = $agentID;
        null !== $areaCode && $self['areaCode'] = $areaCode;
        null !== $callbackURL && $self['callbackURL'] = $callbackURL;
        null !== $defaultForAppCalls && $self['defaultForAppCalls'] = $defaultForAppCalls;
        null !== $number && $self['number'] = $number;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * One of your voice agents (GET /v3/voice/agents), such as
     * agent_9f2ab000-0000-4000-8000-000000000001, to answer calls to this number. It wins over
     * callback_url for calls to the number, and both may be sent; calls your app places from the
     * number still follow your app. Send it instead of callback_url for a number only an agent answers.
     */
    public function withAgentID(?string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * The US area code a new number should be in, as 212. Only for a request that leaves
     * number out — sending both says two different things about which number to use, and is
     * refused. Omit it too and the number comes from anywhere in the country.
     */
    public function withAreaCode(?string $areaCode): self
    {
        $self = clone $this;
        $self['areaCode'] = $areaCode;

        return $self;
    }

    /**
     * Where Sent asks what to do with each call on this number: an absolute HTTP or HTTPS URL on a public
     * host. A signed question is POSTed here when a call arrives or a caller presses a key, and the answer
     * decides the call. Every question is signed with the callback_secret the response returns, the
     * same way your webhooks are signed. Turning the number on again with a different URL replaces it and
     * keeps the secret. Required unless agent_id is sent.
     */
    public function withCallbackURL(?string $callbackURL): self
    {
        $self = clone $this;
        $self['callbackURL'] = $callbackURL;

        return $self;
    }

    /**
     * Make this the line app-originated calls are placed from when a voice token names no number.
     * Omit it and your first voice number takes that role; a later one leaves it where it is.
     */
    public function withDefaultForAppCalls(?bool $defaultForAppCalls): self
    {
        $self = clone $this;
        $self['defaultForAppCalls'] = $defaultForAppCalls;

        return $self;
    }

    /**
     * One of your phone numbers, in E.164 format. Leave the field out entirely to be given a new one
     * instead; sending it empty is a refused request rather than a request for a new number.
     */
    public function withNumber(?string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
