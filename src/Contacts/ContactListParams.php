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
 * @phpstan-type ContactListParamsShape = array{
 *   page: int, pageSize: int, xAPIKey: string, xSenderID: string
 * }
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

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * `new ContactListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactListParams::with(page: ..., pageSize: ..., xAPIKey: ..., xSenderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactListParams)
     *   ->withPage(...)
     *   ->withPageSize(...)
     *   ->withXAPIKey(...)
     *   ->withXSenderID(...)
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
        string $xAPIKey,
        string $xSenderID
    ): self {
        $self = new self;

        $self['page'] = $page;
        $self['pageSize'] = $pageSize;
        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

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

    public function withXAPIKey(string $xAPIKey): self
    {
        $self = clone $this;
        $self['xAPIKey'] = $xAPIKey;

        return $self;
    }

    public function withXSenderID(string $xSenderID): self
    {
        $self = clone $this;
        $self['xSenderID'] = $xSenderID;

        return $self;
    }
}
