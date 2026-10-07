<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Mints a short-lived token for one of your app users. Call this from your backend and return the token to your app, which passes it to the voice client SDK to register. The identity is bound to the given number, or to your default app-call number when omitted, and calls placed by that identity are routed through the bound number. Minting again re-binds the identity, so an identity can move between numbers.
 *
 * @see SentDm\Services\Channels\VoiceService::createToken()
 *
 * @phpstan-type VoiceCreateTokenParamsShape = array{
 *   identity?: string|null,
 *   number?: string|null,
 *   sandbox?: bool|null,
 *   ttl?: int|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class VoiceCreateTokenParams implements BaseModel
{
    /** @use SdkModel<VoiceCreateTokenParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Your identifier for the app user, such as an agent or account id. Letters, digits, hyphens and underscores only, up to 200 characters.
     */
    #[Optional]
    public ?string $identity;

    /**
     * One of your voice-enabled phone numbers in E.164 format. Calls placed by this identity are routed through that number. Omit to use your default app-call number.
     */
    #[Optional(nullable: true)]
    public ?string $number;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * Token lifetime in seconds. Defaults to 600 and cannot exceed 3600.
     */
    #[Optional(nullable: true)]
    public ?int $ttl;

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
        ?string $identity = null,
        ?string $number = null,
        ?bool $sandbox = null,
        ?int $ttl = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $identity && $self['identity'] = $identity;
        null !== $number && $self['number'] = $number;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $ttl && $self['ttl'] = $ttl;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Your identifier for the app user, such as an agent or account id. Letters, digits, hyphens and underscores only, up to 200 characters.
     */
    public function withIdentity(string $identity): self
    {
        $self = clone $this;
        $self['identity'] = $identity;

        return $self;
    }

    /**
     * One of your voice-enabled phone numbers in E.164 format. Calls placed by this identity are routed through that number. Omit to use your default app-call number.
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

    /**
     * Token lifetime in seconds. Defaults to 600 and cannot exceed 3600.
     */
    public function withTtl(?int $ttl): self
    {
        $self = clone $this;
        $self['ttl'] = $ttl;

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
