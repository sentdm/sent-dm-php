<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Represents a message template with comprehensive metadata including definition structure.
 *
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 *
 * @phpstan-type TemplateResponseShape = array{
 *   id?: string|null,
 *   category?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   definition?: null|TemplateDefinition|TemplateDefinitionShape,
 *   displayName?: string|null,
 *   isPublished?: bool|null,
 *   language?: string|null,
 *   status?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   whatsappTemplateID?: string|null,
 *   whatsappTemplateName?: string|null,
 * }
 */
final class TemplateResponse implements BaseModel
{
    /** @use SdkModel<TemplateResponseShape> */
    use SdkModel;

    /**
     * The unique identifier of the template.
     */
    #[Optional]
    public ?string $id;

    /**
     * The template category (e.g., MARKETING, UTILITY, AUTHENTICATION).
     */
    #[Optional]
    public ?string $category;

    /**
     * The date and time when the template was created.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * The complete template definition including header, body, footer, and buttons.
     */
    #[Optional]
    public ?TemplateDefinition $definition;

    /**
     * The display name of the template (auto-generated if not provided).
     */
    #[Optional]
    public ?string $displayName;

    /**
     * Indicates whether the template is published and available for use.
     */
    #[Optional]
    public ?bool $isPublished;

    /**
     * The template language code (e.g., en_US, es_ES).
     */
    #[Optional]
    public ?string $language;

    /**
     * The approval status of the template (e.g., APPROVED, PENDING, REJECTED, DRAFT).
     */
    #[Optional]
    public ?string $status;

    /**
     * The date and time when the template was last updated.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    /**
     * The WhatsApp Business API template ID from Meta.
     */
    #[Optional('whatsappTemplateId')]
    public ?string $whatsappTemplateID;

    /**
     * The WhatsApp template name as registered with Meta.
     */
    #[Optional]
    public ?string $whatsappTemplateName;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TemplateDefinition|TemplateDefinitionShape|null $definition
     */
    public static function with(
        ?string $id = null,
        ?string $category = null,
        ?\DateTimeInterface $createdAt = null,
        TemplateDefinition|array|null $definition = null,
        ?string $displayName = null,
        ?bool $isPublished = null,
        ?string $language = null,
        ?string $status = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $whatsappTemplateID = null,
        ?string $whatsappTemplateName = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $category && $self['category'] = $category;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $definition && $self['definition'] = $definition;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $isPublished && $self['isPublished'] = $isPublished;
        null !== $language && $self['language'] = $language;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $whatsappTemplateID && $self['whatsappTemplateID'] = $whatsappTemplateID;
        null !== $whatsappTemplateName && $self['whatsappTemplateName'] = $whatsappTemplateName;

        return $self;
    }

    /**
     * The unique identifier of the template.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The template category (e.g., MARKETING, UTILITY, AUTHENTICATION).
     */
    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * The date and time when the template was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The complete template definition including header, body, footer, and buttons.
     *
     * @param TemplateDefinition|TemplateDefinitionShape $definition
     */
    public function withDefinition(TemplateDefinition|array $definition): self
    {
        $self = clone $this;
        $self['definition'] = $definition;

        return $self;
    }

    /**
     * The display name of the template (auto-generated if not provided).
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Indicates whether the template is published and available for use.
     */
    public function withIsPublished(bool $isPublished): self
    {
        $self = clone $this;
        $self['isPublished'] = $isPublished;

        return $self;
    }

    /**
     * The template language code (e.g., en_US, es_ES).
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * The approval status of the template (e.g., APPROVED, PENDING, REJECTED, DRAFT).
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The date and time when the template was last updated.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The WhatsApp Business API template ID from Meta.
     */
    public function withWhatsappTemplateID(string $whatsappTemplateID): self
    {
        $self = clone $this;
        $self['whatsappTemplateID'] = $whatsappTemplateID;

        return $self;
    }

    /**
     * The WhatsApp template name as registered with Meta.
     */
    public function withWhatsappTemplateName(string $whatsappTemplateName): self
    {
        $self = clone $this;
        $self['whatsappTemplateName'] = $whatsappTemplateName;

        return $self;
    }
}
