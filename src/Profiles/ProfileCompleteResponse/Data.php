<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileCompleteResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Response when a profile is already in the completed state and no further action is taken.
 *
 * @phpstan-type DataShape = array{message?: string|null, status?: string|null}
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Human-readable message describing the result.
     */
    #[Optional]
    public ?string $message;

    /**
     * Current process status of the profile (e.g., "completed", "submitted", "in_progress").
     */
    #[Optional]
    public ?string $status;

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
        ?string $message = null,
        ?string $status = null
    ): self {
        $self = new self;

        null !== $message && $self['message'] = $message;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * Human-readable message describing the result.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Current process status of the profile (e.g., "completed", "submitted", "in_progress").
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
