<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Why the test did not end with ok.
 *
 * @phpstan-type VoiceCallbackTestErrorInfoShape = array{
 *   message?: string|null, path?: string|null, reason?: string|null
 * }
 */
final class VoiceCallbackTestErrorInfo implements BaseModel
{
    /** @use SdkModel<VoiceCallbackTestErrorInfoShape> */
    use SdkModel;

    /**
     * What to fix.
     */
    #[Optional]
    public ?string $message;

    /**
     * Dotted path of the answer field at fault, such as action.action, when one field is to blame.
     */
    #[Optional(nullable: true)]
    public ?string $path;

    /**
     * Machine-readable reason, such as timeout, http_error, malformed_json, missing_action or unknown_action.
     */
    #[Optional]
    public ?string $reason;

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
        ?string $path = null,
        ?string $reason = null
    ): self {
        $self = new self;

        null !== $message && $self['message'] = $message;
        null !== $path && $self['path'] = $path;
        null !== $reason && $self['reason'] = $reason;

        return $self;
    }

    /**
     * What to fix.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Dotted path of the answer field at fault, such as action.action, when one field is to blame.
     */
    public function withPath(?string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    /**
     * Machine-readable reason, such as timeout, http_error, malformed_json, missing_action or unknown_action.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
