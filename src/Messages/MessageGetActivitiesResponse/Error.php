<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetActivitiesResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;

/**
 * Error information.
 *
 * @phpstan-type ErrorShape = array{
 *   code?: string|null,
 *   details?: array<string,list<string>>|null,
 *   docURL?: string|null,
 *   message?: string|null,
 * }
 */
final class Error implements BaseModel
{
    /** @use SdkModel<ErrorShape> */
    use SdkModel;

    /**
     * Machine-readable error code (e.g., "RESOURCE_001").
     */
    #[Optional]
    public ?string $code;

    /**
     * Additional validation error details (field-level errors).
     *
     * @var array<string,list<string>>|null $details
     */
    #[Optional(map: new ListOf('string'), nullable: true)]
    public ?array $details;

    /**
     * URL to documentation about this error.
     */
    #[Optional('doc_url', nullable: true)]
    public ?string $docURL;

    /**
     * Human-readable error message.
     */
    #[Optional]
    public ?string $message;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,list<string>>|null $details
     */
    public static function with(
        ?string $code = null,
        ?array $details = null,
        ?string $docURL = null,
        ?string $message = null,
    ): self {
        $self = new self;

        null !== $code && $self['code'] = $code;
        null !== $details && $self['details'] = $details;
        null !== $docURL && $self['docURL'] = $docURL;
        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * Machine-readable error code (e.g., "RESOURCE_001").
     */
    public function withCode(string $code): self
    {
        $self = clone $this;
        $self['code'] = $code;

        return $self;
    }

    /**
     * Additional validation error details (field-level errors).
     *
     * @param array<string,list<string>>|null $details
     */
    public function withDetails(?array $details): self
    {
        $self = clone $this;
        $self['details'] = $details;

        return $self;
    }

    /**
     * URL to documentation about this error.
     */
    public function withDocURL(?string $docURL): self
    {
        $self = clone $this;
        $self['docURL'] = $docURL;

        return $self;
    }

    /**
     * Human-readable error message.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
