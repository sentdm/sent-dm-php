<?php

declare(strict_types=1);

namespace SentDm\SenderProfilesPage;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\SenderProfilesPage\Data\Pagination;

/**
 * @phpstan-import-type PaginationShape from \SentDm\SenderProfilesPage\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   pagination?: null|Pagination|PaginationShape,
 *   senderProfiles?: list<mixed>|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    #[Optional]
    public ?Pagination $pagination;

    /** @var list<mixed>|null $senderProfiles */
    #[Optional('sender_profiles', list: 'mixed')]
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
     * @param Pagination|PaginationShape|null $pagination
     * @param list<mixed>|null $senderProfiles
     */
    public static function with(
        Pagination|array|null $pagination = null,
        ?array $senderProfiles = null
    ): self {
        $self = new self;

        null !== $pagination && $self['pagination'] = $pagination;
        null !== $senderProfiles && $self['senderProfiles'] = $senderProfiles;

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
     * @param list<mixed> $senderProfiles
     */
    public function withSenderProfiles(array $senderProfiles): self
    {
        $self = clone $this;
        $self['senderProfiles'] = $senderProfiles;

        return $self;
    }
}
