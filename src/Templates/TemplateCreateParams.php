<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new message template with header, body, footer, and buttons. The template can be submitted for review immediately or saved as draft for later submission.
 *
 * @see SentDm\Services\TemplatesService::create()
 *
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 *
 * @phpstan-type TemplateCreateParamsShape = array{
 *   category?: string|null,
 *   creationSource?: string|null,
 *   definition?: null|TemplateDefinition|TemplateDefinitionShape,
 *   language?: string|null,
 *   submitForReview?: bool|null,
 *   testMode?: bool|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class TemplateCreateParams implements BaseModel
{
    /** @use SdkModel<TemplateCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Template category: MARKETING, UTILITY, AUTHENTICATION (optional, auto-detected if not provided).
     */
    #[Optional(nullable: true)]
    public ?string $category;

    /**
     * Source of template creation (default: from-api).
     */
    #[Optional('creation_source', nullable: true)]
    public ?string $creationSource;

    /**
     * Template definition including header, body, footer, and buttons.
     */
    #[Optional]
    public ?TemplateDefinition $definition;

    /**
     * Template language code (e.g., en_US) (optional, auto-detected if not provided).
     */
    #[Optional(nullable: true)]
    public ?string $language;

    /**
     * Whether to submit the template for review after creation (default: false).
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
        ?string $creationSource = null,
        TemplateDefinition|array|null $definition = null,
        ?string $language = null,
        ?bool $submitForReview = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $category && $self['category'] = $category;
        null !== $creationSource && $self['creationSource'] = $creationSource;
        null !== $definition && $self['definition'] = $definition;
        null !== $language && $self['language'] = $language;
        null !== $submitForReview && $self['submitForReview'] = $submitForReview;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Template category: MARKETING, UTILITY, AUTHENTICATION (optional, auto-detected if not provided).
     */
    public function withCategory(?string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Source of template creation (default: from-api).
     */
    public function withCreationSource(?string $creationSource): self
    {
        $self = clone $this;
        $self['creationSource'] = $creationSource;

        return $self;
    }

    /**
     * Template definition including header, body, footer, and buttons.
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
     * Template language code (e.g., en_US) (optional, auto-detected if not provided).
     */
    public function withLanguage(?string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Whether to submit the template for review after creation (default: false).
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
