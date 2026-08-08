<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Complete definition of a message template including header, body, footer, and buttons.
 *
 * @phpstan-import-type TemplateBodyShape from \SentDm\Templates\TemplateBody
 * @phpstan-import-type AuthenticationConfigShape from \SentDm\Templates\AuthenticationConfig
 * @phpstan-import-type TemplateButtonShape from \SentDm\Templates\TemplateButton
 * @phpstan-import-type TemplateFooterShape from \SentDm\Templates\TemplateFooter
 * @phpstan-import-type TemplateHeaderShape from \SentDm\Templates\TemplateHeader
 *
 * @phpstan-type TemplateDefinitionShape = array{
 *   body: TemplateBody|TemplateBodyShape,
 *   authenticationConfig?: null|AuthenticationConfig|AuthenticationConfigShape,
 *   buttons?: list<TemplateButton|TemplateButtonShape>|null,
 *   definitionVersion?: string|null,
 *   footer?: null|TemplateFooter|TemplateFooterShape,
 *   header?: null|TemplateHeader|TemplateHeaderShape,
 * }
 */
final class TemplateDefinition implements BaseModel
{
    /** @use SdkModel<TemplateDefinitionShape> */
    use SdkModel;

    /**
     * Body section of a message template with channel-specific content.
     */
    #[Required]
    public TemplateBody $body;

    /**
     * Configuration for AUTHENTICATION category templates.
     */
    #[Optional(nullable: true)]
    public ?AuthenticationConfig $authenticationConfig;

    /**
     * Optional list of interactive buttons (e.g., quick replies, URLs, phone numbers).
     *
     * @var list<TemplateButton>|null $buttons
     */
    #[Optional(list: TemplateButton::class, nullable: true)]
    public ?array $buttons;

    /**
     * The version of the template definition format.
     */
    #[Optional(nullable: true)]
    public ?string $definitionVersion;

    /**
     * Footer section of a message template.
     */
    #[Optional(nullable: true)]
    public ?TemplateFooter $footer;

    /**
     * Header section of a message template.
     */
    #[Optional(nullable: true)]
    public ?TemplateHeader $header;

    /**
     * `new TemplateDefinition()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateDefinition::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateDefinition)->withBody(...)
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
     * @param TemplateBody|TemplateBodyShape $body
     * @param AuthenticationConfig|AuthenticationConfigShape|null $authenticationConfig
     * @param list<TemplateButton|TemplateButtonShape>|null $buttons
     * @param TemplateFooter|TemplateFooterShape|null $footer
     * @param TemplateHeader|TemplateHeaderShape|null $header
     */
    public static function with(
        TemplateBody|array $body,
        AuthenticationConfig|array|null $authenticationConfig = null,
        ?array $buttons = null,
        ?string $definitionVersion = null,
        TemplateFooter|array|null $footer = null,
        TemplateHeader|array|null $header = null,
    ): self {
        $self = new self;

        $self['body'] = $body;

        null !== $authenticationConfig && $self['authenticationConfig'] = $authenticationConfig;
        null !== $buttons && $self['buttons'] = $buttons;
        null !== $definitionVersion && $self['definitionVersion'] = $definitionVersion;
        null !== $footer && $self['footer'] = $footer;
        null !== $header && $self['header'] = $header;

        return $self;
    }

    /**
     * Body section of a message template with channel-specific content.
     *
     * @param TemplateBody|TemplateBodyShape $body
     */
    public function withBody(TemplateBody|array $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Configuration for AUTHENTICATION category templates.
     *
     * @param AuthenticationConfig|AuthenticationConfigShape|null $authenticationConfig
     */
    public function withAuthenticationConfig(
        AuthenticationConfig|array|null $authenticationConfig
    ): self {
        $self = clone $this;
        $self['authenticationConfig'] = $authenticationConfig;

        return $self;
    }

    /**
     * Optional list of interactive buttons (e.g., quick replies, URLs, phone numbers).
     *
     * @param list<TemplateButton|TemplateButtonShape>|null $buttons
     */
    public function withButtons(?array $buttons): self
    {
        $self = clone $this;
        $self['buttons'] = $buttons;

        return $self;
    }

    /**
     * The version of the template definition format.
     */
    public function withDefinitionVersion(?string $definitionVersion): self
    {
        $self = clone $this;
        $self['definitionVersion'] = $definitionVersion;

        return $self;
    }

    /**
     * Footer section of a message template.
     *
     * @param TemplateFooter|TemplateFooterShape|null $footer
     */
    public function withFooter(TemplateFooter|array|null $footer): self
    {
        $self = clone $this;
        $self['footer'] = $footer;

        return $self;
    }

    /**
     * Header section of a message template.
     *
     * @param TemplateHeader|TemplateHeaderShape|null $header
     */
    public function withHeader(TemplateHeader|array|null $header): self
    {
        $self = clone $this;
        $self['header'] = $header;

        return $self;
    }
}
