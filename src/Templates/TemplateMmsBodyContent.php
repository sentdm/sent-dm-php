<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * MMS-specific body content.
 *
 * Why MMS needs its own type when the other channels share one: it is the only channel
 * with a subject line and the only one with attachments. Every other channel's body is text and
 * variables, which is exactly what TemplateBodyContent already is. Putting
 * Subject and Media on the shared type instead would give sms, whatsapp and rcs two
 * members none of them can ever use.
 *
 * Derives from TemplateBodyContent so that every existing consumer of a body slot —
 * MessageUtils.ConvertVariableToReadable, TemplateDefinition.GetRequiredVariables,
 * TemplateDefinitionValidator.ApplyBodyContentRules — reads it with no change. The two extra
 * members are what the MMS strategy and the provider request need on top.
 *
 * @phpstan-import-type TemplateVariableShape from \SentDm\Templates\TemplateVariable
 * @phpstan-import-type TemplateMediaItemShape from \SentDm\Templates\TemplateMediaItem
 *
 * @phpstan-type TemplateMmsBodyContentShape = array{
 *   template: string,
 *   type?: string|null,
 *   variables?: list<TemplateVariable|TemplateVariableShape>|null,
 *   media?: list<TemplateMediaItem|TemplateMediaItemShape>|null,
 *   subject?: string|null,
 * }
 */
final class TemplateMmsBodyContent implements BaseModel
{
    /** @use SdkModel<TemplateMmsBodyContentShape> */
    use SdkModel;

    /**
     * The body copy, with variables written as {{index:variable}}.
     *
     * Length cap depends on which channel this body belongs to:
     * TemplateContentLimits.MaxBodyLength (1024) for multiChannel, sms and
     * whatsapp — Meta's BODY limit, which a multiChannel body may be delivered under —
     * and TemplateContentLimits.MaxRcsBodyLength (3072) for an rcs body, which never
     * reaches Meta. The maxLength advertised on this schema is the 1024 one, because all four
     * channel bodies share this single schema — an rcs body between the two is accepted.
     *
     * Meta requires every variable to carry surrounding context, so a body is refused unless it also
     * satisfies all of the following (enforced by TemplateDefinitionValidator):
     * At least one letter before the first variable and after the last — trailing punctuation
     * such as "... {{1:variable}}." does not count.
     * At least (2 × variable count) + 1 words once the placeholders are removed.
     * No two variables adjacent with only whitespace between them.
     * No leading or trailing newline, no more than two consecutive line breaks, and no more than
     * four consecutive spaces.
     *
     * Example: "Hello {{0:variable}}! Welcome to {{1:variable}}. We are glad to have you on
     * board." — two variables, so at least five words are required, and the copy after the final
     * variable contains letters.
     */
    #[Required]
    public string $template;

    /**
     * The type of body content. Defaults to "text" when omitted, which also fills it in when reading
     * stored bodies saved without it; the template editor refuses to load a body with no type.
     */
    #[Optional(nullable: true)]
    public ?string $type;

    /**
     * The variables referenced by the body copy, one entry per {{index:variable}} placeholder.
     *
     * @var list<TemplateVariable>|null $variables
     */
    #[Optional(list: TemplateVariable::class, nullable: true)]
    public ?array $variables;

    /**
     * Attachments carried by every send on this template, in order. A per-send media_urls on the
     * request replaces this list rather than adding to it, so a template can hold a default creative and
     * a caller can still send something recipient-specific.
     *
     * @var list<TemplateMediaItem>|null $media
     */
    #[Optional(list: TemplateMediaItem::class, nullable: true)]
    public ?array $media;

    /**
     * MMS subject line. Optional — most handsets render it above the body, some ignore it entirely.
     * Deliberately its own field rather than riding TemplateHeader: the header is authored once
     * and shared across every channel, and carries Meta's 60-character cap plus its no-newline,
     * no-emoji text rules, none of which describe an MMS subject.
     */
    #[Optional(nullable: true)]
    public ?string $subject;

    /**
     * `new TemplateMmsBodyContent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateMmsBodyContent::with(template: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateMmsBodyContent)->withTemplate(...)
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
     * @param list<TemplateVariable|TemplateVariableShape>|null $variables
     * @param list<TemplateMediaItem|TemplateMediaItemShape>|null $media
     */
    public static function with(
        string $template,
        ?string $type = null,
        ?array $variables = null,
        ?array $media = null,
        ?string $subject = null,
    ): self {
        $self = new self;

        $self['template'] = $template;

        null !== $type && $self['type'] = $type;
        null !== $variables && $self['variables'] = $variables;
        null !== $media && $self['media'] = $media;
        null !== $subject && $self['subject'] = $subject;

        return $self;
    }

    /**
     * The body copy, with variables written as {{index:variable}}.
     *
     * Length cap depends on which channel this body belongs to:
     * TemplateContentLimits.MaxBodyLength (1024) for multiChannel, sms and
     * whatsapp — Meta's BODY limit, which a multiChannel body may be delivered under —
     * and TemplateContentLimits.MaxRcsBodyLength (3072) for an rcs body, which never
     * reaches Meta. The maxLength advertised on this schema is the 1024 one, because all four
     * channel bodies share this single schema — an rcs body between the two is accepted.
     *
     * Meta requires every variable to carry surrounding context, so a body is refused unless it also
     * satisfies all of the following (enforced by TemplateDefinitionValidator):
     * At least one letter before the first variable and after the last — trailing punctuation
     * such as "... {{1:variable}}." does not count.
     * At least (2 × variable count) + 1 words once the placeholders are removed.
     * No two variables adjacent with only whitespace between them.
     * No leading or trailing newline, no more than two consecutive line breaks, and no more than
     * four consecutive spaces.
     *
     * Example: "Hello {{0:variable}}! Welcome to {{1:variable}}. We are glad to have you on
     * board." — two variables, so at least five words are required, and the copy after the final
     * variable contains letters.
     */
    public function withTemplate(string $template): self
    {
        $self = clone $this;
        $self['template'] = $template;

        return $self;
    }

    /**
     * The type of body content. Defaults to "text" when omitted, which also fills it in when reading
     * stored bodies saved without it; the template editor refuses to load a body with no type.
     */
    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The variables referenced by the body copy, one entry per {{index:variable}} placeholder.
     *
     * @param list<TemplateVariable|TemplateVariableShape>|null $variables
     */
    public function withVariables(?array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }

    /**
     * Attachments carried by every send on this template, in order. A per-send media_urls on the
     * request replaces this list rather than adding to it, so a template can hold a default creative and
     * a caller can still send something recipient-specific.
     *
     * @param list<TemplateMediaItem|TemplateMediaItemShape>|null $media
     */
    public function withMedia(?array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * MMS subject line. Optional — most handsets render it above the body, some ignore it entirely.
     * Deliberately its own field rather than riding TemplateHeader: the header is authored once
     * and shared across every channel, and carries Meta's 60-character cap plus its no-newline,
     * no-emoji text rules, none of which describe an MMS subject.
     */
    public function withSubject(?string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }
}
