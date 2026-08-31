<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventTypesResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type EventTypeShape = array{
 *   description?: string|null,
 *   displayName?: string|null,
 *   eventType?: string|null,
 *   isActive?: bool|null,
 *   name?: string|null,
 *   subTypes?: list<mixed>|null,
 * }
 */
final class EventType implements BaseModel
{
    /** @use SdkModel<EventTypeShape> */
    use SdkModel;

    #[Optional(nullable: true)]
    public ?string $description;

    #[Optional('display_name')]
    public ?string $displayName;

    #[Optional('event_type', nullable: true)]
    public ?string $eventType;

    #[Optional('is_active')]
    public ?bool $isActive;

    #[Optional]
    public ?string $name;

    /** @var list<mixed>|null $subTypes */
    #[Optional('sub_types', list: 'mixed', nullable: true)]
    public ?array $subTypes;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<mixed>|null $subTypes
     */
    public static function with(
        ?string $description = null,
        ?string $displayName = null,
        ?string $eventType = null,
        ?bool $isActive = null,
        ?string $name = null,
        ?array $subTypes = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $eventType && $self['eventType'] = $eventType;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $name && $self['name'] = $name;
        null !== $subTypes && $self['subTypes'] = $subTypes;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    public function withEventType(?string $eventType): self
    {
        $self = clone $this;
        $self['eventType'] = $eventType;

        return $self;
    }

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param list<mixed>|null $subTypes
     */
    public function withSubTypes(?array $subTypes): self
    {
        $self = clone $this;
        $self['subTypes'] = $subTypes;

        return $self;
    }
}
