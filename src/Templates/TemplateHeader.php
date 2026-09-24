<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateHeader\Location;

/**
 * Header section of a message template.
 *
 * @phpstan-import-type LocationShape from \SentDm\Templates\TemplateHeader\Location
 * @phpstan-import-type TemplateVariableShape from \SentDm\Templates\TemplateVariable
 *
 * @phpstan-type TemplateHeaderShape = array{
 *   template: string,
 *   exampleURL?: string|null,
 *   location?: null|Location|LocationShape,
 *   staticResource?: bool|null,
 *   type?: string|null,
 *   variables?: list<TemplateVariable|TemplateVariableShape>|null,
 * }
 */
final class TemplateHeader implements BaseModel
{
    /** @use SdkModel<TemplateHeaderShape> */
    use SdkModel;

    /**
     * The header template text with optional variable placeholders (e.g., "Welcome to {{0:variable}}").
     */
    #[Required]
    public string $template;

    /**
     * Request-only. The s.dm URL of the asset Meta's reviewers see — https://s.dm/s/{ID}, eight
     * uppercase characters, uploaded to s.dm out of band. NormalizeRichHeader
     * folds it into the synthesized media variable's Props.Sample and clears it, so it never persists
     * and a stored definition is indistinguishable from an imported one.
     *
     * Stricter than the send path on purpose: TemplateUtils.ValidateMediaVariableValues accepts
     * any absolute https URL for the per-send asset, because that one is the customer's and may live behind
     * a signed CDN link. This one is the review sample, has to outlive every resubmission, and so must be
     * ours. Do not "fix" one to match the other.
     */
    #[Optional('example_url', nullable: true)]
    public ?string $exampleURL;

    /**
     * The map pin a location header drops. Meta wants none of this at creation — the component is just
     * {"type":"header","format":"location"} — so these values exist for Sent: a preview, and the
     * default a StaticResource header falls back to at send.
     */
    #[Optional(nullable: true)]
    public ?Location $location;

    /**
     * Whether the asset registered at creation is reused when a caller omits the header's variable at send
     * time. Default false — the caller must supply it per message, which is the behaviour every
     * existing template has. Written only when true, so a default-valued header serializes byte-identically
     * to one imported from Meta.
     *
     * Stored and validated but not yet honoured at send: that lands with the Resumable Upload work,
     * alongside the code that lets such a template be approved in the first place.
     */
    #[Optional('static_resource')]
    public ?bool $staticResource;

    /**
     * The kind of header. One of:
     *
     * text — up to 60 characters, at most one variable.
     * image — png, jpg or jpeg. Needs ExampleUrl.
     * video — mp4. Needs ExampleUrl.
     * gif — mp4, max 3.5MB. WhatsApp renders larger files as an ordinary video. Needs
     * ExampleUrl.
     * document — pdf or docx; only the first page is shown as a thumbnail, so pdf is the
     * practical choice. Needs ExampleUrl.
     * location — a map pin, supplied through Location.
     *
     * Kept lowercase because MetaToTemplateConverter writes Meta's format
     * through ToLowerInvariant() into this field on import, and the two are compared directly.
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

    /**
     * `new TemplateHeader()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateHeader::with(template: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateHeader)->withTemplate(...)
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
     * @param Location|LocationShape|null $location
     * @param list<TemplateVariable|TemplateVariableShape>|null $variables
     */
    public static function with(
        string $template,
        ?string $exampleURL = null,
        Location|array|null $location = null,
        ?bool $staticResource = null,
        ?string $type = null,
        ?array $variables = null,
    ): self {
        $self = new self;

        $self['template'] = $template;

        null !== $exampleURL && $self['exampleURL'] = $exampleURL;
        null !== $location && $self['location'] = $location;
        null !== $staticResource && $self['staticResource'] = $staticResource;
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
     * Request-only. The s.dm URL of the asset Meta's reviewers see — https://s.dm/s/{ID}, eight
     * uppercase characters, uploaded to s.dm out of band. NormalizeRichHeader
     * folds it into the synthesized media variable's Props.Sample and clears it, so it never persists
     * and a stored definition is indistinguishable from an imported one.
     *
     * Stricter than the send path on purpose: TemplateUtils.ValidateMediaVariableValues accepts
     * any absolute https URL for the per-send asset, because that one is the customer's and may live behind
     * a signed CDN link. This one is the review sample, has to outlive every resubmission, and so must be
     * ours. Do not "fix" one to match the other.
     */
    public function withExampleURL(?string $exampleURL): self
    {
        $self = clone $this;
        $self['exampleURL'] = $exampleURL;

        return $self;
    }

    /**
     * The map pin a location header drops. Meta wants none of this at creation — the component is just
     * {"type":"header","format":"location"} — so these values exist for Sent: a preview, and the
     * default a StaticResource header falls back to at send.
     *
     * @param Location|LocationShape|null $location
     */
    public function withLocation(Location|array|null $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * Whether the asset registered at creation is reused when a caller omits the header's variable at send
     * time. Default false — the caller must supply it per message, which is the behaviour every
     * existing template has. Written only when true, so a default-valued header serializes byte-identically
     * to one imported from Meta.
     *
     * Stored and validated but not yet honoured at send: that lands with the Resumable Upload work,
     * alongside the code that lets such a template be approved in the first place.
     */
    public function withStaticResource(bool $staticResource): self
    {
        $self = clone $this;
        $self['staticResource'] = $staticResource;

        return $self;
    }

    /**
     * The kind of header. One of:
     *
     * text — up to 60 characters, at most one variable.
     * image — png, jpg or jpeg. Needs ExampleUrl.
     * video — mp4. Needs ExampleUrl.
     * gif — mp4, max 3.5MB. WhatsApp renders larger files as an ordinary video. Needs
     * ExampleUrl.
     * document — pdf or docx; only the first page is shown as a thumbnail, so pdf is the
     * practical choice. Needs ExampleUrl.
     * location — a map pin, supplied through Location.
     *
     * Kept lowercase because MetaToTemplateConverter writes Meta's format
     * through ToLowerInvariant() into this field on import, and the two are compared directly.
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
