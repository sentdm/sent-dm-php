<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One number the profile carries phone calls on.
 *
 * @phpstan-type VoiceNumberShape = array{
 *   callbackURL?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   defaultForAppCalls?: bool|null,
 *   number?: string|null,
 *   status?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class VoiceNumber implements BaseModel
{
    /** @use SdkModel<VoiceNumberShape> */
    use SdkModel;

    /**
     * Where Sent asks what to do with each call on this number: a signed question is POSTed here when
     * a call arrives or a caller presses a key, and the answer decides the call. The signing secret is
     * not on this read; it is shown when voice is turned on and by the rotate endpoint.
     */
    #[Optional('callback_url', nullable: true)]
    public ?string $callbackURL;

    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * Whether this is the line app-originated calls are placed from when a voice token names no number.
     * Exactly one active voice number carries it while the profile has any.
     */
    #[Optional('default_for_app_calls')]
    public ?bool $defaultForAppCalls;

    /**
     * The number, in E.164.
     */
    #[Optional]
    public ?string $number;

    /**
     * ACTIVE while the number carries calls, INACTIVE once it was turned off. Nothing
     * provisions: a number the customer holds can carry calls the moment voice is turned on for it.
     */
    #[Optional]
    public ?string $status;

    #[Optional('updated_at')]
    public ?\DateTimeInterface $updatedAt;

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
        ?string $callbackURL = null,
        ?\DateTimeInterface $createdAt = null,
        ?bool $defaultForAppCalls = null,
        ?string $number = null,
        ?string $status = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $callbackURL && $self['callbackURL'] = $callbackURL;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $defaultForAppCalls && $self['defaultForAppCalls'] = $defaultForAppCalls;
        null !== $number && $self['number'] = $number;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Where Sent asks what to do with each call on this number: a signed question is POSTed here when
     * a call arrives or a caller presses a key, and the answer decides the call. The signing secret is
     * not on this read; it is shown when voice is turned on and by the rotate endpoint.
     */
    public function withCallbackURL(?string $callbackURL): self
    {
        $self = clone $this;
        $self['callbackURL'] = $callbackURL;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Whether this is the line app-originated calls are placed from when a voice token names no number.
     * Exactly one active voice number carries it while the profile has any.
     */
    public function withDefaultForAppCalls(bool $defaultForAppCalls): self
    {
        $self = clone $this;
        $self['defaultForAppCalls'] = $defaultForAppCalls;

        return $self;
    }

    /**
     * The number, in E.164.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * ACTIVE while the number carries calls, INACTIVE once it was turned off. Nothing
     * provisions: a number the customer holds can carry calls the moment voice is turned on for it.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
