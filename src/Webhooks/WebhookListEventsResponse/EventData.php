<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse;

use SentDm\Core\Concerns\SdkUnion;
use SentDm\Core\Conversion\Contracts\Converter;
use SentDm\Core\Conversion\Contracts\ConverterSource;
use SentDm\Webhooks\ChannelEvent;
use SentDm\Webhooks\ContactEvent;
use SentDm\Webhooks\InboundMessageEvent;
use SentDm\Webhooks\MessageEvent;
use SentDm\Webhooks\TemplateEvent;

/**
 * The exact event body that was delivered, or attempted, for this record. One of the four
 * webhook envelopes: a message status change, an inbound message, a template status change, or
 * a contact consent signal. Read field and event to tell which, the same way
 * your endpoint does.
 *
 * @phpstan-import-type MessageEventShape from \SentDm\Webhooks\MessageEvent
 * @phpstan-import-type InboundMessageEventShape from \SentDm\Webhooks\InboundMessageEvent
 * @phpstan-import-type TemplateEventShape from \SentDm\Webhooks\TemplateEvent
 * @phpstan-import-type ChannelEventShape from \SentDm\Webhooks\ChannelEvent
 * @phpstan-import-type ContactEventShape from \SentDm\Webhooks\ContactEvent
 *
 * @phpstan-type EventDataVariants = MessageEvent|InboundMessageEvent|TemplateEvent|ChannelEvent|ContactEvent
 * @phpstan-type EventDataShape = EventDataVariants|MessageEventShape|InboundMessageEventShape|TemplateEventShape|ChannelEventShape|ContactEventShape
 */
final class EventData implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            MessageEvent::class,
            InboundMessageEvent::class,
            TemplateEvent::class,
            ChannelEvent::class,
            ContactEvent::class,
        ];
    }
}
