<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateDefinition;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateVariable;

/**
 * Header section of a message template.
 *
 * @phpstan-import-type TemplateVariableShape from \SentDm\Templates\TemplateVariable
 *
 * @phpstan-type HeaderShape = array{
 *   template?: string|null,
 *   type?: string|null,
 *   variables?: list<TemplateVariable|TemplateVariableShape>|null,
 * }
 */
final class Header implements BaseModel
{
    /** @use SdkModel<HeaderShape> */
    use SdkModel;

    /**
     * The header template text with optional variable placeholders (e.g., "Welcome to {{0:variable}}").
     */
    #[Optional]
    public ?string $template;

    /**
     * The type of header (e.g., "text", "image", "video", "document").
     */
    #[Optional(nullable: true)]
    public ?string $type;

    /**
     * List of variables used in the header template.
     *
     * @var list<TemplateVariable>|null $variables
     */
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

    /**
     * The header template text with optional variable placeholders (e.g., "Welcome to {{0:variable}}").
     */
    public function withTemplate(string $template): self
    {
        $self = clone $this;
        $self['template'] = $template;

        return $self;
    }

    /**
     * The type of header (e.g., "text", "image", "video", "document").
     */
    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * List of variables used in the header template.
     *
     * @param list<TemplateVariable|TemplateVariableShape>|null $variables
     */
    public function withVariables(?array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }
}
