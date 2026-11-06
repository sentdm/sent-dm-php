<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Lists the sender profiles under your organization, newest first, paginated with `page` and `page_size`.
 *
 * Each entry is the same document `GET /v3/sender-profiles/{id}` returns, with one difference: **`compliance.documents` at the profile root is absent**. Working out which documents a market holds means a catalog lookup and a document read per market, and doing that for every profile on a page would turn one request into dozens to answer a question you did not ask. Read a single profile for that. Brand and campaign are still included when they exist.
 *
 * `compliance.documents` being **absent** is not the same as it being an **empty list**. Absent means the documents were not fetched here; an empty list means the profile holds none.
 *
 * `api_key` is never returned. It is shown once, by create.
 *
 * @see SentDm\Services\SenderProfilesService::list()
 *
 * @phpstan-type SenderProfileListParamsShape = array{
 *   page?: int|null, pageSize?: int|null
 * }
 */
final class SenderProfileListParams implements BaseModel
{
    /** @use SdkModel<SenderProfileListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Page number, 1-indexed.
     */
    #[Optional]
    public ?int $page;

    /**
     * Profiles per page. Between 1 and 100.
     */
    #[Optional]
    public ?int $pageSize;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $page = null, ?int $pageSize = null): self
    {
        $self = new self;

        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Page number, 1-indexed.
     */
    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Profiles per page. Between 1 and 100.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }
}
