<?php

declare(strict_types=1);

namespace SentDm\ContactsPage;

use SentDm\ContactsPage\Data\Pagination;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PaginationShape from \SentDm\ContactsPage\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   contacts?: list<mixed>|null, pagination?: null|Pagination|PaginationShape
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<mixed>|null $contacts */
    #[Optional(list: 'mixed')]
    public ?array $contacts;

    #[Optional]
    public ?Pagination $pagination;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<mixed>|null $contacts
     * @param Pagination|PaginationShape|null $pagination
     */
    public static function with(
        ?array $contacts = null,
        Pagination|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $contacts && $self['contacts'] = $contacts;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * @param list<mixed> $contacts
     */
    public function withContacts(array $contacts): self
    {
        $self = clone $this;
        $self['contacts'] = $contacts;

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
}
