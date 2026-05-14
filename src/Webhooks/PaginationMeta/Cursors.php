<?php

declare(strict_types=1);

namespace SentDm\Webhooks\PaginationMeta;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Cursor-based pagination pointers.
 *
 * @phpstan-type CursorsShape = array{after?: string|null, before?: string|null}
 */
final class Cursors implements BaseModel
{
    /** @use SdkModel<CursorsShape> */
    use SdkModel;

    /**
     * Cursor to fetch the next page.
     */
    #[Optional(nullable: true)]
    public ?string $after;

    /**
     * Cursor to fetch the previous page.
     */
    #[Optional(nullable: true)]
    public ?string $before;

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
        ?string $after = null,
        ?string $before = null
    ): self {
        $self = new self;

        null !== $after && $self['after'] = $after;
        null !== $before && $self['before'] = $before;

        return $self;
    }

    /**
     * Cursor to fetch the next page.
     */
    public function withAfter(?string $after): self
    {
        $self = clone $this;
        $self['after'] = $after;

        return $self;
    }

    /**
     * Cursor to fetch the previous page.
     */
    public function withBefore(?string $before): self
    {
        $self = clone $this;
        $self['before'] = $before;

        return $self;
    }
}
