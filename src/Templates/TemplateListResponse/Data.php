<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateListResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateListResponse\Data\Pagination;
use SentDm\Templates\TemplateListResponse\Data\Template;

/**
 * Paginated list of templates.
 *
 * @phpstan-import-type PaginationShape from \SentDm\Templates\TemplateListResponse\Data\Pagination
 * @phpstan-import-type TemplateShape from \SentDm\Templates\TemplateListResponse\Data\Template
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|Pagination|PaginationShape,
 *   templates?: list<Template|TemplateShape>|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Pagination metadata for list responses.
     */
    #[Optional]
    public ?Pagination $pagination;

    /**
     * List of templates.
     *
     * @var list<Template>|null $templates
     */
    #[Optional(list: Template::class)]
    public ?array $templates;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Pagination|PaginationShape|null $pagination
     * @param list<Template|TemplateShape>|null $templates
     */
    public static function with(
        Pagination|array|null $pagination = null,
        ?array $templates = null
    ): self {
        $self = new self;

        null !== $pagination && $self['pagination'] = $pagination;
        null !== $templates && $self['templates'] = $templates;

        return $self;
    }

    /**
     * Pagination metadata for list responses.
     *
     * @param Pagination|PaginationShape $pagination
     */
    public function withPagination(Pagination|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * List of templates.
     *
     * @param list<Template|TemplateShape> $templates
     */
    public function withTemplates(array $templates): self
    {
        $self = clone $this;
        $self['templates'] = $templates;

        return $self;
    }
}
