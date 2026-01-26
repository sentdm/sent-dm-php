<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new message template for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. Supports automatic metadata generation using AI (display name, language, category). Optionally submits the template for WhatsApp review. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\TemplatesService::create()
 *
 * @phpstan-import-type TemplateDefinitionShape from \SentDm\Templates\TemplateDefinition
 *
 * @phpstan-type TemplateCreateParamsShape = array{
 *   definition: TemplateDefinition|TemplateDefinitionShape,
 *   xAPIKey: string,
 *   xSenderID: string,
 *   category?: string|null,
 *   language?: string|null,
 *   submitForReview?: bool|null,
 * }
 */
final class TemplateCreateParams implements BaseModel
{
    /** @use SdkModel<TemplateCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Template definition containing header, body, footer, and buttons.
     */
    #[Required]
    public TemplateDefinition $definition;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * The template category (e.g., MARKETING, UTILITY, AUTHENTICATION). Can only be set when creating a new template. If not provided, will be auto-generated using AI.
     */
    #[Optional(nullable: true)]
    public ?string $category;

    /**
     * The template language code (e.g., en_US, es_ES). Can only be set when creating a new template. If not provided, will be auto-detected using AI.
     */
    #[Optional(nullable: true)]
    public ?string $language;

    /**
     * When false, the template will be saved as draft.
     * When true, the template will be submitted for review.
     */
    #[Optional]
    public ?bool $submitForReview;

    /**
     * `new TemplateCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateCreateParams::with(definition: ..., xAPIKey: ..., xSenderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateCreateParams)
     *   ->withDefinition(...)
     *   ->withXAPIKey(...)
     *   ->withXSenderID(...)
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
     * @param TemplateDefinition|TemplateDefinitionShape $definition
     */
    public static function with(
        TemplateDefinition|array $definition,
        string $xAPIKey,
        string $xSenderID,
        ?string $category = null,
        ?string $language = null,
        ?bool $submitForReview = null,
    ): self {
        $self = new self;

        $self['definition'] = $definition;
        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

        null !== $category && $self['category'] = $category;
        null !== $language && $self['language'] = $language;
        null !== $submitForReview && $self['submitForReview'] = $submitForReview;

        return $self;
    }

    /**
     * Template definition containing header, body, footer, and buttons.
     *
     * @param TemplateDefinition|TemplateDefinitionShape $definition
     */
    public function withDefinition(TemplateDefinition|array $definition): self
    {
        $self = clone $this;
        $self['definition'] = $definition;

        return $self;
    }

    public function withXAPIKey(string $xAPIKey): self
    {
        $self = clone $this;
        $self['xAPIKey'] = $xAPIKey;

        return $self;
    }

    public function withXSenderID(string $xSenderID): self
    {
        $self = clone $this;
        $self['xSenderID'] = $xSenderID;

        return $self;
    }

    /**
     * The template category (e.g., MARKETING, UTILITY, AUTHENTICATION). Can only be set when creating a new template. If not provided, will be auto-generated using AI.
     */
    public function withCategory(?string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * The template language code (e.g., en_US, es_ES). Can only be set when creating a new template. If not provided, will be auto-detected using AI.
     */
    public function withLanguage(?string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * When false, the template will be saved as draft.
     * When true, the template will be submitted for review.
     */
    public function withSubmitForReview(bool $submitForReview): self
    {
        $self = clone $this;
        $self['submitForReview'] = $submitForReview;

        return $self;
    }
}
