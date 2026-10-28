<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Your voice agents, newest first. `page` and `page_size` (1 to 100, default 20) page the list. Signing secrets are never listed.
 *
 * @see SentDm\Services\Voice\AgentsService::list()
 *
 * @phpstan-type AgentListParamsShape = array{
 *   page?: int|null, pageSize?: int|null, xProfileID?: string|null
 * }
 */
final class AgentListParams implements BaseModel
{
    /** @use SdkModel<AgentListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Page number, from 1.
     */
    #[Optional]
    public ?int $page;

    #[Optional]
    public ?int $pageSize;

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
        ?int $page = null,
        ?int $pageSize = null,
        ?string $xProfileID = null
    ): self {
        $self = new self;

        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Page number, from 1.
     */
    public function withPage(int $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
