<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateDefinition;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateDefinition\Button\Props;

/**
 * Interactive button in a message template.
 *
 * @phpstan-import-type PropsShape from \SentDm\Templates\TemplateDefinition\Button\Props
 *
 * @phpstan-type ButtonShape = array{
 *   id?: int|null, props?: null|Props|PropsShape, type?: string|null
 * }
 */
final class Button implements BaseModel
{
    /** @use SdkModel<ButtonShape> */
    use SdkModel;

    /**
     * The unique identifier of the button (1-based index).
     */
    #[Optional]
    public ?int $id;

    /**
     * Properties specific to the button type.
     */
    #[Optional]
    public ?Props $props;

    /**
     * The type of button (e.g., QUICK_REPLY, URL, PHONE_NUMBER, VOICE_CALL, COPY_CODE).
     */
    #[Optional]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Props|PropsShape|null $props
     */
    public static function with(
        ?int $id = null,
        Props|array|null $props = null,
        ?string $type = null
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $props && $self['props'] = $props;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * The unique identifier of the button (1-based index).
     */
    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Properties specific to the button type.
     *
     * @param Props|PropsShape $props
     */
    public function withProps(Props|array $props): self
    {
        $self = clone $this;
        $self['props'] = $props;

        return $self;
    }

    /**
     * The type of button (e.g., QUICK_REPLY, URL, PHONE_NUMBER, VOICE_CALL, COPY_CODE).
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
