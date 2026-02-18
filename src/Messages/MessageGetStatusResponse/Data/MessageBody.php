<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetStatusResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageGetStatusResponse\Data\MessageBody\Button;

/**
 * Structured message body format for database storage.
 * Preserves channel-specific components (header, body, footer, buttons).
 *
 * @phpstan-import-type ButtonShape from \SentDm\Messages\MessageGetStatusResponse\Data\MessageBody\Button
 *
 * @phpstan-type MessageBodyShape = array{
 *   buttons?: list<Button|ButtonShape>|null,
 *   content?: string|null,
 *   footer?: string|null,
 *   header?: string|null,
 * }
 */
final class MessageBody implements BaseModel
{
    /** @use SdkModel<MessageBodyShape> */
    use SdkModel;

    /** @var list<Button>|null $buttons */
    #[Optional(list: Button::class, nullable: true)]
    public ?array $buttons;

    #[Optional]
    public ?string $content;

    #[Optional(nullable: true)]
    public ?string $footer;

    #[Optional(nullable: true)]
    public ?string $header;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Button|ButtonShape>|null $buttons
     */
    public static function with(
        ?array $buttons = null,
        ?string $content = null,
        ?string $footer = null,
        ?string $header = null,
    ): self {
        $self = new self;

        null !== $buttons && $self['buttons'] = $buttons;
        null !== $content && $self['content'] = $content;
        null !== $footer && $self['footer'] = $footer;
        null !== $header && $self['header'] = $header;

        return $self;
    }

    /**
     * @param list<Button|ButtonShape>|null $buttons
     */
    public function withButtons(?array $buttons): self
    {
        $self = clone $this;
        $self['buttons'] = $buttons;

        return $self;
    }

    public function withContent(string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withFooter(?string $footer): self
    {
        $self = clone $this;
        $self['footer'] = $footer;

        return $self;
    }

    public function withHeader(?string $header): self
    {
        $self = clone $this;
        $self['header'] = $header;

        return $self;
    }
}
