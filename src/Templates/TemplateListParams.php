<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves all message templates available for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. Supports advanced filtering by search term, status, and category, plus pagination. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\TemplatesService::list()
 *
 * @phpstan-type TemplateListParamsShape = array{
 *   page: int,
 *   pageSize: int,
 *   category?: string|null,
 *   search?: string|null,
 *   status?: string|null,
 * }
 */
final class TemplateListParams implements BaseModel
{
    /** @use SdkModel<TemplateListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The page number (zero-indexed). Default is 0.
     */
    #[Required]
    public int $page;

    /**
     * The number of items per page (1-1000). Default is 100.
     */
    #[Required]
    public int $pageSize;

    /**
     * Optional filter by template category (e.g., MARKETING, UTILITY, AUTHENTICATION).
     */
    #[Optional(nullable: true)]
    public ?string $category;

    /**
     * Optional search term to filter templates by name or content.
     */
    #[Optional(nullable: true)]
    public ?string $search;

    /**
     * Optional filter by template status (e.g., APPROVED, PENDING, REJECTED, DRAFT).
     */
    #[Optional(nullable: true)]
    public ?string $status;

    /**
     * `new TemplateListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateListParams::with(page: ..., pageSize: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateListParams)->withPage(...)->withPageSize(...)
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
        int $page,
        int $pageSize,
        ?string $category = null,
        ?string $search = null,
        ?string $status = null,
    ): self {
        $self = new self;

        $self['page'] = $page;
        $self['pageSize'] = $pageSize;

        null !== $category && $self['category'] = $category;
        null !== $search && $self['search'] = $search;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * The page number (zero-indexed). Default is 0.
     */
    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * The number of items per page (1-1000). Default is 100.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Optional filter by template category (e.g., MARKETING, UTILITY, AUTHENTICATION).
     */
    public function withCategory(?string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Optional search term to filter templates by name or content.
     */
    public function withSearch(?string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Optional filter by template status (e.g., APPROVED, PENDING, REJECTED, DRAFT).
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
