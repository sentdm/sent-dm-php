<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of message templates for the authenticated customer. Supports filtering by status, category, and search term.
 *
 * @see SentDm\Services\TemplatesService::list()
 *
 * @phpstan-type TemplateListParamsShape = array{
 *   page: int,
 *   pageSize: int,
 *   category?: string|null,
 *   isWelcomePlayground?: bool|null,
 *   search?: string|null,
 *   status?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class TemplateListParams implements BaseModel
{
    /** @use SdkModel<TemplateListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Page number (1-indexed).
     */
    #[Required]
    public int $page;

    /**
     * Number of items per page.
     */
    #[Required]
    public int $pageSize;

    /**
     * Optional category filter: MARKETING, UTILITY, AUTHENTICATION.
     */
    #[Optional(nullable: true)]
    public ?string $category;

    /**
     * Optional filter by welcome playground flag.
     */
    #[Optional(nullable: true)]
    public ?bool $isWelcomePlayground;

    /**
     * Optional search term for filtering templates.
     */
    #[Optional(nullable: true)]
    public ?string $search;

    /**
     * Optional status filter: APPROVED, PENDING, REJECTED.
     */
    #[Optional(nullable: true)]
    public ?string $status;

    #[Optional]
    public ?string $xProfileID;

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
        ?bool $isWelcomePlayground = null,
        ?string $search = null,
        ?string $status = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['page'] = $page;
        $self['pageSize'] = $pageSize;

        null !== $category && $self['category'] = $category;
        null !== $isWelcomePlayground && $self['isWelcomePlayground'] = $isWelcomePlayground;
        null !== $search && $self['search'] = $search;
        null !== $status && $self['status'] = $status;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Page number (1-indexed).
     */
    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Number of items per page.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Optional category filter: MARKETING, UTILITY, AUTHENTICATION.
     */
    public function withCategory(?string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Optional filter by welcome playground flag.
     */
    public function withIsWelcomePlayground(?bool $isWelcomePlayground): self
    {
        $self = clone $this;
        $self['isWelcomePlayground'] = $isWelcomePlayground;

        return $self;
    }

    /**
     * Optional search term for filtering templates.
     */
    public function withSearch(?string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Optional status filter: APPROVED, PENDING, REJECTED.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
