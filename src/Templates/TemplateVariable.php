<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateVariable\Props;

/**
 * @phpstan-import-type PropsShape from \SentDm\Templates\TemplateVariable\Props
 *
 * @phpstan-type TemplateVariableShape = array{
 *   name: string, props: Props|PropsShape, type: string, id?: int|null
 * }
 */
final class TemplateVariable implements BaseModel
{
    /** @use SdkModel<TemplateVariableShape> */
    use SdkModel;

    /**
     * The variable's name, and the key callers use for it in a send request's parameters object.
     * Must start with a letter and hold only letters, digits and underscores.
     */
    #[Required]
    public string $name;

    #[Required]
    public Props $props;

    /**
     * One of variable, link or media. Decides which Props fields
     * are required.
     */
    #[Required]
    public string $type;

    /**
     * The variable's index, and the number its {{index:variable}} placeholder refers to.
     *
     * Omitting it is only safe for a section holding a single variable. The field is a
     * non-nullable int, so every variable that leaves it out defaults to 0, and a section with two
     * such variables is refused by the unique-id rule ("variables must have unique IDs"). Number
     * them from 0 in the order they appear.
     */
    #[Optional]
    public ?int $id;

    /**
     * `new TemplateVariable()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateVariable::with(name: ..., props: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateVariable)->withName(...)->withProps(...)->withType(...)
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
        string $name,
        Props|array $props,
        string $type,
        ?int $id = null
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['props'] = $props;
        $self['type'] = $type;

        null !== $id && $self['id'] = $id;

        return $self;
    }

    /**
     * The variable's name, and the key callers use for it in a send request's parameters object.
     * Must start with a letter and hold only letters, digits and underscores.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param Props|PropsShape $props
     */
    public function withProps(Props|array $props): self
    {
        $self = clone $this;
        $self['props'] = $props;

        return $self;
    }

    /**
     * One of variable, link or media. Decides which Props fields
     * are required.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The variable's index, and the number its {{index:variable}} placeholder refers to.
     *
     * Omitting it is only safe for a section holding a single variable. The field is a
     * non-nullable int, so every variable that leaves it out defaults to 0, and a section with two
     * such variables is refused by the unique-id rule ("variables must have unique IDs"). Number
     * them from 0 in the order they appear.
     */
    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
