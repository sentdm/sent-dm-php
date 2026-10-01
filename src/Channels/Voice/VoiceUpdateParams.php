<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Channels\Voice\VoiceUpdateParams\Status;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
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
 * @see SentDm\Services\Channels\VoiceService::update()
 *
 * @phpstan-type VoiceUpdateParamsShape = array{
 *   callbackURL?: string|null,
 *   defaultForAppCalls?: bool|null,
 *   sandbox?: bool|null,
 *   status?: null|Status|value-of<Status>,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class VoiceUpdateParams implements BaseModel
{
    /** @use SdkModel<VoiceUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * A new callback URL for the number, active or not: an absolute HTTP or HTTPS URL on a public host,
     * where Sent asks what to do with each call. The signing secret is kept.
     */
    #[Optional('callback_url', nullable: true)]
    public ?string $callbackURL;

    /**
     * true makes this the line app-originated calls are placed from when a voice token names no
     * number. false is refused: an account with active voice numbers always has exactly one
     * default, so the default moves by giving it to another number.
     */
    #[Optional('default_for_app_calls', nullable: true)]
    public ?bool $defaultForAppCalls;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * ACTIVE turns calls on for the number again, INACTIVE turns them off. Matched
     * ignoring case. Turning the default line off is refused while other active voice numbers remain.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

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
     *
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?string $callbackURL = null,
        ?bool $defaultForAppCalls = null,
        ?bool $sandbox = null,
        Status|string|null $status = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $callbackURL && $self['callbackURL'] = $callbackURL;
        null !== $defaultForAppCalls && $self['defaultForAppCalls'] = $defaultForAppCalls;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $status && $self['status'] = $status;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * A new callback URL for the number, active or not: an absolute HTTP or HTTPS URL on a public host,
     * where Sent asks what to do with each call. The signing secret is kept.
     */
    public function withCallbackURL(?string $callbackURL): self
    {
        $self = clone $this;
        $self['callbackURL'] = $callbackURL;

        return $self;
    }

    /**
     * true makes this the line app-originated calls are placed from when a voice token names no
     * number. false is refused: an account with active voice numbers always has exactly one
     * default, so the default moves by giving it to another number.
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

    /**
     * ACTIVE turns calls on for the number again, INACTIVE turns them off. Matched
     * ignoring case. Turning the default line off is refused while other active voice numbers remain.
     *
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

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
