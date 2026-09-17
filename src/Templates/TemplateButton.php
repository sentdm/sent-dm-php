<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Interactive button in a message template.
 *
 * @phpstan-import-type TemplateButtonPropsShape from \SentDm\Templates\TemplateButtonProps
 *
 * @phpstan-type TemplateButtonShape = array{
 *   props: TemplateButtonProps|TemplateButtonPropsShape,
 *   type: string,
 *   id?: int|null,
 * }
 */
final class TemplateButton implements BaseModel
{
    /** @use SdkModel<TemplateButtonShape> */
    use SdkModel;

    /**
     * Properties specific to the button type.
     */
    #[Required]
    public TemplateButtonProps $props;

    /**
     * The type of button (e.g., QUICK_REPLY, URL, PHONE_NUMBER, VOICE_CALL, COPY_CODE).
     */
    #[Required]
    public string $type;

    /**
     * The button's identifier (1-based index), unique within the template.
     *
     * Omitting it is only safe for a template holding a single button. The field is a
     * non-nullable int, so every button that leaves it out defaults to 0, and two such buttons are
     * refused by the unique-id rule ("Button IDs must be unique"). Number them from 1 in the order
     * they should appear — order matters on RCS, where only the first four buttons render.
     */
    #[Optional]
    public ?int $id;

    /**
     * `new TemplateButton()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateButton::with(props: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateButton)->withProps(...)->withType(...)
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
     * @param TemplateButtonProps|TemplateButtonPropsShape $props
     */
    public static function with(
        TemplateButtonProps|array $props,
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
     * @param TemplateButtonProps|TemplateButtonPropsShape $props
     */
    public function withProps(TemplateButtonProps|array $props): self
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
     * The button's identifier (1-based index), unique within the template.
     *
     * Omitting it is only safe for a template holding a single button. The field is a
     * non-nullable int, so every button that leaves it out defaults to 0, and two such buttons are
     * refused by the unique-id rule ("Button IDs must be unique"). Number them from 1 in the order
     * they should appear — order matters on RCS, where only the first four buttons render.
     */
    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
