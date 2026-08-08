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
     * The unique identifier of the button (1-based index).
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
     * The unique identifier of the button (1-based index).
     */
    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
