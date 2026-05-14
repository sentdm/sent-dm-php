<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookUpdateResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;

/**
 * The response data (null if error).
 *
 * @phpstan-type DataShape = array{
 *   id?: string|null,
 *   consecutiveFailures?: int|null,
 *   createdAt?: \DateTimeInterface|null,
 *   displayName?: string|null,
 *   endpointURL?: string|null,
 *   eventFilters?: array<string,list<string>>|null,
 *   eventTypes?: list<string>|null,
 *   isActive?: bool|null,
 *   lastDeliveryAttemptAt?: \DateTimeInterface|null,
 *   lastSuccessfulDeliveryAt?: \DateTimeInterface|null,
 *   retryCount?: int|null,
 *   signingSecret?: string|null,
 *   timeoutSeconds?: int|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional('consecutive_failures')]
    public ?int $consecutiveFailures;

    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

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

    #[Optional('is_active')]
    public ?bool $isActive;

    #[Optional('last_delivery_attempt_at', nullable: true)]
    public ?\DateTimeInterface $lastDeliveryAttemptAt;

    #[Optional('last_successful_delivery_at', nullable: true)]
    public ?\DateTimeInterface $lastSuccessfulDeliveryAt;

    #[Optional('retry_count')]
    public ?int $retryCount;

    #[Optional('signing_secret', nullable: true)]
    public ?string $signingSecret;

    #[Optional('timeout_seconds')]
    public ?int $timeoutSeconds;

    #[Optional('updated_at', nullable: true)]
    public ?\DateTimeInterface $updatedAt;

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
        ?string $id = null,
        ?int $consecutiveFailures = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventFilters = null,
        ?array $eventTypes = null,
        ?bool $isActive = null,
        ?\DateTimeInterface $lastDeliveryAttemptAt = null,
        ?\DateTimeInterface $lastSuccessfulDeliveryAt = null,
        ?int $retryCount = null,
        ?string $signingSecret = null,
        ?int $timeoutSeconds = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $consecutiveFailures && $self['consecutiveFailures'] = $consecutiveFailures;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $endpointURL && $self['endpointURL'] = $endpointURL;
        null !== $eventFilters && $self['eventFilters'] = $eventFilters;
        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $lastDeliveryAttemptAt && $self['lastDeliveryAttemptAt'] = $lastDeliveryAttemptAt;
        null !== $lastSuccessfulDeliveryAt && $self['lastSuccessfulDeliveryAt'] = $lastSuccessfulDeliveryAt;
        null !== $retryCount && $self['retryCount'] = $retryCount;
        null !== $signingSecret && $self['signingSecret'] = $signingSecret;
        null !== $timeoutSeconds && $self['timeoutSeconds'] = $timeoutSeconds;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withConsecutiveFailures(int $consecutiveFailures): self
    {
        $self = clone $this;
        $self['consecutiveFailures'] = $consecutiveFailures;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    public function withLastDeliveryAttemptAt(
        ?\DateTimeInterface $lastDeliveryAttemptAt
    ): self {
        $self = clone $this;
        $self['lastDeliveryAttemptAt'] = $lastDeliveryAttemptAt;

        return $self;
    }

    public function withLastSuccessfulDeliveryAt(
        ?\DateTimeInterface $lastSuccessfulDeliveryAt
    ): self {
        $self = clone $this;
        $self['lastSuccessfulDeliveryAt'] = $lastSuccessfulDeliveryAt;

        return $self;
    }

    public function withRetryCount(int $retryCount): self
    {
        $self = clone $this;
        $self['retryCount'] = $retryCount;

        return $self;
    }

    public function withSigningSecret(?string $signingSecret): self
    {
        $self = clone $this;
        $self['signingSecret'] = $signingSecret;

        return $self;
    }

    public function withTimeoutSeconds(int $timeoutSeconds): self
    {
        $self = clone $this;
        $self['timeoutSeconds'] = $timeoutSeconds;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
