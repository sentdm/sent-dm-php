<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Generates a new signing secret for the questions Sent sends to this number's callback URL and returns it. The previous secret stops signing immediately, so update your backend before the next call reaches it. The number is the E.164 value in the path with the plus sign URL-encoded (`%2B`).
 *
 * With `sandbox: true` a secret is generated and returned with `202`, and nothing is written.
 *
 * @see SentDm\Services\Channels\VoiceService::rotateSecret()
 *
 * @phpstan-type VoiceRotateSecretParamsShape = array{
 *   apiKey?: string|null,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class VoiceRotateSecretParams implements BaseModel
{
    /** @use SdkModel<VoiceRotateSecretParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     */
    #[Optional]
    public ?string $apiKey;

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
        ?string $apiKey = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $apiKey && $self['apiKey'] = $apiKey;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     */
    public function withAPIKey(string $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

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
