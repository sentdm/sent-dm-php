<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse\Data\Event;

use SentDm\Core\Concerns\SdkUnion;
use SentDm\Core\Conversion\Contracts\Converter;
use SentDm\Core\Conversion\Contracts\ConverterSource;
use SentDm\Webhooks\InboundMessageEvent;
use SentDm\Webhooks\MessageEvent;
use SentDm\Webhooks\TemplateEvent;

/**
 * The exact event body that was delivered, or attempted, for this record. One of the three
 * webhook envelopes: a message status change, an inbound message, or a template status change.
 * Read field and event to tell which, the same way your endpoint does.
 *
 * @phpstan-import-type MessageEventShape from \SentDm\Webhooks\MessageEvent
 * @phpstan-import-type InboundMessageEventShape from \SentDm\Webhooks\InboundMessageEvent
 * @phpstan-import-type TemplateEventShape from \SentDm\Webhooks\TemplateEvent
 *
 * @phpstan-type EventDataVariants = MessageEvent|InboundMessageEvent|TemplateEvent
 * @phpstan-type EventDataShape = EventDataVariants|MessageEventShape|InboundMessageEventShape|TemplateEventShape
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
            MessageEvent::class, InboundMessageEvent::class, TemplateEvent::class,
        ];
    }
}
