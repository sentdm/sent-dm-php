<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateVariable\Props;

/**
 * @phpstan-import-type PropsShape from \SentDm\Templates\TemplateVariable\Props
 *
 * @phpstan-type TemplateVariableShape = array{
 *   id?: int|null,
 *   name?: string|null,
 *   props?: null|Props|PropsShape,
 *   type?: string|null,
 * }
 */
final class TemplateVariable implements BaseModel
{
    /** @use SdkModel<TemplateVariableShape> */
    use SdkModel;

    #[Optional]
    public ?int $id;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?Props $props;

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
        ?string $name = null,
        Props|array|null $props = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $name && $self['name'] = $name;
        null !== $props && $self['props'] = $props;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
}
