<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of a template status event. Delivered when a template's review outcome changes, so you can
 * react without polling.
 *
 * @phpstan-type TemplateEventPayloadShape = array{
 *   status: string,
 *   whatsappTemplateID: string,
 *   accountID?: string|null,
 *   autoReplyAction?: string|null,
 *   category?: string|null,
 *   channel?: string|null,
 *   language?: string|null,
 *   reason?: string|null,
 *   templateID?: string|null,
 *   templateName?: string|null,
 * }
 */
final class TemplateEventPayload implements BaseModel
{
    /** @use SdkModel<TemplateEventPayloadShape> */
    use SdkModel;

    /**
     * The review status the template just reached, for example APPROVED or
     * REJECTED.
     */
    #[Required]
    public string $status;

    /**
     * The template's identifier with Meta, assigned when the template is submitted for review.
     */
    #[Required('whatsapp_template_id')]
    public string $whatsappTemplateID;

    /**
     * The account the template belongs to.
     */
    #[Optional('account_id')]
    public ?string $accountID;

    /**
     * Which consent keyword this template answers, when it is one of Sent's auto-replies:
     * OPT_IN, OPT_OUT, HELP, or OTHER for a customer-defined keyword.
     *
     * Omitted for an ordinary template, so its presence is the answer to "is this an
     * auto-reply". Sent creates the three compliance auto-replies at signup and they go through
     * review like any other template, so their events arrive mixed in with the customer's own with
     * nothing else to tell them apart.
     *
     * Named for the reader rather than after Template.OptAction, which it is mapped
     * from. The MCP tool result deliberately keeps OptAction, OptKeywords and
     * IsOpt: it mirrors the internal shape on purpose and publishes the keywords too, so
     * renaming one of the three there would leave a surface half in each vocabulary. Two names for
     * one concept, each consistent within its own surface, chosen over a rename that breaks MCP
     * clients silently.
     */
    #[Optional('auto_reply_action', nullable: true)]
    public ?string $autoReplyAction;

    /**
     * The template's category, for example UTILITY, MARKETING, or
     * AUTHENTICATION.
     */
    #[Optional]
    public ?string $category;

    /**
     * The channel leg this decision is about, for example whatsapp, sms, or rcs.
     * A template is reviewed per channel and the legs come back independently, so each one reports
     * separately.
     *
     * Omitted when the decision applies to the template as a whole rather than to one leg. That
     * event is the broader news: a template-wide rejection blocks every channel, whatever the
     * individual legs say.
     */
    #[Optional(nullable: true)]
    public ?string $channel;

    /**
     * The template's language code, for example en_US.
     */
    #[Optional]
    public ?string $language;

    /**
     * Why the template reached Status, when a reason was given. Populated on a
     * rejection.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * The template in Sent.
     */
    #[Optional('template_id')]
    public ?string $templateID;

    /**
     * The template's display name.
     */
    #[Optional('template_name')]
    public ?string $templateName;

    /**
     * `new TemplateEventPayload()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateEventPayload::with(status: ..., whatsappTemplateID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateEventPayload)->withStatus(...)->withWhatsappTemplateID(...)
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
     */
    public static function with(
        string $status,
        string $whatsappTemplateID,
        ?string $accountID = null,
        ?string $autoReplyAction = null,
        ?string $category = null,
        ?string $channel = null,
        ?string $language = null,
        ?string $reason = null,
        ?string $templateID = null,
        ?string $templateName = null,
    ): self {
        $self = new self;

        $self['status'] = $status;
        $self['whatsappTemplateID'] = $whatsappTemplateID;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $autoReplyAction && $self['autoReplyAction'] = $autoReplyAction;
        null !== $category && $self['category'] = $category;
        null !== $channel && $self['channel'] = $channel;
        null !== $language && $self['language'] = $language;
        null !== $reason && $self['reason'] = $reason;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateName && $self['templateName'] = $templateName;

        return $self;
    }

    /**
     * The review status the template just reached, for example APPROVED or
     * REJECTED.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The template's identifier with Meta, assigned when the template is submitted for review.
     */
    public function withWhatsappTemplateID(string $whatsappTemplateID): self
    {
        $self = clone $this;
        $self['whatsappTemplateID'] = $whatsappTemplateID;

        return $self;
    }

    /**
     * The account the template belongs to.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * Which consent keyword this template answers, when it is one of Sent's auto-replies:
     * OPT_IN, OPT_OUT, HELP, or OTHER for a customer-defined keyword.
     *
     * Omitted for an ordinary template, so its presence is the answer to "is this an
     * auto-reply". Sent creates the three compliance auto-replies at signup and they go through
     * review like any other template, so their events arrive mixed in with the customer's own with
     * nothing else to tell them apart.
     *
     * Named for the reader rather than after Template.OptAction, which it is mapped
     * from. The MCP tool result deliberately keeps OptAction, OptKeywords and
     * IsOpt: it mirrors the internal shape on purpose and publishes the keywords too, so
     * renaming one of the three there would leave a surface half in each vocabulary. Two names for
     * one concept, each consistent within its own surface, chosen over a rename that breaks MCP
     * clients silently.
     */
    public function withAutoReplyAction(?string $autoReplyAction): self
    {
        $self = clone $this;
        $self['autoReplyAction'] = $autoReplyAction;

        return $self;
    }

    /**
     * The template's category, for example UTILITY, MARKETING, or
     * AUTHENTICATION.
     */
    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * The channel leg this decision is about, for example whatsapp, sms, or rcs.
     * A template is reviewed per channel and the legs come back independently, so each one reports
     * separately.
     *
     * Omitted when the decision applies to the template as a whole rather than to one leg. That
     * event is the broader news: a template-wide rejection blocks every channel, whatever the
     * individual legs say.
     */
    public function withChannel(?string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * The template's language code, for example en_US.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Why the template reached Status, when a reason was given. Populated on a
     * rejection.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * The template in Sent.
     */
    public function withTemplateID(string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

        return $self;
    }

    /**
     * The template's display name.
     */
    public function withTemplateName(string $templateName): self
    {
        $self = clone $this;
        $self['templateName'] = $templateName;

        return $self;
    }
}
