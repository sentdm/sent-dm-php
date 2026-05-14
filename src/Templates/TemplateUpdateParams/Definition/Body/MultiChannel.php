<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateUpdateParams\Definition\Body;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateUpdateParams\Definition\Body\MultiChannel\Variable;

/**
 * Content that will be used for all channels (SMS and WhatsApp) unless channel-specific content is provided.
 *
 * @phpstan-import-type VariableShape from \SentDm\Templates\TemplateUpdateParams\Definition\Body\MultiChannel\Variable
 *
 * @phpstan-type MultiChannelShape = array{
 *   template: string,
 *   type?: string|null,
 *   variables?: list<Variable|VariableShape>|null,
 * }
 */
final class MultiChannel implements BaseModel
{
    /** @use SdkModel<MultiChannelShape> */
    use SdkModel;

    #[Required]
    public string $template;

    #[Optional(nullable: true)]
    public ?string $type;

    /** @var list<Variable>|null $variables */
    #[Optional(list: Variable::class, nullable: true)]
    public ?array $variables;

    /**
     * `new MultiChannel()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MultiChannel::with(template: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MultiChannel)->withTemplate(...)
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
     * @param list<Variable|VariableShape>|null $variables
     */
    public function withVariables(?array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }
}
