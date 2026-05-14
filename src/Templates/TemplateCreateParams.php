<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateCreateParams\Definition;

/**
 * Creates a new message template with header, body, footer, and buttons. The template can be submitted for review immediately or saved as draft for later submission.
 *
 * @see SentDm\Services\TemplatesService::create()
 *
 * @phpstan-import-type DefinitionShape from \SentDm\Templates\TemplateCreateParams\Definition
 *
 * @phpstan-type TemplateCreateParamsShape = array{
 *   category?: string|null,
 *   creationSource?: string|null,
 *   definition?: null|Definition|DefinitionShape,
 *   language?: string|null,
 *   sandbox?: bool|null,
 *   submitForReview?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
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
     * Complete definition of a message template including header, body, footer, and buttons.
     */
    #[Optional]
    public ?Definition $definition;

    /**
     * Template language code (e.g., en_US) (optional, auto-detected if not provided).
     */
    #[Optional(nullable: true)]
    public ?string $language;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * Whether to submit the template for review after creation (default: false).
     */
    #[Optional('submit_for_review')]
    public ?bool $submitForReview;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Definition|DefinitionShape|null $definition
     */
    public static function with(
        ?string $category = null,
        ?string $creationSource = null,
        Definition|array|null $definition = null,
        ?string $language = null,
        ?bool $sandbox = null,
        ?bool $submitForReview = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $category && $self['category'] = $category;
        null !== $creationSource && $self['creationSource'] = $creationSource;
        null !== $definition && $self['definition'] = $definition;
        null !== $language && $self['language'] = $language;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $submitForReview && $self['submitForReview'] = $submitForReview;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
     * Complete definition of a message template including header, body, footer, and buttons.
     *
     * @param Definition|DefinitionShape $definition
     */
    public function withDefinition(Definition|array $definition): self
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
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

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

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
