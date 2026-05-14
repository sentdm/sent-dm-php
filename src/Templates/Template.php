<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Template response for v3 API.
 *
 * @phpstan-type TemplateShape = array{
 *   id?: string|null,
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
     * Unique template identifier.
     */
    #[Optional]
    public ?string $id;

    /**
     * Template category: MARKETING, UTILITY, AUTHENTICATION.
     */
    #[Optional]
    public ?string $category;

    /**
     * Supported channels: sms, whatsapp.
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
     * Template status: APPROVED, PENDING, REJECTED.
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
        ?string $id = null,
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

        null !== $id && $self['id'] = $id;
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
     * Unique template identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
     * Supported channels: sms, whatsapp.
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
     * Template status: APPROVED, PENDING, REJECTED.
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
