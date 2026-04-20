<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;

/**
 * Creates a new webhook endpoint for the authenticated customer.
 *
 * @see SentDm\Services\WebhooksService::create()
 *
 * @phpstan-type WebhookCreateParamsShape = array{
 *   displayName?: string|null,
 *   endpointURL?: string|null,
 *   eventFilters?: array<string,list<string>>|null,
 *   eventTypes?: list<string>|null,
 *   retryCount?: int|null,
 *   sandbox?: bool|null,
 *   timeoutSeconds?: int|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
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

    /** @var array<string,list<string>>|null $eventFilters */
    #[Optional('event_filters', map: new ListOf('string'), nullable: true)]
    public ?array $eventFilters;

    /** @var list<string>|null $eventTypes */
    #[Optional('event_types', list: 'string')]
    public ?array $eventTypes;

    #[Optional('retry_count')]
    public ?int $retryCount;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional('timeout_seconds')]
    public ?int $timeoutSeconds;

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
     *
     * @param array<string,list<string>>|null $eventFilters
     * @param list<string>|null $eventTypes
     */
    public static function with(
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventFilters = null,
        ?array $eventTypes = null,
        ?int $retryCount = null,
        ?bool $sandbox = null,
        ?int $timeoutSeconds = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $endpointURL && $self['endpointURL'] = $endpointURL;
        null !== $eventFilters && $self['eventFilters'] = $eventFilters;
        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $retryCount && $self['retryCount'] = $retryCount;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $timeoutSeconds && $self['timeoutSeconds'] = $timeoutSeconds;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
     * @param array<string,list<string>>|null $eventFilters
     */
    public function withEventFilters(?array $eventFilters): self
    {
        $self = clone $this;
        $self['eventFilters'] = $eventFilters;

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
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

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

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
