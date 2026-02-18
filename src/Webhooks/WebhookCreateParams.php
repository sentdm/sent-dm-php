<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new webhook endpoint for the authenticated customer.
 *
 * @see SentDm\Services\WebhooksService::create()
 *
 * @phpstan-type WebhookCreateParamsShape = array{
 *   displayName?: string|null,
 *   endpointURL?: string|null,
 *   eventTypes?: list<string>|null,
 *   retryCount?: int|null,
 *   testMode?: bool|null,
 *   timeoutSeconds?: int|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class WebhookCreateParams implements BaseModel
{
    /** @use SdkModel<WebhookCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional('display_name')]
    public ?string $displayName;

    #[Optional('endpoint_url')]
    public ?string $endpointURL;

    /** @var list<string>|null $eventTypes */
    #[Optional('event_types', list: 'string')]
    public ?array $eventTypes;

    #[Optional('retry_count')]
    public ?int $retryCount;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    #[Optional('timeout_seconds')]
    public ?int $timeoutSeconds;

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
     *
     * @param list<string>|null $eventTypes
     */
    public static function with(
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventTypes = null,
        ?int $retryCount = null,
        ?bool $testMode = null,
        ?int $timeoutSeconds = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $endpointURL && $self['endpointURL'] = $endpointURL;
        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $retryCount && $self['retryCount'] = $retryCount;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $timeoutSeconds && $self['timeoutSeconds'] = $timeoutSeconds;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    public function withEndpointURL(string $endpointURL): self
    {
        $self = clone $this;
        $self['endpointURL'] = $endpointURL;

        return $self;
    }

    /**
     * @param list<string> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    public function withRetryCount(int $retryCount): self
    {
        $self = clone $this;
        $self['retryCount'] = $retryCount;

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

    public function withTimeoutSeconds(int $timeoutSeconds): self
    {
        $self = clone $this;
        $self['timeoutSeconds'] = $timeoutSeconds;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
