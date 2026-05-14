<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetStatusResponse\Data\MessageBody;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type ButtonShape = array{
 *   postbackData?: string|null,
 *   text?: string|null,
 *   type?: string|null,
 *   value?: string|null,
 * }
 */
final class Button implements BaseModel
{
    /** @use SdkModel<ButtonShape> */
    use SdkModel;

    #[Optional(nullable: true)]
    public ?string $postbackData;

    #[Optional(nullable: true)]
    public ?string $text;

    #[Optional]
    public ?string $type;

    #[Optional]
    public ?string $value;

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
        ?string $postbackData = null,
        ?string $text = null,
        ?string $type = null,
        ?string $value = null,
    ): self {
        $self = new self;

        null !== $postbackData && $self['postbackData'] = $postbackData;
        null !== $text && $self['text'] = $text;
        null !== $type && $self['type'] = $type;
        null !== $value && $self['value'] = $value;

        return $self;
    }

    public function withPostbackData(?string $postbackData): self
    {
        $self = clone $this;
        $self['postbackData'] = $postbackData;

        return $self;
    }

    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
