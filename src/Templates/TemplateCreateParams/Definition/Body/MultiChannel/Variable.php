<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateCreateParams\Definition\Body\MultiChannel;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateCreateParams\Definition\Body\MultiChannel\Variable\Props;

/**
 * @phpstan-import-type PropsShape from \SentDm\Templates\TemplateCreateParams\Definition\Body\MultiChannel\Variable\Props
 *
 * @phpstan-type VariableShape = array{
 *   name: string, props: Props|PropsShape, type: string, id?: int|null
 * }
 */
final class Variable implements BaseModel
{
    /** @use SdkModel<VariableShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Required]
    public Props $props;

    #[Required]
    public string $type;

    #[Optional]
    public ?int $id;

    /**
     * `new Variable()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Variable::with(name: ..., props: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Variable)->withName(...)->withProps(...)->withType(...)
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

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
