<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A freshly rotated signing secret.
 *
 * @phpstan-type VoiceAgentSecretShape = array{signingSecret?: string|null}
 */
final class VoiceAgentSecret implements BaseModel
{
    /** @use SdkModel<VoiceAgentSecretShape> */
    use SdkModel;

    /**
     * The new whsec_ secret. The previous one stopped signing the moment this was returned. Shown once.
     */
    #[Optional('signing_secret')]
    public ?string $signingSecret;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $signingSecret = null): self
    {
        $self = new self;

        null !== $signingSecret && $self['signingSecret'] = $signingSecret;

        return $self;
    }

    /**
     * The new whsec_ secret. The previous one stopped signing the moment this was returned. Shown once.
     */
    public function withSigningSecret(string $signingSecret): self
    {
        $self = clone $this;
        $self['signingSecret'] = $signingSecret;

        return $self;
    }
}
