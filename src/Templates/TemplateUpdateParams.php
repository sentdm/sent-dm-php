<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Updates an existing template's name, category, language, definition, or submits it for review. While the template is in review (status PENDING, or any channel awaiting a verdict) its definition, category and language are frozen and a resubmission is refused — those requests answer 409 CONFLICT_006. The display name stays editable throughout.
 *
 * `definition`, `category` and `language` are editable only from status DRAFT, REJECTED or APPROVED. An edit to any of them on a template in another state (PAUSED, DISABLED or REVOKED) is refused with 400 VALIDATION_001 and the detail "Template (except display name) cannot be updated unless it is in draft or rejected status"; `name` stays editable in every state. `submit_for_review` on a PAUSED, DISABLED or REVOKED template is accepted and answers 200, but opens no review and does not move the status — only the reviewer can reinstate it.
 *
 * Editing an APPROVED template is a live edit: the new content is stored immediately, and sending `submit_for_review: true` re-opens review, which returns the affected channels to PENDING so they stop sending until they are approved again. The previously approved content is never sent during re-review. Watch the per-channel `templates` webhook events rather than assuming the template-level status.
 *
 * Templates provisioned by Sent (light-onboarding templates, whose names carry the reserved `sent_` prefix) are read-only: every field is refused with 400 VALIDATION_001 and the detail "This template is read-only. Only 'submit for review' is allowed.", and only `submit_for_review` is accepted. A `name` starting with `sent_` is refused for the same reason — the prefix is reserved.
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
 *   sandbox?: bool|null,
 *   submitForReview?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
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
     * Complete definition of a message template including header, body, footer, and buttons.
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
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * Whether to submit the template for review after updating (default: false).
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
        ?string $category = null,
        TemplateDefinition|array|null $definition = null,
        ?string $language = null,
        ?string $name = null,
        ?bool $sandbox = null,
        ?bool $submitForReview = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $category && $self['category'] = $category;
        null !== $definition && $self['definition'] = $definition;
        null !== $language && $self['language'] = $language;
        null !== $name && $self['name'] = $name;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $submitForReview && $self['submitForReview'] = $submitForReview;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
     * Complete definition of a message template including header, body, footer, and buttons.
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
     * Whether to submit the template for review after updating (default: false).
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
