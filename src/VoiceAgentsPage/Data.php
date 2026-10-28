<?php

declare(strict_types=1);

namespace SentDm\VoiceAgentsPage;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\VoiceAgentsPage\Data\Pagination;

/**
 * @phpstan-import-type PaginationShape from \SentDm\VoiceAgentsPage\Data\Pagination
 *
 * @phpstan-type DataShape = array{
 *   agents?: list<mixed>|null, pagination?: null|Pagination|PaginationShape
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<mixed>|null $agents */
    #[Optional(list: 'mixed')]
    public ?array $agents;

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
     * @param list<mixed>|null $agents
     * @param Pagination|PaginationShape|null $pagination
     */
    public static function with(
        ?array $agents = null,
        Pagination|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $agents && $self['agents'] = $agents;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * @param list<mixed> $agents
     */
    public function withAgents(array $agents): self
    {
        $self = clone $this;
        $self['agents'] = $agents;

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
