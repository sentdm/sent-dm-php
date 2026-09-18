<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Template response for v3 API.
 *
 * @phpstan-type TemplateShape = array{
 *   customerID: string,
 *   id?: string|null,
 *   autoReplyAction?: string|null,
 *   category?: string|null,
 *   channels?: list<string>|null,
 *   createdAt?: \DateTimeInterface|null,
 *   isPublished?: bool|null,
 *   language?: string|null,
 *   name?: string|null,
 *   status?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   variables?: list<string>|null,
 * }
 */
final class Template implements BaseModel
{
    /** @use SdkModel<TemplateShape> */
    use SdkModel;

    /**
     * Which customer owns this — the key's own, or the profile named in x-profile-id. Says whose
     * resource this is, which the resource's own id does not.
     */
    #[Required('customer_id')]
    public string $customerID;

    /**
     * Unique template identifier.
     */
    #[Optional]
    public ?string $id;

    /**
     * Which consent keyword this template answers, when it is one of Sent's auto-replies:
     * OPT_IN, OPT_OUT, HELP, or OTHER for a customer-defined keyword.
     * Null for an ordinary template, and omitted from the response, so its presence is the answer to
     * "is this an auto-reply".
     *
     * Deliberately not required, unlike CustomerId, even though the
     * same "no single mapper" argument applies: NJsonSchema publishes a C# required member in the
     * schema's required array, so the contract would have advertised a field this response omits
     * for every ordinary template, and a generated client could refuse the common case. A compile-time
     * guard is not worth a wrong published contract. Every mapping site sets it explicitly, and
     * TemplateResponseSchemaTests pins the field as optional so it cannot be reintroduced.
     */
    #[Optional('auto_reply_action', nullable: true)]
    public ?string $autoReplyAction;

    /**
     * Template category: MARKETING, UTILITY, AUTHENTICATION.
     */
    #[Optional]
    public ?string $category;

    /**
     * The channels this template's definition can render on, in canonical order: sms,
     * whatsapp, rcs.
     *
     * Derived from the definition's body, mirroring each channel's send-time fallback chain, so a
     * channel is listed only when a real body would be produced for it: SMS reads
     * sms ?? multiChannel, WhatsApp reads whatsapp ?? multiChannel, and RCS reads
     * rcs ?? multiChannel ?? sms. A multiChannel body therefore reports all three, and
     * the extra SMS fallback on RCS is why an sms/whatsapp pair reports RCS too.
     *
     * This says what the content can render on, not what may be sent: sending also needs the
     * template approved for that channel.
     *
     * @var list<string>|null $channels
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $channels;

    /**
     * When the template was created.
     */
    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * Whether the template is published and active.
     */
    #[Optional('is_published')]
    public ?bool $isPublished;

    /**
     * Template language code (e.g., en_US).
     */
    #[Optional]
    public ?string $language;

    /**
     * Template display name.
     */
    #[Optional]
    public ?string $name;

    /**
     * Template status: DRAFT, PENDING, APPROVED, REJECTED. A template created with
     * submit_for_review: false starts as DRAFT and stays there until it is submitted.
     */
    #[Optional]
    public ?string $status;

    /**
     * When the template was last updated.
     */
    #[Optional('updated_at', nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Template variables for personalization.
     *
     * @var list<string>|null $variables
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $variables;

    /**
     * `new Template()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Template::with(customerID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Template)->withCustomerID(...)
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
     * @param list<string>|null $channels
     * @param list<string>|null $variables
     */
    public static function with(
        string $customerID,
        ?string $id = null,
        ?string $autoReplyAction = null,
        ?string $category = null,
        ?array $channels = null,
        ?\DateTimeInterface $createdAt = null,
        ?bool $isPublished = null,
        ?string $language = null,
        ?string $name = null,
        ?string $status = null,
        ?\DateTimeInterface $updatedAt = null,
        ?array $variables = null,
    ): self {
        $self = new self;

        $self['customerID'] = $customerID;

        null !== $id && $self['id'] = $id;
        null !== $autoReplyAction && $self['autoReplyAction'] = $autoReplyAction;
        null !== $category && $self['category'] = $category;
        null !== $channels && $self['channels'] = $channels;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $isPublished && $self['isPublished'] = $isPublished;
        null !== $language && $self['language'] = $language;
        null !== $name && $self['name'] = $name;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $variables && $self['variables'] = $variables;

        return $self;
    }

    /**
     * Which customer owns this — the key's own, or the profile named in x-profile-id. Says whose
     * resource this is, which the resource's own id does not.
     */
    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    /**
     * Unique template identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Which consent keyword this template answers, when it is one of Sent's auto-replies:
     * OPT_IN, OPT_OUT, HELP, or OTHER for a customer-defined keyword.
     * Null for an ordinary template, and omitted from the response, so its presence is the answer to
     * "is this an auto-reply".
     *
     * Deliberately not required, unlike CustomerId, even though the
     * same "no single mapper" argument applies: NJsonSchema publishes a C# required member in the
     * schema's required array, so the contract would have advertised a field this response omits
     * for every ordinary template, and a generated client could refuse the common case. A compile-time
     * guard is not worth a wrong published contract. Every mapping site sets it explicitly, and
     * TemplateResponseSchemaTests pins the field as optional so it cannot be reintroduced.
     */
    public function withAutoReplyAction(?string $autoReplyAction): self
    {
        $self = clone $this;
        $self['autoReplyAction'] = $autoReplyAction;

        return $self;
    }

    /**
     * Template category: MARKETING, UTILITY, AUTHENTICATION.
     */
    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * The channels this template's definition can render on, in canonical order: sms,
     * whatsapp, rcs.
     *
     * Derived from the definition's body, mirroring each channel's send-time fallback chain, so a
     * channel is listed only when a real body would be produced for it: SMS reads
     * sms ?? multiChannel, WhatsApp reads whatsapp ?? multiChannel, and RCS reads
     * rcs ?? multiChannel ?? sms. A multiChannel body therefore reports all three, and
     * the extra SMS fallback on RCS is why an sms/whatsapp pair reports RCS too.
     *
     * This says what the content can render on, not what may be sent: sending also needs the
     * template approved for that channel.
     *
     * @param list<string>|null $channels
     */
    public function withChannels(?array $channels): self
    {
        $self = clone $this;
        $self['channels'] = $channels;

        return $self;
    }

    /**
     * When the template was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Whether the template is published and active.
     */
    public function withIsPublished(bool $isPublished): self
    {
        $self = clone $this;
        $self['isPublished'] = $isPublished;

        return $self;
    }

    /**
     * Template language code (e.g., en_US).
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Template display name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Template status: DRAFT, PENDING, APPROVED, REJECTED. A template created with
     * submit_for_review: false starts as DRAFT and stays there until it is submitted.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When the template was last updated.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Template variables for personalization.
     *
     * @param list<string>|null $variables
     */
    public function withVariables(?array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }
}
