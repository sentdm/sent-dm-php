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
use SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfCallWebhookPayload;
use SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayload;

/**
 * The exact event body that was delivered, or attempted, for this record. One of the six
 * webhook envelopes:
 *
 * message — an outbound message changed status.
 * message with event: message.received — someone replied to you.
 * templates — a template was approved, rejected, paused or similar.
 * channel — one of your markets moved in provisioning or compliance.
 * contact — a consent signal: opt-in, opt-out or help.
 * link — a tracked short link was clicked or a hosted file downloaded, or one
 *   expired or was revoked.
 *
 * Read field and event to tell which, the same way your endpoint does.
 * The two message envelopes are the reason that is two fields and not one: they share
 * a field and differ by event.
 *
 * Treat the list as open. It has grown twice — channel and then link —
 * and a handler that rejects an envelope it does not recognise will break on the next
 * addition rather than ignore it.
 *
 * @phpstan-import-type MessageEventShape from \SentDm\Webhooks\MessageEvent
 * @phpstan-import-type InboundMessageEventShape from \SentDm\Webhooks\InboundMessageEvent
 * @phpstan-import-type TemplateEventShape from \SentDm\Webhooks\TemplateEvent
 * @phpstan-import-type ChannelEventShape from \SentDm\Webhooks\ChannelEvent
 * @phpstan-import-type ContactEventShape from \SentDm\Webhooks\ContactEvent
 * @phpstan-import-type SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayloadShape from \SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayload
 * @phpstan-import-type SentDmServicesCommonServicesWebhooksContractsWebhookEventOfCallWebhookPayloadShape from \SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfCallWebhookPayload
 *
 * @phpstan-type EventDataVariants = MessageEvent|InboundMessageEvent|TemplateEvent|ChannelEvent|ContactEvent|SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayload|SentDmServicesCommonServicesWebhooksContractsWebhookEventOfCallWebhookPayload
 * @phpstan-type EventDataShape = EventDataVariants|MessageEventShape|InboundMessageEventShape|TemplateEventShape|ChannelEventShape|ContactEventShape|SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayloadShape|SentDmServicesCommonServicesWebhooksContractsWebhookEventOfCallWebhookPayloadShape
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
            SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayload::class,
            SentDmServicesCommonServicesWebhooksContractsWebhookEventOfCallWebhookPayload::class,
        ];
    }
}
