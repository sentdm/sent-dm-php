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
     * The template's category, for example UTILITY, MARKETING, or
     * AUTHENTICATION.
     */
    #[Optional]
    public ?string $category;

    /**
     * The channel the template applies to.
     */
    #[Optional]
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
     * The channel the template applies to.
     */
    public function withChannel(string $channel): self
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
