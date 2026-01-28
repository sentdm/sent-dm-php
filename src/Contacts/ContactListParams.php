<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of contacts for the authenticated customer. Supports server-side pagination with configurable page size. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\ContactsService::list()
 *
 * @phpstan-type ContactListParamsShape = array{page: int, pageSize: int}
 */
final class ContactListParams implements BaseModel
{
    /** @use SdkModel<ContactListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The page number (zero-indexed). Default is 0.
     */
    #[Required]
    public int $page;

    /**
     * The number of items per page. Default is 20.
     */
    #[Required]
    public int $pageSize;

    /**
     * `new ContactListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactListParams::with(page: ..., pageSize: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactListParams)->withPage(...)->withPageSize(...)
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
    public static function with(int $page, int $pageSize): self
    {
        $self = new self;

        $self['page'] = $page;
        $self['pageSize'] = $pageSize;

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
     * The number of items per page. Default is 20.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }
}
