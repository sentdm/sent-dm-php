<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookRotateSecretResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The response data (null if error).
 *
 * @phpstan-type DataShape = array{signingSecret?: string|null}
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

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

    public function withSigningSecret(string $signingSecret): self
    {
        $self = clone $this;
        $self['signingSecret'] = $signingSecret;

        return $self;
    }
}
