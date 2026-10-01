<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A freshly rotated callback signing secret.
 *
 * @phpstan-type VoiceSecretShape = array{callbackSecret?: string|null}
 */
final class VoiceSecret implements BaseModel
{
    /** @use SdkModel<VoiceSecretShape> */
    use SdkModel;

    /**
     * The new whsec_ secret. The previous one stopped signing the moment this was returned, so update
     * your backend before the next call reaches it. Shown once.
     */
    #[Optional('callback_secret')]
    public ?string $callbackSecret;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $callbackSecret = null): self
    {
        $self = new self;

        null !== $callbackSecret && $self['callbackSecret'] = $callbackSecret;

        return $self;
    }

    /**
     * The new whsec_ secret. The previous one stopped signing the moment this was returned, so update
     * your backend before the next call reaches it. Shown once.
     */
    public function withCallbackSecret(string $callbackSecret): self
    {
        $self = clone $this;
        $self['callbackSecret'] = $callbackSecret;

        return $self;
    }
}
