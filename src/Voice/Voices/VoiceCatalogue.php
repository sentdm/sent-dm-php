<?php

declare(strict_types=1);

namespace SentDm\Voice\Voices;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The voices and languages a text-session agent may name in its speech settings: what
 * GET /v3/voice/voices and the admin GET /voice/voices answer, in one shape.
 *
 * @phpstan-import-type VoiceCatalogueVoiceShape from \SentDm\Voice\Voices\VoiceCatalogueVoice
 *
 * @phpstan-type VoiceCatalogueShape = array{
 *   languages?: list<string>|null,
 *   voices?: list<VoiceCatalogueVoice|VoiceCatalogueVoiceShape>|null,
 * }
 */
final class VoiceCatalogue implements BaseModel
{
    /** @use SdkModel<VoiceCatalogueShape> */
    use SdkModel;

    /**
     * BCP 47 tags accepted as speech.language.
     *
     * @var list<string>|null $languages
     */
    #[Optional(list: 'string')]
    public ?array $languages;

    /** @var list<VoiceCatalogueVoice>|null $voices */
    #[Optional(list: VoiceCatalogueVoice::class)]
    public ?array $voices;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $languages
     * @param list<VoiceCatalogueVoice|VoiceCatalogueVoiceShape>|null $voices
     */
    public static function with(
        ?array $languages = null,
        ?array $voices = null
    ): self {
        $self = new self;

        null !== $languages && $self['languages'] = $languages;
        null !== $voices && $self['voices'] = $voices;

        return $self;
    }

    /**
     * BCP 47 tags accepted as speech.language.
     *
     * @param list<string> $languages
     */
    public function withLanguages(array $languages): self
    {
        $self = clone $this;
        $self['languages'] = $languages;

        return $self;
    }

    /**
     * @param list<VoiceCatalogueVoice|VoiceCatalogueVoiceShape> $voices
     */
    public function withVoices(array $voices): self
    {
        $self = clone $this;
        $self['voices'] = $voices;

        return $self;
    }
}
