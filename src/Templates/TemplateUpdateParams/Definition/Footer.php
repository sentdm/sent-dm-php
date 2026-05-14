<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateUpdateParams\Definition;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateUpdateParams\Definition\Footer\Variable;

/**
 * Footer section of a message template.
 *
 * @phpstan-import-type VariableShape from \SentDm\Templates\TemplateUpdateParams\Definition\Footer\Variable
 *
 * @phpstan-type FooterShape = array{
 *   template: string,
 *   type?: string|null,
 *   variables?: list<Variable|VariableShape>|null,
 * }
 */
final class Footer implements BaseModel
{
    /** @use SdkModel<FooterShape> */
    use SdkModel;

    /**
     * The footer template text with optional variable placeholders.
     */
    #[Required]
    public string $template;

    /**
     * The type of footer (typically "text").
     */
    #[Optional(nullable: true)]
    public ?string $type;

    /**
     * List of variables used in the footer template.
     *
     * @var list<Variable>|null $variables
     */
    #[Optional(list: Variable::class, nullable: true)]
    public ?array $variables;

    /**
     * `new Footer()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Footer::with(template: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Footer)->withTemplate(...)
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
     * The footer template text with optional variable placeholders.
     */
    public function withTemplate(string $template): self
    {
        $self = clone $this;
        $self['template'] = $template;

        return $self;
    }

    /**
     * The type of footer (typically "text").
     */
    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * List of variables used in the footer template.
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
