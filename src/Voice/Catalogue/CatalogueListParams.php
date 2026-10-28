<?php

declare(strict_types=1);

namespace SentDm\Voice\Catalogue;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * The names a voice agent's `speech.voice` and `speech.language` accept, with the default marked. The list grows as voices are added; a name is never removed without notice.
 *
 * @see SentDm\Services\Voice\CatalogueService::list()
 *
 * @phpstan-type CatalogueListParamsShape = array{xProfileID?: string|null}
 */
final class CatalogueListParams implements BaseModel
{
    /** @use SdkModel<CatalogueListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $xProfileID = null): self
    {
        $self = new self;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
