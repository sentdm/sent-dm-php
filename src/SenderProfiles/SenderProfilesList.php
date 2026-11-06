<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * A paginated list of sender profiles.
 *
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 * @phpstan-import-type SenderProfileShape from \SentDm\SenderProfiles\SenderProfile
 *
 * @phpstan-type SenderProfilesListShape = array{
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 *   senderProfiles?: list<SenderProfile|SenderProfileShape>|null,
 * }
 */
final class SenderProfilesList implements BaseModel
{
    /** @use SdkModel<SenderProfilesListShape> */
    use SdkModel;

    /**
     * Pagination metadata for list responses.
     */
    #[Optional]
    public ?PaginationMeta $pagination;

    /**
     * The sender_profiles on this page.
     *
     * @var list<SenderProfile>|null $senderProfiles
     */
    #[Optional('sender_profiles', list: SenderProfile::class)]
    public ?array $senderProfiles;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     * @param list<SenderProfile|SenderProfileShape>|null $senderProfiles
     */
    public static function with(
        PaginationMeta|array|null $pagination = null,
        ?array $senderProfiles = null
    ): self {
        $self = new self;

        null !== $pagination && $self['pagination'] = $pagination;
        null !== $senderProfiles && $self['senderProfiles'] = $senderProfiles;

        return $self;
    }

    /**
     * Pagination metadata for list responses.
     *
     * @param PaginationMeta|PaginationMetaShape $pagination
     */
    public function withPagination(PaginationMeta|array $pagination): self
    {
        $self = clone $this;
        $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * The sender_profiles on this page.
     *
     * @param list<SenderProfile|SenderProfileShape> $senderProfiles
     */
    public function withSenderProfiles(array $senderProfiles): self
    {
        $self = clone $this;
        $self['senderProfiles'] = $senderProfiles;

        return $self;
    }
}
