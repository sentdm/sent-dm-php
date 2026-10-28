<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\PaginationMeta;

/**
 * A page of the account's agents. The agent itself is VoiceAgentResponse, shared with the admin API.
 *
 * @phpstan-import-type VoiceAgentShape from \SentDm\Voice\Agents\VoiceAgent
 * @phpstan-import-type PaginationMetaShape from \SentDm\Webhooks\PaginationMeta
 *
 * @phpstan-type VoiceAgentsListShape = array{
 *   agents?: list<VoiceAgent|VoiceAgentShape>|null,
 *   pagination?: null|PaginationMeta|PaginationMetaShape,
 * }
 */
final class VoiceAgentsList implements BaseModel
{
    /** @use SdkModel<VoiceAgentsListShape> */
    use SdkModel;

    /** @var list<VoiceAgent>|null $agents */
    #[Optional(list: VoiceAgent::class)]
    public ?array $agents;

    /**
     * Pagination metadata for list responses.
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
     * @param list<VoiceAgent|VoiceAgentShape>|null $agents
     * @param PaginationMeta|PaginationMetaShape|null $pagination
     */
    public static function with(
        ?array $agents = null,
        PaginationMeta|array|null $pagination = null
    ): self {
        $self = new self;

        null !== $agents && $self['agents'] = $agents;
        null !== $pagination && $self['pagination'] = $pagination;

        return $self;
    }

    /**
     * @param list<VoiceAgent|VoiceAgentShape> $agents
     */
    public function withAgents(array $agents): self
    {
        $self = clone $this;
        $self['agents'] = $agents;

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
}
