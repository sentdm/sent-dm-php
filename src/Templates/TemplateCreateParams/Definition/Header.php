<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateCreateParams\Definition;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateCreateParams\Definition\Header\Variable;

/**
 * Header section of a message template.
 *
 * @phpstan-import-type VariableShape from \SentDm\Templates\TemplateCreateParams\Definition\Header\Variable
 *
 * @phpstan-type HeaderShape = array{
 *   template: string,
 *   type?: string|null,
 *   variables?: list<Variable|VariableShape>|null,
 * }
 */
final class Header implements BaseModel
{
    /** @use SdkModel<HeaderShape> */
    use SdkModel;

    /**
     * The header template text with optional variable placeholders (e.g., "Welcome to {{0:variable}}").
     */
    #[Required]
    public string $template;

    /**
     * The type of header (e.g., "text", "image", "video", "document").
     */
    #[Optional(nullable: true)]
    public ?string $type;

    /**
     * List of variables used in the header template.
     *
     * @var list<Variable>|null $variables
     */
    #[Optional(list: Variable::class, nullable: true)]
    public ?array $variables;

    /**
     * `new Header()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Header::with(template: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Header)->withTemplate(...)
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
     * @param list<Variable|VariableShape>|null $variables
     */
    public static function with(
        string $template,
        ?string $type = null,
        ?array $variables = null
    ): self {
        $self = new self;

        $self['template'] = $template;

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
     * @param list<Variable|VariableShape>|null $variables
     */
    public function withVariables(?array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }
}
