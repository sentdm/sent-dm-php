<?php

declare(strict_types=1);

namespace SentDm\Voice\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a paginated list of your calls, most recent first. Filter by direction, status, the owning number, the mode (inapp, or agent for calls your voice agents answered), the agent that answered, and the time the call started (from and to are inclusive). Each call carries the phone number it was connected to, the caller id it showed, and the billed legs with what each cost. Use the call webhooks for real-time updates; this list is for looking calls up afterwards.
 *
 * @see SentDm\Services\Voice\CallsService::list()
 *
 * @phpstan-type CallListParamsShape = array{
 *   agentID?: string|null,
 *   direction?: string|null,
 *   from?: \DateTimeInterface|null,
 *   mode?: string|null,
 *   number?: string|null,
 *   page?: int|null,
 *   pageSize?: int|null,
 *   status?: string|null,
 *   to?: \DateTimeInterface|null,
 *   xProfileID?: string|null,
 * }
 */
final class CallListParams implements BaseModel
{
    /** @use SdkModel<CallListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Optional filter on the voice agent that answered the call, such as agent_9f2ab000-0000-4000-8000-000000000001.
     */
    #[Optional(nullable: true)]
    public ?string $agentID;

    /**
     * Optional direction filter: outbound for calls placed from your app, inbound for calls to one of your numbers.
     */
    #[Optional(nullable: true)]
    public ?string $direction;

    /**
     * Only calls started at or after this time (ISO 8601).
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $from;

    /**
     * Optional mode filter: inapp for calls routed by your number's callback URL, agent for calls one of your voice agents answered.
     */
    #[Optional(nullable: true)]
    public ?string $mode;

    /**
     * Optional filter on the number that owns the call, one of your voice-enabled numbers in E.164 format.
     */
    #[Optional(nullable: true)]
    public ?string $number;

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
     * Optional status filter: initiated, ringing, answered, completed, failed, no_answer or rejected.
     */
    #[Optional(nullable: true)]
    public ?string $status;

    /**
     * Only calls started at or before this time (ISO 8601).
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $to;

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
        ?string $agentID = null,
        ?string $direction = null,
        ?\DateTimeInterface $from = null,
        ?string $mode = null,
        ?string $number = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?string $status = null,
        ?\DateTimeInterface $to = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $agentID && $self['agentID'] = $agentID;
        null !== $direction && $self['direction'] = $direction;
        null !== $from && $self['from'] = $from;
        null !== $mode && $self['mode'] = $mode;
        null !== $number && $self['number'] = $number;
        null !== $page && $self['page'] = $page;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $status && $self['status'] = $status;
        null !== $to && $self['to'] = $to;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Optional filter on the voice agent that answered the call, such as agent_9f2ab000-0000-4000-8000-000000000001.
     */
    public function withAgentID(?string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * Optional direction filter: outbound for calls placed from your app, inbound for calls to one of your numbers.
     */
    public function withDirection(?string $direction): self
    {
        $self = clone $this;
        $self['direction'] = $direction;

        return $self;
    }

    /**
     * Only calls started at or after this time (ISO 8601).
     */
    public function withFrom(?\DateTimeInterface $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * Optional mode filter: inapp for calls routed by your number's callback URL, agent for calls one of your voice agents answered.
     */
    public function withMode(?string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * Optional filter on the number that owns the call, one of your voice-enabled numbers in E.164 format.
     */
    public function withNumber(?string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

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
     * Optional status filter: initiated, ringing, answered, completed, failed, no_answer or rejected.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Only calls started at or before this time (ISO 8601).
     */
    public function withTo(?\DateTimeInterface $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
