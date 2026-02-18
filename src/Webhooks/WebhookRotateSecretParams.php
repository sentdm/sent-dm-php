<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\WebhookRotateSecretParams\Body;

/**
 * Generates a new signing secret for the specified webhook. The old secret is immediately invalidated.
 *
 * @see SentDm\Services\WebhooksService::rotateSecret()
 *
 * @phpstan-import-type BodyShape from \SentDm\Webhooks\WebhookRotateSecretParams\Body
 *
 * @phpstan-type WebhookRotateSecretParamsShape = array{
 *   body: Body|BodyShape, idempotencyKey?: string|null
 * }
 */
final class WebhookRotateSecretParams implements BaseModel
{
    /** @use SdkModel<WebhookRotateSecretParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public Body $body;

    #[Optional]
    public ?string $idempotencyKey;

    /**
     * `new WebhookRotateSecretParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookRotateSecretParams::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookRotateSecretParams)->withBody(...)
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
     *
     * @param Body|BodyShape $body
     */
    public static function with(
        Body|array $body,
        ?string $idempotencyKey = null
    ): self {
        $self = new self;

        $self['body'] = $body;

        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * @param Body|BodyShape $body
     */
    public function withBody(Body|array $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
