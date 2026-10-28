<?php

declare(strict_types=1);

namespace SentDm\Voice\Catalogue;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type VoiceCatalogueVoiceShape = array{
 *   default?: bool|null,
 *   description?: string|null,
 *   language?: string|null,
 *   name?: string|null,
 * }
 */
final class VoiceCatalogueVoice implements BaseModel
{
    /** @use SdkModel<VoiceCatalogueVoiceShape> */
    use SdkModel;

    /**
     * Whether this is the voice used when an agent names none.
     */
    #[Optional]
    public ?bool $default;

    #[Optional]
    public ?string $description;

    /**
     * The language the voice speaks.
     */
    #[Optional]
    public ?string $language;

    /**
     * The value to send as speech.voice.
     */
    #[Optional]
    public ?string $name;

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
        ?bool $default = null,
        ?string $description = null,
        ?string $language = null,
        ?string $name = null,
    ): self {
        $self = new self;

        null !== $default && $self['default'] = $default;
        null !== $description && $self['description'] = $description;
        null !== $language && $self['language'] = $language;
        null !== $name && $self['name'] = $name;

        return $self;
    }

    /**
     * Whether this is the voice used when an agent names none.
     */
    public function withDefault(bool $default): self
    {
        $self = clone $this;
        $self['default'] = $default;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The language the voice speaks.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * The value to send as speech.voice.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
