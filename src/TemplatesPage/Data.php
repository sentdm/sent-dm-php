<?php

declare(strict_types=1);

namespace SentDm\TemplatesPage;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\TemplatesPage\Data\Pagination;

/**
 * @phpstan-import-type PaginationShape from \SentDm\TemplatesPage\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|Pagination|PaginationShape, templates?: list<mixed>|null
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    #[Optional]
    public ?Pagination $pagination;

    /** @var list<mixed>|null $templates */
    #[Optional(list: 'mixed')]
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
     * @param list<mixed>|null $templates
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
     * @param Pagination|PaginationShape $pagination
     */
    public function withPagination(Pagination|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * @param list<mixed> $templates
     */
    public function withTemplates(array $templates): self
    {
        $self = clone $this;
        $self['templates'] = $templates;

        return $self;
    }
}
