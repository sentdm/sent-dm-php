<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateCreateParams\Definition;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateCreateParams\Definition\Button\Props;

/**
 * Interactive button in a message template.
 *
 * @phpstan-import-type PropsShape from \SentDm\Templates\TemplateCreateParams\Definition\Button\Props
 *
 * @phpstan-type ButtonShape = array{
 *   props: Props|PropsShape, type: string, id?: int|null
 * }
 */
final class Button implements BaseModel
{
    /** @use SdkModel<ButtonShape> */
    use SdkModel;

    /**
     * Properties specific to the button type.
     */
    #[Required]
    public Props $props;

    /**
     * The type of button (e.g., QUICK_REPLY, URL, PHONE_NUMBER, VOICE_CALL, COPY_CODE).
     */
    #[Required]
    public string $type;

    /**
     * The unique identifier of the button (1-based index).
     */
    #[Optional]
    public ?int $id;

    /**
     * `new Button()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Button::with(props: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Button)->withProps(...)->withType(...)
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
     *
     * @param Props|PropsShape $props
     */
    public static function with(
        Props|array $props,
        string $type,
        ?int $id = null
    ): self {
        $self = new self;

        $self['props'] = $props;
        $self['type'] = $type;

        null !== $id && $self['id'] = $id;

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

    /**
     * The unique identifier of the button (1-based index).
     */
    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
