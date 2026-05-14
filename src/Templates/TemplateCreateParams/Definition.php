<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateCreateParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateCreateParams\Definition\AuthenticationConfig;
use SentDm\Templates\TemplateCreateParams\Definition\Body;
use SentDm\Templates\TemplateCreateParams\Definition\Button;
use SentDm\Templates\TemplateCreateParams\Definition\Footer;
use SentDm\Templates\TemplateCreateParams\Definition\Header;

/**
 * Complete definition of a message template including header, body, footer, and buttons.
 *
 * @phpstan-import-type BodyShape from \SentDm\Templates\TemplateCreateParams\Definition\Body
 * @phpstan-import-type AuthenticationConfigShape from \SentDm\Templates\TemplateCreateParams\Definition\AuthenticationConfig
 * @phpstan-import-type ButtonShape from \SentDm\Templates\TemplateCreateParams\Definition\Button
 * @phpstan-import-type FooterShape from \SentDm\Templates\TemplateCreateParams\Definition\Footer
 * @phpstan-import-type HeaderShape from \SentDm\Templates\TemplateCreateParams\Definition\Header
 *
 * @phpstan-type DefinitionShape = array{
 *   body: Body|BodyShape,
 *   authenticationConfig?: null|AuthenticationConfig|AuthenticationConfigShape,
 *   buttons?: list<Button|ButtonShape>|null,
 *   definitionVersion?: string|null,
 *   footer?: null|Footer|FooterShape,
 *   header?: null|Header|HeaderShape,
 * }
 */
final class Definition implements BaseModel
{
    /** @use SdkModel<DefinitionShape> */
    use SdkModel;

    /**
     * Body section of a message template with channel-specific content.
     */
    #[Required]
    public Body $body;

    /**
     * Configuration for AUTHENTICATION category templates.
     */
    #[Optional(nullable: true)]
    public ?AuthenticationConfig $authenticationConfig;

    /**
     * Optional list of interactive buttons (e.g., quick replies, URLs, phone numbers).
     *
     * @var list<Button>|null $buttons
     */
    #[Optional(list: Button::class, nullable: true)]
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
    public ?Footer $footer;

    /**
     * Header section of a message template.
     */
    #[Optional(nullable: true)]
    public ?Header $header;

    /**
     * `new Definition()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Definition::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Definition)->withBody(...)
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
     * @param Body|BodyShape $body
     * @param AuthenticationConfig|AuthenticationConfigShape|null $authenticationConfig
     * @param list<Button|ButtonShape>|null $buttons
     * @param Footer|FooterShape|null $footer
     * @param Header|HeaderShape|null $header
     */
    public static function with(
        Body|array $body,
        AuthenticationConfig|array|null $authenticationConfig = null,
        ?array $buttons = null,
        ?string $definitionVersion = null,
        Footer|array|null $footer = null,
        Header|array|null $header = null,
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
     * @param Body|BodyShape $body
     */
    public function withBody(Body|array $body): self
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
     * @param list<Button|ButtonShape>|null $buttons
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
     * @param Footer|FooterShape|null $footer
     */
    public function withFooter(Footer|array|null $footer): self
    {
        $self = clone $this;
        $self['footer'] = $footer;

        return $self;
    }

    /**
     * Header section of a message template.
     *
     * @param Header|HeaderShape|null $header
     */
    public function withHeader(Header|array|null $header): self
    {
        $self = clone $this;
        $self['header'] = $header;

        return $self;
    }
}
