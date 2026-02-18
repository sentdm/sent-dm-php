<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Updates an existing template's name, category, language, definition, or submits it for review.
 *
 * @see SentDm\Services\TemplatesService::update()
 *
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 *
 * @phpstan-type TemplateUpdateParamsShape = array{
 *   category?: string|null,
 *   definition?: null|TemplateDefinition|TemplateDefinitionShape,
 *   language?: string|null,
 *   name?: string|null,
 *   submitForReview?: bool|null,
 *   testMode?: bool|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class TemplateUpdateParams implements BaseModel
{
    /** @use SdkModel<TemplateUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Template category: MARKETING, UTILITY, AUTHENTICATION.
     */
    #[Optional(nullable: true)]
    public ?string $category;

    /**
     * Template definition including header, body, footer, and buttons.
     */
    #[Optional(nullable: true)]
    public ?TemplateDefinition $definition;

    /**
     * Template language code (e.g., en_US).
     */
    #[Optional(nullable: true)]
    public ?string $language;

    /**
     * Template display name.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Whether to submit the template for review after updating (default: false).
     */
    #[Optional('submit_for_review')]
    public ?bool $submitForReview;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    #[Optional]
    public ?string $idempotencyKey;

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
        ?string $category = null,
        TemplateDefinition|array|null $definition = null,
        ?string $language = null,
        ?string $name = null,
        ?bool $submitForReview = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $category && $self['category'] = $category;
        null !== $definition && $self['definition'] = $definition;
        null !== $language && $self['language'] = $language;
        null !== $name && $self['name'] = $name;
        null !== $submitForReview && $self['submitForReview'] = $submitForReview;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Template category: MARKETING, UTILITY, AUTHENTICATION.
     */
    public function withCategory(?string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Template definition including header, body, footer, and buttons.
     *
     * @param TemplateDefinition|TemplateDefinitionShape|null $definition
     */
    public function withDefinition(
        TemplateDefinition|array|null $definition
    ): self {
        $self = clone $this;
        $self['definition'] = $definition;

        return $self;
    }

    /**
     * Template language code (e.g., en_US).
     */
    public function withLanguage(?string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Template display name.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Whether to submit the template for review after updating (default: false).
     */
    public function withSubmitForReview(bool $submitForReview): self
    {
        $self = clone $this;
        $self['submitForReview'] = $submitForReview;

        return $self;
    }

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withTestMode(bool $testMode): self
    {
        $self = clone $this;
        $self['testMode'] = $testMode;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
