<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageSendParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * SDK-style template reference: resolve by ID or by name, with optional parameters.
 *
 * @phpstan-type TemplateShape = array{
 *   id?: string|null, name?: string|null, parameters?: array<string,string>|null
 * }
 */
final class Template implements BaseModel
{
    /** @use SdkModel<TemplateShape> */
    use SdkModel;

    /**
     * Template ID (mutually exclusive with name).
     */
    #[Optional(nullable: true)]
    public ?string $id;

    /**
     * Template name (mutually exclusive with id).
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Template variable parameters for personalization.
     *
     * @var array<string,string>|null $parameters
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $parameters;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string>|null $parameters
     */
    public static function with(
        ?string $id = null,
        ?string $name = null,
        ?array $parameters = null
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $name && $self['name'] = $name;
        null !== $parameters && $self['parameters'] = $parameters;

        return $self;
    }

    /**
     * Template ID (mutually exclusive with name).
     */
    public function withID(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Template name (mutually exclusive with id).
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Template variable parameters for personalization.
     *
     * @param array<string,string>|null $parameters
     */
    public function withParameters(?array $parameters): self
    {
        $self = clone $this;
        $self['parameters'] = $parameters;

        return $self;
    }
}
