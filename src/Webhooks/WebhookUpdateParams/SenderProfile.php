<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookUpdateParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;

/**
 * Request-only: the events an organization webhook's sender profile clones receive, one clone per existing
 * and future profile. Responses never return it.
 *
 * @phpstan-type SenderProfileShape = array{
 *   eventFilters?: array<string,list<string>>|null, eventTypes?: list<string>|null
 * }
 */
final class SenderProfile implements BaseModel
{
    /** @use SdkModel<SenderProfileShape> */
    use SdkModel;

    /** @var array<string,list<string>>|null $eventFilters */
    #[Optional('event_filters', map: new ListOf('string'), nullable: true)]
    public ?array $eventFilters;

    /** @var list<string>|null $eventTypes */
    #[Optional('event_types', list: 'string')]
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
     * @param array<string,list<string>>|null $eventFilters
     * @param list<string>|null $eventTypes
     */
    public static function with(
        ?array $eventFilters = null,
        ?array $eventTypes = null
    ): self {
        $self = new self;

        null !== $eventFilters && $self['eventFilters'] = $eventFilters;
        null !== $eventTypes && $self['eventTypes'] = $eventTypes;

        return $self;
    }

    /**
     * @param array<string,list<string>>|null $eventFilters
     */
    public function withEventFilters(?array $eventFilters): self
    {
        $self = clone $this;
        $self['eventFilters'] = $eventFilters;

        return $self;
    }

    /**
     * @param list<string> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }
}
