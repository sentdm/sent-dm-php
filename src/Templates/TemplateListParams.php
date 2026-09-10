<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of message templates for the authenticated customer. Supports filtering by status, category, and search term.
 *
 * @see SentDm\Services\TemplatesService::list()
 *
 * @phpstan-type TemplateListParamsShape = array{
 *   category?: string|null,
 *   isWelcomePlayground?: bool|null,
 *   page?: int|null,
 *   pageSize?: int|null,
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
     * Optional category filter: MARKETING, UTILITY, AUTHENTICATION.
     */
    #[Optional(nullable: true)]
    public ?string $category;

    /**
     * Accepted and ignored. It used to filter on the welcome-playground marker inside a template's LOB
     * details; that filter is gone and nothing reads this value, so sending it neither narrows nor
     * widens the result. Retained only so a client still passing is_welcome_playground keeps
     * binding instead of the request shape changing under it.
     */
    #[Optional(nullable: true)]
    public ?bool $isWelcomePlayground;

    /**
     * Page number (1-indexed).
     */
    #[Optional]
    public ?int $page;

    /**
     * Number of items per page.
     */
    #[Optional]
    public ?int $pageSize;

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
        ?string $category = null,
        ?bool $isWelcomePlayground = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?string $search = null,
        ?string $status = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $category && $self['category'] = $category;
        null !== $isWelcomePlayground && $self['isWelcomePlayground'] = $isWelcomePlayground;
        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $search && $self['search'] = $search;
        null !== $status && $self['status'] = $status;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
     * Accepted and ignored. It used to filter on the welcome-playground marker inside a template's LOB
     * details; that filter is gone and nothing reads this value, so sending it neither narrows nor
     * widens the result. Retained only so a client still passing is_welcome_playground keeps
     * binding instead of the request shape changing under it.
     */
    public function withIsWelcomePlayground(?bool $isWelcomePlayground): self
    {
        $self = clone $this;
        $self['isWelcomePlayground'] = $isWelcomePlayground;

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
