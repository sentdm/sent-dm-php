<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A short-lived token your app passes to the voice client SDK to register.
 *
 * @phpstan-type VoiceTokenShape = array{
 *   token?: string|null,
 *   expiresAt?: \DateTimeInterface|null,
 *   identity?: string|null,
 *   number?: string|null,
 * }
 */
final class VoiceToken implements BaseModel
{
    /** @use SdkModel<VoiceTokenShape> */
    use SdkModel;

    /**
     * The signed token. Hand it to the client SDK unchanged.
     */
    #[Optional]
    public ?string $token;

    /**
     * When the token expires (UTC).
     */
    #[Optional('expires_at')]
    public ?\DateTimeInterface $expiresAt;

    /**
     * The identity the token was minted for.
     */
    #[Optional]
    public ?string $identity;

    /**
     * The phone number this identity is now bound to, in E.164 format.
     */
    #[Optional]
    public ?string $number;

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
        ?string $token = null,
        ?\DateTimeInterface $expiresAt = null,
        ?string $identity = null,
        ?string $number = null,
    ): self {
        $self = new self;

        null !== $token && $self['token'] = $token;
        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $identity && $self['identity'] = $identity;
        null !== $number && $self['number'] = $number;

        return $self;
    }

    /**
     * The signed token. Hand it to the client SDK unchanged.
     */
    public function withToken(string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }

    /**
     * When the token expires (UTC).
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * The identity the token was minted for.
     */
    public function withIdentity(string $identity): self
    {
        $self = clone $this;
        $self['identity'] = $identity;

        return $self;
    }

    /**
     * The phone number this identity is now bound to, in E.164 format.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }
}
