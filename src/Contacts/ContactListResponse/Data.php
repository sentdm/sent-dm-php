<?php

declare(strict_types=1);

namespace SentDm\Contacts\ContactListResponse;

use SentDm\Contacts\ContactListResponse\Data\Contact;
use SentDm\Contacts\ContactListResponse\Data\Pagination;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Paginated list of contacts response.
 *
 * @phpstan-import-type ContactShape from \SentDm\Contacts\ContactListResponse\Data\Contact
 * @phpstan-import-type PaginationShape from \SentDm\Contacts\ContactListResponse\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   contacts?: list<Contact|ContactShape>|null,
 *   pagination?: null|Pagination|PaginationShape,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * List of contacts.
     *
     * @var list<Contact>|null $contacts
     */
    #[Optional(list: Contact::class)]
    public ?array $contacts;

    /**
     * Pagination metadata for list responses.
     */
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
     * @param list<Contact|ContactShape>|null $contacts
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
     * List of contacts.
     *
     * @param list<Contact|ContactShape> $contacts
     */
    public function withContacts(array $contacts): self
    {
        $self = clone $this;
        $self['contacts'] = $contacts;

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
}
