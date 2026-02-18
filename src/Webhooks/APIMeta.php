<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Request and response metadata.
 *
 * @phpstan-type APIMetaShape = array{
 *   requestID?: string|null,
 *   responseTimeMs?: int|null,
 *   timestamp?: \DateTimeInterface|null,
 *   version?: string|null,
 * }
 */
final class APIMeta implements BaseModel
{
    /** @use SdkModel<APIMetaShape> */
    use SdkModel;

    /**
     * Unique identifier for this request (for tracing and support).
     */
    #[Optional('request_id')]
    public ?string $requestID;

    /**
     * Response time in milliseconds (optional).
     */
    #[Optional('response_time_ms', nullable: true)]
    public ?int $responseTimeMs;

    /**
     * Server timestamp when the response was generated.
     */
    #[Optional]
    public ?\DateTimeInterface $timestamp;

    /**
     * API version used for this request.
     */
    #[Optional]
    public ?string $version;

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
        ?string $requestID = null,
        ?int $responseTimeMs = null,
        ?\DateTimeInterface $timestamp = null,
        ?string $version = null,
    ): self {
        $self = new self;

        null !== $requestID && $self['requestID'] = $requestID;
        null !== $responseTimeMs && $self['responseTimeMs'] = $responseTimeMs;
        null !== $timestamp && $self['timestamp'] = $timestamp;
        null !== $version && $self['version'] = $version;

        return $self;
    }

    /**
     * Unique identifier for this request (for tracing and support).
     */
    public function withRequestID(string $requestID): self
    {
        $self = clone $this;
        $self['requestID'] = $requestID;

        return $self;
    }

    /**
     * Response time in milliseconds (optional).
     */
    public function withResponseTimeMs(?int $responseTimeMs): self
    {
        $self = clone $this;
        $self['responseTimeMs'] = $responseTimeMs;

        return $self;
    }

    /**
     * Server timestamp when the response was generated.
     */
    public function withTimestamp(\DateTimeInterface $timestamp): self
    {
        $self = clone $this;
        $self['timestamp'] = $timestamp;

        return $self;
    }

    /**
     * API version used for this request.
     */
    public function withVersion(string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
