<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateVariable;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type PropsShape = array{
 *   alt?: string|null,
 *   mediaType?: string|null,
 *   regex?: string|null,
 *   sample?: string|null,
 *   shortURL?: string|null,
 *   url?: string|null,
 *   variableType?: string|null,
 * }
 */
final class Props implements BaseModel
{
    /** @use SdkModel<PropsShape> */
    use SdkModel;

    #[Optional(nullable: true)]
    public ?string $alt;

    #[Optional(nullable: true)]
    public ?string $mediaType;

    #[Optional(nullable: true)]
    public ?string $regex;

    #[Optional(nullable: true)]
    public ?string $sample;

    #[Optional('shortUrl', nullable: true)]
    public ?string $shortURL;

    #[Optional(nullable: true)]
    public ?string $url;

    #[Optional(nullable: true)]
    public ?string $variableType;

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
        ?string $alt = null,
        ?string $mediaType = null,
        ?string $regex = null,
        ?string $sample = null,
        ?string $shortURL = null,
        ?string $url = null,
        ?string $variableType = null,
    ): self {
        $self = new self;

        null !== $alt && $self['alt'] = $alt;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $regex && $self['regex'] = $regex;
        null !== $sample && $self['sample'] = $sample;
        null !== $shortURL && $self['shortURL'] = $shortURL;
        null !== $url && $self['url'] = $url;
        null !== $variableType && $self['variableType'] = $variableType;

        return $self;
    }

    public function withAlt(?string $alt): self
    {
        $self = clone $this;
        $self['alt'] = $alt;

        return $self;
    }

    public function withMediaType(?string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    public function withRegex(?string $regex): self
    {
        $self = clone $this;
        $self['regex'] = $regex;

        return $self;
    }

    public function withSample(?string $sample): self
    {
        $self = clone $this;
        $self['sample'] = $sample;

        return $self;
    }

    public function withShortURL(?string $shortURL): self
    {
        $self = clone $this;
        $self['shortURL'] = $shortURL;

        return $self;
    }

    public function withURL(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withVariableType(?string $variableType): self
    {
        $self = clone $this;
        $self['variableType'] = $variableType;

        return $self;
    }
}
