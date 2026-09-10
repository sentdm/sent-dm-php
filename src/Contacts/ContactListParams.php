<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of contacts for the authenticated customer. Supports filtering by search term, channel, or phone number.
 *
 * @see SentDm\Services\ContactsService::list()
 *
 * @phpstan-type ContactListParamsShape = array{
 *   channel?: string|null,
 *   page?: int|null,
 *   pageSize?: int|null,
 *   phone?: string|null,
 *   search?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class ContactListParams implements BaseModel
{
    /** @use SdkModel<ContactListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Optional channel filter (sms, whatsapp).
     */
    #[Optional(nullable: true)]
    public ?string $channel;

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
     * Optional phone number filter (alternative to list view).
     */
    #[Optional(nullable: true)]
    public ?string $phone;

    /**
     * Optional search term for filtering contacts.
     */
    #[Optional(nullable: true)]
    public ?string $search;

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
        ?string $channel = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?string $phone = null,
        ?string $search = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $phone && $self['phone'] = $phone;
        null !== $search && $self['search'] = $search;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Optional channel filter (sms, whatsapp).
     */
    public function withChannel(?string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

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
     * Optional phone number filter (alternative to list view).
     */
    public function withPhone(?string $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }

    /**
     * Optional search term for filtering contacts.
     */
    public function withSearch(?string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
