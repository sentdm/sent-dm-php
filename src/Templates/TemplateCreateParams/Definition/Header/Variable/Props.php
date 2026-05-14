<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateCreateParams\Definition\Header\Variable;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type PropsShape = array{
 *   mediaType: string,
 *   sample: string,
 *   url: string,
 *   variableType: string,
 *   alt?: string|null,
 *   regex?: string|null,
 *   shortURL?: string|null,
 * }
 */
final class Props implements BaseModel
{
    /** @use SdkModel<PropsShape> */
    use SdkModel;

    #[Required]
    public string $mediaType;

    #[Required]
    public string $sample;

    #[Required]
    public string $url;

    #[Required]
    public string $variableType;

    #[Optional(nullable: true)]
    public ?string $alt;

    #[Optional(nullable: true)]
    public ?string $regex;

    #[Optional('shortUrl', nullable: true)]
    public ?string $shortURL;

    /**
     * `new Props()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Props::with(mediaType: ..., sample: ..., url: ..., variableType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Props)
     *   ->withMediaType(...)
     *   ->withSample(...)
     *   ->withURL(...)
     *   ->withVariableType(...)
     * ```
     */
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
        string $mediaType,
        string $sample,
        string $url,
        string $variableType,
        ?string $alt = null,
        ?string $regex = null,
        ?string $shortURL = null,
    ): self {
        $self = new self;

        $self['mediaType'] = $mediaType;
        $self['sample'] = $sample;
        $self['url'] = $url;
        $self['variableType'] = $variableType;

        null !== $alt && $self['alt'] = $alt;
        null !== $regex && $self['regex'] = $regex;
        null !== $shortURL && $self['shortURL'] = $shortURL;

        return $self;
    }

    public function withMediaType(string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    public function withSample(string $sample): self
    {
        $self = clone $this;
        $self['sample'] = $sample;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withVariableType(string $variableType): self
    {
        $self = clone $this;
        $self['variableType'] = $variableType;

        return $self;
    }

    public function withAlt(?string $alt): self
    {
        $self = clone $this;
        $self['alt'] = $alt;

        return $self;
    }

    public function withRegex(?string $regex): self
    {
        $self = clone $this;
        $self['regex'] = $regex;

        return $self;
    }

    public function withShortURL(?string $shortURL): self
    {
        $self = clone $this;
        $self['shortURL'] = $shortURL;

        return $self;
    }
}
