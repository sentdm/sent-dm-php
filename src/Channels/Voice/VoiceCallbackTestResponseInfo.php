<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * What your endpoint answered.
 *
 * @phpstan-type VoiceCallbackTestResponseInfoShape = array{
 *   body?: string|null, statusCode?: int|null
 * }
 */
final class VoiceCallbackTestResponseInfo implements BaseModel
{
    /** @use SdkModel<VoiceCallbackTestResponseInfoShape> */
    use SdkModel;

    /**
     * The start of the raw response body, capped at 2048 characters.
     */
    #[Optional(nullable: true)]
    public ?string $body;

    /**
     * The HTTP status your endpoint returned.
     */
    #[Optional('status_code')]
    public ?int $statusCode;

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
        ?string $body = null,
        ?int $statusCode = null
    ): self {
        $self = new self;

        null !== $body && $self['body'] = $body;
        null !== $statusCode && $self['statusCode'] = $statusCode;

        return $self;
    }

    /**
     * The start of the raw response body, capped at 2048 characters.
     */
    public function withBody(?string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * The HTTP status your endpoint returned.
     */
    public function withStatusCode(int $statusCode): self
    {
        $self = clone $this;
        $self['statusCode'] = $statusCode;

        return $self;
    }
}
