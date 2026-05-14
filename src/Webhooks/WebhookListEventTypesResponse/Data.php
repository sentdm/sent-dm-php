<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventTypesResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\WebhookListEventTypesResponse\Data\EventType;

/**
 * The response data (null if error).
 *
 * @phpstan-import-type EventTypeShape from \SentDm\Webhooks\WebhookListEventTypesResponse\Data\EventType
 *
 * @phpstan-type DataShape = array{
 *   eventTypes?: list<EventType|EventTypeShape>|null
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<EventType>|null $eventTypes */
    #[Optional('event_types', list: EventType::class)]
    public ?array $eventTypes;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<EventType|EventTypeShape>|null $eventTypes
     */
    public static function with(?array $eventTypes = null): self
    {
        $self = new self;

        null !== $eventTypes && $self['eventTypes'] = $eventTypes;

        return $self;
    }

    /**
     * @param list<EventType|EventTypeShape> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }
}
