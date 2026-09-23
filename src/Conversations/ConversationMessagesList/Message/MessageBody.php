<?php

declare(strict_types=1);

namespace SentDm\Conversations\ConversationMessagesList\Message;

use SentDm\Conversations\ConversationMessagesList\Message\MessageBody\Button;
use SentDm\Conversations\ConversationMessagesList\Message\MessageBody\HeaderMedia;
use SentDm\Conversations\ConversationMessagesList\Message\MessageBody\Media;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Structured message body format for database storage.
 * Preserves channel-specific components (header, header media, body, footer, buttons, MMS subject
 * and media).
 *
 * Persisted as the messageBody jsonb column on Messages. Every write path goes
 * through MessageUtils.MessageBodyJsonOptions, which writes nulls, so the envelope shape is
 * stable regardless of channel or status. Anything that rebuilds this object field by field — the
 * four IMessageBodyStrategy implementations and MessageUtils.BuildSegmentBody — has to
 * carry every member, or that member is silently dropped on whichever path forgot it.
 *
 * @phpstan-import-type ButtonShape from \SentDm\Conversations\ConversationMessagesList\Message\MessageBody\Button
 * @phpstan-import-type HeaderMediaShape from \SentDm\Conversations\ConversationMessagesList\Message\MessageBody\HeaderMedia
 * @phpstan-import-type MediaShape from \SentDm\Conversations\ConversationMessagesList\Message\MessageBody\Media
 *
 * @phpstan-type MessageBodyShape = array{
 *   buttons?: list<Button|ButtonShape>|null,
 *   content?: string|null,
 *   footer?: string|null,
 *   header?: string|null,
 *   headerMedia?: null|HeaderMedia|HeaderMediaShape,
 *   media?: list<Media|MediaShape>|null,
 *   subject?: string|null,
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

    /**
     * The media asset that rode a message's header, recorded as sent.
     */
    #[Optional(nullable: true)]
    public ?HeaderMedia $headerMedia;

    /**
     * MMS attachments, as the publicly fetchable URLs handed to the carrier. Null on every other
     * channel.
     *
     * Persisted rather than derived because a resend and a curfew release rebuild the send from
     * the stored row — MessageReplayCommandBuilder reads templateId and
     * templateVariables and nothing else — so media that lives only on the original request
     * would silently turn a replayed MMS into a text message.
     *
     * @var list<Media>|null $media
     */
    #[Optional(list: Media::class, nullable: true)]
    public ?array $media;

    /**
     * MMS subject line. Null on every other channel.
     */
    #[Optional(nullable: true)]
    public ?string $subject;

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
     * @param HeaderMedia|HeaderMediaShape|null $headerMedia
     * @param list<Media|MediaShape>|null $media
     */
    public static function with(
        ?array $buttons = null,
        ?string $content = null,
        ?string $footer = null,
        ?string $header = null,
        HeaderMedia|array|null $headerMedia = null,
        ?array $media = null,
        ?string $subject = null,
    ): self {
        $self = new self;

        null !== $buttons && $self['buttons'] = $buttons;
        null !== $content && $self['content'] = $content;
        null !== $footer && $self['footer'] = $footer;
        null !== $header && $self['header'] = $header;
        null !== $headerMedia && $self['headerMedia'] = $headerMedia;
        null !== $media && $self['media'] = $media;
        null !== $subject && $self['subject'] = $subject;

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

    /**
     * The media asset that rode a message's header, recorded as sent.
     *
     * @param HeaderMedia|HeaderMediaShape|null $headerMedia
     */
    public function withHeaderMedia(HeaderMedia|array|null $headerMedia): self
    {
        $self = clone $this;
        $self['headerMedia'] = $headerMedia;

        return $self;
    }

    /**
     * MMS attachments, as the publicly fetchable URLs handed to the carrier. Null on every other
     * channel.
     *
     * Persisted rather than derived because a resend and a curfew release rebuild the send from
     * the stored row — MessageReplayCommandBuilder reads templateId and
     * templateVariables and nothing else — so media that lives only on the original request
     * would silently turn a replayed MMS into a text message.
     *
     * @param list<Media|MediaShape>|null $media
     */
    public function withMedia(?array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * MMS subject line. Null on every other channel.
     */
    public function withSubject(?string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }
}
