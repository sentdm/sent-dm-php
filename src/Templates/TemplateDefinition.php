<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateDefinition\AuthenticationConfig;
use SentDm\Templates\TemplateDefinition\Body;
use SentDm\Templates\TemplateDefinition\Button;
use SentDm\Templates\TemplateDefinition\Footer;
use SentDm\Templates\TemplateDefinition\Header;

/**
 * Complete definition of a message template including header, body, footer, and buttons.
 *
 * @phpstan-import-type BodyShape from \SentDm\Templates\TemplateDefinition\Body
 * @phpstan-import-type AuthenticationConfigShape from \SentDm\Templates\TemplateDefinition\AuthenticationConfig
 * @phpstan-import-type ButtonShape from \SentDm\Templates\TemplateDefinition\Button
 * @phpstan-import-type FooterShape from \SentDm\Templates\TemplateDefinition\Footer
 * @phpstan-import-type HeaderShape from \SentDm\Templates\TemplateDefinition\Header
 *
 * @phpstan-type TemplateDefinitionShape = array{
 *   body: Body|BodyShape,
 *   authenticationConfig?: null|AuthenticationConfig|AuthenticationConfigShape,
 *   buttons?: list<Button|ButtonShape>|null,
 *   definitionVersion?: string|null,
 *   footer?: null|Footer|FooterShape,
 *   header?: null|Header|HeaderShape,
 * }
 */
final class TemplateDefinition implements BaseModel
{
    /** @use SdkModel<TemplateDefinitionShape> */
    use SdkModel;

    /**
     * Required template body with content for different channels (multi-channel, SMS-specific, or WhatsApp-specific).
     */
    #[Required]
    public Body $body;

    /**
     * Configuration specific to AUTHENTICATION category templates (optional).
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
     * Optional template footer with optional variables.
     */
    #[Optional(nullable: true)]
    public ?Footer $footer;

    /**
     * Optional template header with optional variables.
     */
    #[Optional(nullable: true)]
    public ?Header $header;

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
     * Required template body with content for different channels (multi-channel, SMS-specific, or WhatsApp-specific).
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
     * Configuration specific to AUTHENTICATION category templates (optional).
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
     * Optional template footer with optional variables.
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
     * Optional template header with optional variables.
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
