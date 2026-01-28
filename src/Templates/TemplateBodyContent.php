<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TemplateVariableShape from \SentDm\Templates\TemplateVariable
 *
 * @phpstan-type TemplateBodyContentShape = array{
 *   template?: string|null,
 *   type?: string|null,
 *   variables?: list<TemplateVariable|TemplateVariableShape>|null,
 * }
 */
final class TemplateBodyContent implements BaseModel
{
    /** @use SdkModel<TemplateBodyContentShape> */
    use SdkModel;

    #[Optional]
    public ?string $template;

    #[Optional(nullable: true)]
    public ?string $type;

    /** @var list<TemplateVariable>|null $variables */
    #[Optional(list: TemplateVariable::class, nullable: true)]
    public ?array $variables;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<TemplateVariable|TemplateVariableShape>|null $variables
     */
    public static function with(
        ?string $template = null,
        ?string $type = null,
        ?array $variables = null
    ): self {
        $self = new self;

        null !== $template && $self['template'] = $template;
        null !== $type && $self['type'] = $type;
        null !== $variables && $self['variables'] = $variables;

        return $self;
    }

    public function withTemplate(string $template): self
    {
        $self = clone $this;
        $self['template'] = $template;

        return $self;
    }

    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param list<TemplateVariable|TemplateVariableShape>|null $variables
     */
    public function withVariables(?array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }
}
