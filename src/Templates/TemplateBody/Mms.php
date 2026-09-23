<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateBody;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateBody\Mms\Media;
use SentDm\Templates\TemplateVariable;

/**
 * MMS-specific content — subject, text and attachments.
 *
 * Like Rcs, an override that cannot stand on its own: a template still needs a
 * MultiChannel body or the Sms + Whatsapp pair to be
 * deliverable at all. Unlike Rcs, it has no fallback at send time — MMS with no
 * media is a more expensive SMS, so a template without this slot is deliberately not MMS-capable
 * and never produces an MMS route candidate.
 *
 * @phpstan-import-type TemplateVariableShape from \SentDm\Templates\TemplateVariable
 * @phpstan-import-type MediaShape from \SentDm\Templates\TemplateBody\Mms\Media
 *
 * @phpstan-type MmsShape = array{
 *   template: string,
 *   type?: string|null,
 *   variables?: list<TemplateVariable|TemplateVariableShape>|null,
 *   media?: list<Media|MediaShape>|null,
 *   subject?: string|null,
 * }
 */
final class Mms implements BaseModel
{
    /** @use SdkModel<MmsShape> */
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
     * The type of body content — send "text". It is dropped from the stored definition when null,
     * so a body posted without it is saved with no type key at all and the template editor has
     * nothing to render the block from.
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
     * @var list<Media>|null $media
     */
    #[Optional(list: Media::class, nullable: true)]
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
     * `new Mms()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Mms::with(template: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Mms)->withTemplate(...)
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
     * @param list<Media|MediaShape>|null $media
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
     * The type of body content — send "text". It is dropped from the stored definition when null,
     * so a body posted without it is saved with no type key at all and the template editor has
     * nothing to render the block from.
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
     * @param list<Media|MediaShape>|null $media
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
