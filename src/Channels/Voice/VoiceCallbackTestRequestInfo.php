<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The test question exactly as it was sent.
 *
 * @phpstan-type VoiceCallbackTestRequestInfoShape = array{
 *   body?: string|null, headers?: array<string,string>|null, url?: string|null
 * }
 */
final class VoiceCallbackTestRequestInfo implements BaseModel
{
    /** @use SdkModel<VoiceCallbackTestRequestInfoShape> */
    use SdkModel;

    /**
     * The request body byte for byte. This is what the signature covers.
     */
    #[Optional]
    public ?string $body;

    /**
     * Every header Sent added, the signature included, so you can compare against what your endpoint verified. The signing secret itself is never included.
     *
     * @var array<string,string>|null $headers
     */
    #[Optional(map: 'string')]
    public ?array $headers;

    /**
     * The callback URL that was called.
     */
    #[Optional]
    public ?string $url;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string>|null $headers
     */
    public static function with(
        ?string $body = null,
        ?array $headers = null,
        ?string $url = null
    ): self {
        $self = new self;

        null !== $body && $self['body'] = $body;
        null !== $headers && $self['headers'] = $headers;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * The request body byte for byte. This is what the signature covers.
     */
    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Every header Sent added, the signature included, so you can compare against what your endpoint verified. The signing secret itself is never included.
     *
     * @param array<string,string> $headers
     */
    public function withHeaders(array $headers): self
    {
        $self = clone $this;
        $self['headers'] = $headers;

        return $self;
    }

    /**
     * The callback URL that was called.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
