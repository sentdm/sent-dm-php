<?php

declare(strict_types=1);

namespace SentDm\Contacts\ContactListResponse;

use SentDm\Contacts\ContactResponse;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * The response data (null if error).
 *
 * @phpstan-import-type ContactResponseShape from \SentDm\Contacts\ContactResponse
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type DataShape = array{
 *   contacts?: list<ContactResponse|ContactResponseShape>|null,
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * List of contacts.
     *
     * @var list<ContactResponse>|null $contacts
     */
    #[Optional(list: ContactResponse::class)]
    public ?array $contacts;

    /**
     * Pagination metadata.
     */
    #[Optional]
    public ?PaginationMeta $pagination;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ContactResponse|ContactResponseShape>|null $contacts
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     */
    public static function with(
        ?array $contacts = null,
        PaginationMeta|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $contacts && $self['contacts'] = $contacts;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * List of contacts.
     *
     * @param list<ContactResponse|ContactResponseShape> $contacts
     */
    public function withContacts(array $contacts): self
    {
        $self = clone $this;
        $self['contacts'] = $contacts;

        return $self;
    }

    /**
     * Pagination metadata.
     *
     * @param PaginationMeta|PaginationMetaShape $pagination
     */
    public function withPagination(PaginationMeta|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }
}
