<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of an agent.* webhook (Sent Agents). The event is the agent service's own record,
 * forwarded without renaming: EventId is its id, so a subscriber can dedupe a redelivery.
 *
 * @phpstan-type AgentEventPayloadShape = array{
 *   eventID: string,
 *   occurredAt: string,
 *   accountID?: string|null,
 *   actor?: string|null,
 *   agentID?: string|null,
 *   agentName?: string|null,
 *   agentVersion?: int|null,
 *   contactID?: string|null,
 *   contactPhoneNumber?: string|null,
 *   data?: mixed,
 *   instanceID?: string|null,
 *   sequence?: int|null,
 * }
 */
final class AgentEventPayload implements BaseModel
{
    /** @use SdkModel<AgentEventPayloadShape> */
    use SdkModel;

    /**
     * The agent service's event id. The same event is never delivered under two ids.
     */
    #[Required('event_id')]
    public string $eventID;

    /**
     * When the agent service recorded it, UTC, to the millisecond.
     */
    #[Required('occurred_at')]
    public string $occurredAt;

    /**
     * The sender profile the agent runs on.
     */
    #[Optional('account_id')]
    public ?string $accountID;

    /**
     * Who caused it: system, the agent service's customer, or an approver.
     */
    #[Optional(nullable: true)]
    public ?string $actor;

    /**
     * The agent.
     */
    #[Optional('agent_id')]
    public ?string $agentID;

    /**
     * The agent's name, as it is listed. Absent for an agent services no longer holds.
     */
    #[Optional('agent_name', nullable: true)]
    public ?string $agentName;

    /**
     * The version of the agent the event is of: the one its conversation runs, or the active one for an event of
     * the agent itself. Absent when the agent service does not say it.
     */
    #[Optional('agent_version', nullable: true)]
    public ?int $agentVersion;

    /**
     * The contact of that conversation; absent on agent-level events.
     */
    #[Optional('contact_id', nullable: true)]
    public ?string $contactID;

    /**
     * The contact's phone number, in E.164, so a receiver knows who the event is about without asking for the
     * contact. Read from the account's contacts as the webhook is built: the agent service's own record names a
     * contact by id only. Absent on agent-level events, and for a contact the account no longer holds.
     */
    #[Optional('contact_phone_number', nullable: true)]
    public ?string $contactPhoneNumber;

    /**
     * The event's own fields (outcome, reason, ...), exactly as the agent service recorded them.
     */
    #[Optional]
    public mixed $data;

    /**
     * The conversation (agent × contact) the event belongs to; absent on agent-level events.
     */
    #[Optional('instance_id', nullable: true)]
    public ?string $instanceID;

    /**
     * Where the event stands among the agent's events: a number that grows with each, so two events of the same
     * second are put in order by it. Not a count: there are gaps between an agent's own. Absent from an agent
     * service that does not say it.
     */
    #[Optional(nullable: true)]
    public ?int $sequence;

    /**
     * `new AgentEventPayload()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentEventPayload::with(eventID: ..., occurredAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentEventPayload)->withEventID(...)->withOccurredAt(...)
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
        string $eventID,
        string $occurredAt,
        ?string $accountID = null,
        ?string $actor = null,
        ?string $agentID = null,
        ?string $agentName = null,
        ?int $agentVersion = null,
        ?string $contactID = null,
        ?string $contactPhoneNumber = null,
        mixed $data = null,
        ?string $instanceID = null,
        ?int $sequence = null,
    ): self {
        $self = new self;

        $self['eventID'] = $eventID;
        $self['occurredAt'] = $occurredAt;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $actor && $self['actor'] = $actor;
        null !== $agentID && $self['agentID'] = $agentID;
        null !== $agentName && $self['agentName'] = $agentName;
        null !== $agentVersion && $self['agentVersion'] = $agentVersion;
        null !== $contactID && $self['contactID'] = $contactID;
        null !== $contactPhoneNumber && $self['contactPhoneNumber'] = $contactPhoneNumber;
        null !== $data && $self['data'] = $data;
        null !== $instanceID && $self['instanceID'] = $instanceID;
        null !== $sequence && $self['sequence'] = $sequence;

        return $self;
    }

    /**
     * The agent service's event id. The same event is never delivered under two ids.
     */
    public function withEventID(string $eventID): self
    {
        $self = clone $this;
        $self['eventID'] = $eventID;

        return $self;
    }

    /**
     * When the agent service recorded it, UTC, to the millisecond.
     */
    public function withOccurredAt(string $occurredAt): self
    {
        $self = clone $this;
        $self['occurredAt'] = $occurredAt;

        return $self;
    }

    /**
     * The sender profile the agent runs on.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * Who caused it: system, the agent service's customer, or an approver.
     */
    public function withActor(?string $actor): self
    {
        $self = clone $this;
        $self['actor'] = $actor;

        return $self;
    }

    /**
     * The agent.
     */
    public function withAgentID(string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * The agent's name, as it is listed. Absent for an agent services no longer holds.
     */
    public function withAgentName(?string $agentName): self
    {
        $self = clone $this;
        $self['agentName'] = $agentName;

        return $self;
    }

    /**
     * The version of the agent the event is of: the one its conversation runs, or the active one for an event of
     * the agent itself. Absent when the agent service does not say it.
     */
    public function withAgentVersion(?int $agentVersion): self
    {
        $self = clone $this;
        $self['agentVersion'] = $agentVersion;

        return $self;
    }

    /**
     * The contact of that conversation; absent on agent-level events.
     */
    public function withContactID(?string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }

    /**
     * The contact's phone number, in E.164, so a receiver knows who the event is about without asking for the
     * contact. Read from the account's contacts as the webhook is built: the agent service's own record names a
     * contact by id only. Absent on agent-level events, and for a contact the account no longer holds.
     */
    public function withContactPhoneNumber(?string $contactPhoneNumber): self
    {
        $self = clone $this;
        $self['contactPhoneNumber'] = $contactPhoneNumber;

        return $self;
    }

    /**
     * The event's own fields (outcome, reason, ...), exactly as the agent service recorded them.
     */
    public function withData(mixed $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * The conversation (agent × contact) the event belongs to; absent on agent-level events.
     */
    public function withInstanceID(?string $instanceID): self
    {
        $self = clone $this;
        $self['instanceID'] = $instanceID;

        return $self;
    }

    /**
     * Where the event stands among the agent's events: a number that grows with each, so two events of the same
     * second are put in order by it. Not a count: there are gaps between an agent's own. Absent from an agent
     * service that does not say it.
     */
    public function withSequence(?int $sequence): self
    {
        $self = clone $this;
        $self['sequence'] = $sequence;

        return $self;
    }
}
