<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type EventShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   deliveryAttempts?: int|null,
 *   deliveryStatus?: string|null,
 *   errorMessage?: string|null,
 *   eventData?: mixed,
 *   eventType?: string|null,
 *   httpStatusCode?: int|null,
 *   processingCompletedAt?: \DateTimeInterface|null,
 *   processingStartedAt?: \DateTimeInterface|null,
 *   responseBody?: string|null,
 * }
 */
final class Event implements BaseModel
{
    /** @use SdkModel<EventShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    #[Optional('delivery_attempts')]
    public ?int $deliveryAttempts;

    #[Optional('delivery_status')]
    public ?string $deliveryStatus;

    #[Optional('error_message', nullable: true)]
    public ?string $errorMessage;

    #[Optional('event_data')]
    public mixed $eventData;

    #[Optional('event_type')]
    public ?string $eventType;

    #[Optional('http_status_code', nullable: true)]
    public ?int $httpStatusCode;

    #[Optional('processing_completed_at', nullable: true)]
    public ?\DateTimeInterface $processingCompletedAt;

    #[Optional('processing_started_at', nullable: true)]
    public ?\DateTimeInterface $processingStartedAt;

    #[Optional('response_body', nullable: true)]
    public ?string $responseBody;

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
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?int $deliveryAttempts = null,
        ?string $deliveryStatus = null,
        ?string $errorMessage = null,
        mixed $eventData = null,
        ?string $eventType = null,
        ?int $httpStatusCode = null,
        ?\DateTimeInterface $processingCompletedAt = null,
        ?\DateTimeInterface $processingStartedAt = null,
        ?string $responseBody = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $deliveryAttempts && $self['deliveryAttempts'] = $deliveryAttempts;
        null !== $deliveryStatus && $self['deliveryStatus'] = $deliveryStatus;
        null !== $errorMessage && $self['errorMessage'] = $errorMessage;
        null !== $eventData && $self['eventData'] = $eventData;
        null !== $eventType && $self['eventType'] = $eventType;
        null !== $httpStatusCode && $self['httpStatusCode'] = $httpStatusCode;
        null !== $processingCompletedAt && $self['processingCompletedAt'] = $processingCompletedAt;
        null !== $processingStartedAt && $self['processingStartedAt'] = $processingStartedAt;
        null !== $responseBody && $self['responseBody'] = $responseBody;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withDeliveryAttempts(int $deliveryAttempts): self
    {
        $self = clone $this;
        $self['deliveryAttempts'] = $deliveryAttempts;

        return $self;
    }

    public function withDeliveryStatus(string $deliveryStatus): self
    {
        $self = clone $this;
        $self['deliveryStatus'] = $deliveryStatus;

        return $self;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    public function withEventData(mixed $eventData): self
    {
        $self = clone $this;
        $self['eventData'] = $eventData;

        return $self;
    }

    public function withEventType(string $eventType): self
    {
        $self = clone $this;
        $self['eventType'] = $eventType;

        return $self;
    }

    public function withHTTPStatusCode(?int $httpStatusCode): self
    {
        $self = clone $this;
        $self['httpStatusCode'] = $httpStatusCode;

        return $self;
    }

    public function withProcessingCompletedAt(
        ?\DateTimeInterface $processingCompletedAt
    ): self {
        $self = clone $this;
        $self['processingCompletedAt'] = $processingCompletedAt;

        return $self;
    }

    public function withProcessingStartedAt(
        ?\DateTimeInterface $processingStartedAt
    ): self {
        $self = clone $this;
        $self['processingStartedAt'] = $processingStartedAt;

        return $self;
    }

    public function withResponseBody(?string $responseBody): self
    {
        $self = clone $this;
        $self['responseBody'] = $responseBody;

        return $self;
    }
}
