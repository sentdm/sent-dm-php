<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new message template with header, body, footer, and buttons. The template can be submitted for review immediately or saved as draft for later submission. There is no `name` field on create — the display name is derived from the template's content and can be changed afterwards with `PUT /v3/templates/{id}`.
 *
 * @see SentDm\Services\TemplatesService::create()
 *
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 *
 * @phpstan-type TemplateCreateParamsShape = array{
 *   autoCreateForSp?: bool|null,
 *   category?: string|null,
 *   creationSource?: string|null,
 *   definition?: null|TemplateDefinition|TemplateDefinitionShape,
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
     * Create this template automatically on every sender profile of the organization, now and in future
     * (default: false). Accepted only from an organization that has been enabled for it, and only at
     * creation — it cannot be changed afterwards.
     */
    #[Optional('auto_create_for_sp')]
    public ?bool $autoCreateForSp;

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
    public ?TemplateDefinition $definition;

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
     * @param TemplateDefinition|TemplateDefinitionShape|null $definition
     */
    public static function with(
        ?bool $autoCreateForSp = null,
        ?string $category = null,
        ?string $creationSource = null,
        TemplateDefinition|array|null $definition = null,
        ?string $language = null,
        ?bool $sandbox = null,
        ?bool $submitForReview = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $autoCreateForSp && $self['autoCreateForSp'] = $autoCreateForSp;
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
     * Create this template automatically on every sender profile of the organization, now and in future
     * (default: false). Accepted only from an organization that has been enabled for it, and only at
     * creation — it cannot be changed afterwards.
     */
    public function withAutoCreateForSp(bool $autoCreateForSp): self
    {
        $self = clone $this;
        $self['autoCreateForSp'] = $autoCreateForSp;

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
