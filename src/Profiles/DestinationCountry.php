<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type DestinationCountryShape = array{
 *   id?: string|null, isMain?: bool|null
 * }
 */
final class DestinationCountry implements BaseModel
{
    /** @use SdkModel<DestinationCountryShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional]
    public ?bool $isMain;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $id = null, ?bool $isMain = null): self
    {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $isMain && $self['isMain'] = $isMain;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withIsMain(bool $isMain): self
    {
        $self = clone $this;
        $self['isMain'] = $isMain;

        return $self;
    }
}
