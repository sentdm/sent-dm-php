<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Activates or deactivates a webhook for the authenticated customer.
 *
 * @see SentDm\Services\WebhooksService::toggleStatus()
 *
 * @phpstan-type WebhookToggleStatusParamsShape = array{
 *   isActive?: bool|null, testMode?: bool|null, idempotencyKey?: string|null
 * }
 */
final class WebhookToggleStatusParams implements BaseModel
{
    /** @use SdkModel<WebhookToggleStatusParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional('is_active')]
    public ?bool $isActive;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    #[Optional]
    public ?string $idempotencyKey;

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
        ?bool $isActive = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null
    ): self {
        $self = new self;

        null !== $isActive && $self['isActive'] = $isActive;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withTestMode(bool $testMode): self
    {
        $self = clone $this;
        $self['testMode'] = $testMode;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
