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
 * @phpstan-import-type SentDmServicesCommonContractsPocOsTemplateBodyShape from \SentDm\Templates\SentDmServicesCommonContractsPocOsTemplateBody
 * @phpstan-import-type SentDmServicesCommonContractsPocOsAuthenticationConfigShape from \SentDm\Templates\SentDmServicesCommonContractsPocOsAuthenticationConfig
 * @phpstan-import-type SentDmServicesCommonContractsPocOsTemplateButtonShape from \SentDm\Templates\SentDmServicesCommonContractsPocOsTemplateButton
 * @phpstan-import-type SentDmServicesCommonContractsPocOsTemplateFooterShape from \SentDm\Templates\SentDmServicesCommonContractsPocOsTemplateFooter
 * @phpstan-import-type SentDmServicesCommonContractsPocOsTemplateHeaderShape from \SentDm\Templates\SentDmServicesCommonContractsPocOsTemplateHeader
 *
 * @phpstan-type TemplateDefinitionShape = array{
 *   body: SentDmServicesCommonContractsPocOsTemplateBody|SentDmServicesCommonContractsPocOsTemplateBodyShape,
 *   authenticationConfig?: null|SentDmServicesCommonContractsPocOsAuthenticationConfig|SentDmServicesCommonContractsPocOsAuthenticationConfigShape,
 *   buttons?: list<SentDmServicesCommonContractsPocOsTemplateButton|SentDmServicesCommonContractsPocOsTemplateButtonShape>|null,
 *   definitionVersion?: string|null,
 *   footer?: null|SentDmServicesCommonContractsPocOsTemplateFooter|SentDmServicesCommonContractsPocOsTemplateFooterShape,
 *   header?: null|SentDmServicesCommonContractsPocOsTemplateHeader|SentDmServicesCommonContractsPocOsTemplateHeaderShape,
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
    public SentDmServicesCommonContractsPocOsTemplateBody $body;

    /**
     * Configuration specific to AUTHENTICATION category templates (optional).
     */
    #[Optional(nullable: true)]
    public ?SentDmServicesCommonContractsPocOsAuthenticationConfig $authenticationConfig;

    /**
     * Optional list of interactive buttons (e.g., quick replies, URLs, phone numbers).
     *
     * @var list<SentDmServicesCommonContractsPocOsTemplateButton>|null $buttons
     */
    #[Optional(
        list: SentDmServicesCommonContractsPocOsTemplateButton::class,
        nullable: true,
    )]
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
    public ?SentDmServicesCommonContractsPocOsTemplateFooter $footer;

    /**
     * Optional template header with optional variables.
     */
    #[Optional(nullable: true)]
    public ?SentDmServicesCommonContractsPocOsTemplateHeader $header;

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
     * @param SentDmServicesCommonContractsPocOsTemplateBody|SentDmServicesCommonContractsPocOsTemplateBodyShape $body
     * @param SentDmServicesCommonContractsPocOsAuthenticationConfig|SentDmServicesCommonContractsPocOsAuthenticationConfigShape|null $authenticationConfig
     * @param list<SentDmServicesCommonContractsPocOsTemplateButton|SentDmServicesCommonContractsPocOsTemplateButtonShape>|null $buttons
     * @param SentDmServicesCommonContractsPocOsTemplateFooter|SentDmServicesCommonContractsPocOsTemplateFooterShape|null $footer
     * @param SentDmServicesCommonContractsPocOsTemplateHeader|SentDmServicesCommonContractsPocOsTemplateHeaderShape|null $header
     */
    public static function with(
        SentDmServicesCommonContractsPocOsTemplateBody|array $body,
        SentDmServicesCommonContractsPocOsAuthenticationConfig|array|null $authenticationConfig = null,
        ?array $buttons = null,
        ?string $definitionVersion = null,
        SentDmServicesCommonContractsPocOsTemplateFooter|array|null $footer = null,
        SentDmServicesCommonContractsPocOsTemplateHeader|array|null $header = null,
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
     * @param SentDmServicesCommonContractsPocOsTemplateBody|SentDmServicesCommonContractsPocOsTemplateBodyShape $body
     */
    public function withBody(
        SentDmServicesCommonContractsPocOsTemplateBody|array $body
    ): self {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Configuration specific to AUTHENTICATION category templates (optional).
     *
     * @param SentDmServicesCommonContractsPocOsAuthenticationConfig|SentDmServicesCommonContractsPocOsAuthenticationConfigShape|null $authenticationConfig
     */
    public function withAuthenticationConfig(
        SentDmServicesCommonContractsPocOsAuthenticationConfig|array|null $authenticationConfig,
    ): self {
        $self = clone $this;
        $self['authenticationConfig'] = $authenticationConfig;

        return $self;
    }

    /**
     * Optional list of interactive buttons (e.g., quick replies, URLs, phone numbers).
     *
     * @param list<SentDmServicesCommonContractsPocOsTemplateButton|SentDmServicesCommonContractsPocOsTemplateButtonShape>|null $buttons
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
     * @param SentDmServicesCommonContractsPocOsTemplateFooter|SentDmServicesCommonContractsPocOsTemplateFooterShape|null $footer
     */
    public function withFooter(
        SentDmServicesCommonContractsPocOsTemplateFooter|array|null $footer
    ): self {
        $self = clone $this;
        $self['footer'] = $footer;

        return $self;
    }

    /**
     * Optional template header with optional variables.
     *
     * @param SentDmServicesCommonContractsPocOsTemplateHeader|SentDmServicesCommonContractsPocOsTemplateHeaderShape|null $header
     */
    public function withHeader(
        SentDmServicesCommonContractsPocOsTemplateHeader|array|null $header
    ): self {
        $self = clone $this;
        $self['header'] = $header;

        return $self;
    }
}
