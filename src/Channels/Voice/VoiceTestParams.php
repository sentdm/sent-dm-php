<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Sends a synthetic call.request question, flagged "test": true, to the number's callback URL, signed with that number's real secret, and reports what came back. Use it to build and debug your callback endpoint without placing calls: no call is placed, nothing is billed, and nothing is stored. One attempt with the same deadline as a live call, no retry. The outcome is ok when your endpoint answered 2xx with a valid answer; otherwise it is timeout, connection_failed, http_error or invalid_answer, with the reason and, for an invalid answer, the field at fault. The number is the E.164 value in the path with the plus sign URL-encoded (`%2B`).
 *
 * With `sandbox: true` nothing is sent: the verdict comes back ok with `202` and no request or response in it.
 *
 * @see SentDm\Services\Channels\VoiceService::test()
 *
 * @phpstan-type VoiceTestParamsShape = array{
 *   sandbox?: bool|null, idempotencyKey?: string|null, xProfileID?: string|null
 * }
 */
final class VoiceTestParams implements BaseModel
{
    /** @use SdkModel<VoiceTestParamsShape> */
    use SdkModel;
    use SdkParams;

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
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
