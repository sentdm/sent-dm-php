<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Response acknowledging that profile completion has been accepted and started in the background.
 * The provided webhook URL will be called when processing finishes.
 *
 * @phpstan-type ProfileCompletionAcceptedShape = array{message?: string|null}
 */
final class ProfileCompletionAccepted implements BaseModel
{
    /** @use SdkModel<ProfileCompletionAcceptedShape> */
    use SdkModel;

    /**
     * Human-readable message describing the accepted state.
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
     */
    public static function with(?string $message = null): self
    {
        $self = new self;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * Human-readable message describing the accepted state.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
