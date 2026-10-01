<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Adds voice to one of the numbers you hold. The number must already be yours (see `GET /v3/channels`); this does not procure one, and nothing registers, so the number can carry calls as soon as this returns.
 *
 * What happens on a call is decided by your `callback_url`: when a call arrives on the number, or a caller presses a key on a menu, Sent POSTs a signed question there and follows the answer. The response carries the `callback_secret` the questions are signed with, the one time it is shown without rotating; verify a question the way you verify a webhook. `POST /v3/channels/voice/{number}/test` sends a test question and reports the verdict.
 *
 * Your first voice number becomes the line app-originated calls are placed from when a voice token names no number; send `default_for_app_calls: true` to give that role to another number. A number you turned off earlier is turned back on, and the same number with a different `callback_url` has its URL replaced and keeps its secret.
 *
 * Read the number's settings with `GET /v3/channels/voice` and change them with `PATCH /v3/channels/voice/{number}`.
 *
 * With `sandbox: true` the request is validated and a simulated number reported with `202`, and nothing is written.
 *
 * @see SentDm\Services\Channels\VoiceService::create()
 *
 * @phpstan-type VoiceCreateParamsShape = array{
 *   callbackURL: string,
 *   number: string,
 *   defaultForAppCalls?: bool|null,
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
     * Where Sent asks what to do with each call on this number: an absolute HTTP or HTTPS URL on a public
     * host. A signed question is POSTed here when a call arrives or a caller presses a key, and the answer
     * decides the call. Every question is signed with the callback_secret the response returns, the
     * same way your webhooks are signed. Turning the number on again with a different URL replaces it and
     * keeps the secret.
     */
    #[Required('callback_url')]
    public string $callbackURL;

    /**
     * One of your phone numbers, in E.164 format.
     */
    #[Required]
    public string $number;

    /**
     * Make this the line app-originated calls are placed from when a voice token names no number.
     * Omit it and your first voice number takes that role; a later one leaves it where it is.
     */
    #[Optional('default_for_app_calls', nullable: true)]
    public ?bool $defaultForAppCalls;

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

    /**
     * `new VoiceCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VoiceCreateParams::with(callbackURL: ..., number: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VoiceCreateParams)->withCallbackURL(...)->withNumber(...)
     * ```
     */
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
        string $callbackURL,
        string $number,
        ?bool $defaultForAppCalls = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['callbackURL'] = $callbackURL;
        $self['number'] = $number;

        null !== $defaultForAppCalls && $self['defaultForAppCalls'] = $defaultForAppCalls;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Where Sent asks what to do with each call on this number: an absolute HTTP or HTTPS URL on a public
     * host. A signed question is POSTed here when a call arrives or a caller presses a key, and the answer
     * decides the call. Every question is signed with the callback_secret the response returns, the
     * same way your webhooks are signed. Turning the number on again with a different URL replaces it and
     * keeps the secret.
     */
    public function withCallbackURL(string $callbackURL): self
    {
        $self = clone $this;
        $self['callbackURL'] = $callbackURL;

        return $self;
    }

    /**
     * One of your phone numbers, in E.164 format.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

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
