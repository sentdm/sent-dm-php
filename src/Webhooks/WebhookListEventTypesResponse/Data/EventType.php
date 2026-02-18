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
 *   isActive?: bool|null,
 *   name?: string|null,
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

    #[Optional('is_active')]
    public ?bool $isActive;

    #[Optional]
    public ?string $name;

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
        ?string $description = null,
        ?string $displayName = null,
        ?bool $isActive = null,
        ?string $name = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $name && $self['name'] = $name;

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
}
