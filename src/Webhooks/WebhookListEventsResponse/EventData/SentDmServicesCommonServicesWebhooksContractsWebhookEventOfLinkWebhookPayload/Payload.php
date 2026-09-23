<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfLinkWebhookPayload;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of a link event: something happened to a tracked link Sent published on the customer's
 * behalf. A link points either at a URL the customer supplied or at a file Sent hosts for them;
 * LinkKind says which. Delivered when an eligible request is served, or when a
 * published link reaches the end of its life.
 *
 * A click is a request, not a read receipt. link.clicked means the redirect
 * was served; link.downloaded means bytes went out. Neither proves a person saw anything —
 * messaging providers and link scanners fetch URLs on their own, which is what
 * TrafficClass exists to tell apart. Filter on it before reporting a click-through
 * rate; treat likely_human as a hint, never as delivery confirmation.
 *
 * RecordId identifies the link; the X-Webhook-Event-ID header
 * identifies the delivery. One link is hit many times, so those are the two keys a
 * subscriber needs: group by the first, deduplicate on the second — exactly as on every other
 * family. The payload carries no event identifier of its own, for the same reason none of the
 * others do.
 *
 * Nothing here identifies the visitor. No IP address and no visitor token crosses
 * this boundary. Country, Device and Browser are coarse
 * buckets derived at the edge and are absent whenever the request did not supply enough to derive
 * them.
 *
 * @phpstan-type PayloadShape = array{
 *   recordID: string,
 *   accessCountry?: string|null,
 *   accessOutcome?: string|null,
 *   browser?: string|null,
 *   bytesServed?: int|null,
 *   channel?: string|null,
 *   customerID?: string|null,
 *   device?: string|null,
 *   linkKind?: string|null,
 *   messageID?: string|null,
 *   occurredAt?: string|null,
 *   referenceKey?: string|null,
 *   referrerHost?: string|null,
 *   requestMethod?: string|null,
 *   senderProfileID?: string|null,
 *   statusCode?: int|null,
 *   trafficClass?: string|null,
 * }
 */
final class Payload implements BaseModel
{
    /** @use SdkModel<PayloadShape> */
    use SdkModel;

    /**
     * The link's public identifier — the eight-character code in the short URL, for example
     * A78B2BU0. Unique across both kinds, and never reused, so it is the stable key to
     * group one link's events by.
     */
    #[Required('record_id')]
    public string $recordID;

    /**
     * Where the request appeared to come from, as an ISO 3166-1 alpha-2 code. Named separately
     * from the country on a channel event, which is a destination market the customer
     * registered for — this one is a property of a single visitor and is absent when the edge
     * could not resolve it.
     */
    #[Optional('access_country', nullable: true)]
    public ?string $accessCountry;

    /**
     * How the request was served, when the edge recorded it. Free text describing the outcome —
     * show it to a human rather than branching on it.
     */
    #[Optional('access_outcome', nullable: true)]
    public ?string $accessOutcome;

    /**
     * The requesting browser family, for example chrome or safari, or
     * unknown. Derived from the user agent.
     */
    #[Optional(nullable: true)]
    public ?string $browser;

    /**
     * How many bytes were served, for a file access. A ranged request reports the bytes in that
     * range, not the size of the file, so several accesses of one file can each report a part.
     */
    #[Optional('bytes_served', nullable: true)]
    public ?int $bytesServed;

    /**
     * The channel the message carrying this link went out on: sms, whatsapp, or
     * rcs.
     */
    #[Optional(nullable: true)]
    public ?string $channel;

    /**
     * The organization the link belongs to. Always the parent account, never a sender profile —
     * read SenderProfileId for that.
     *
     * This family publishes the owner as an explicit pair rather than the single
     * account_id the other families use. The pair says which organization and which
     * profile without the subscriber deriving either, which is the trade: one more key against
     * not having to know that account_id silently becomes the profile when one exists.
     */
    #[Optional('customer_id')]
    public ?string $customerID;

    /**
     * The requesting device class: mobile, tablet, desktop or
     * unknown. Derived from the user agent.
     */
    #[Optional(nullable: true)]
    public ?string $device;

    /**
     * What the link points at: url for a destination the customer supplied, file for
     * media Sent hosts. Always present, and implied by the event — link.clicked is always
     * url and link.downloaded always file — but published as its own field so
     * a subscriber can branch on the kind without parsing the event name, the same separation the
     * channel family keeps between its event and its status.
     */
    #[Optional('link_kind')]
    public ?string $linkKind;

    /**
     * The message the link was published in.
     *
     * The event can arrive before the message is readable through GET /v3/messages:
     * a provider may fetch a link within milliseconds of the send, and nothing here waits for the
     * message row. Retry the read rather than treating an unknown id as an error.
     */
    #[Optional('message_id', nullable: true)]
    public ?string $messageID;

    /**
     * When the access or lifecycle change actually happened, in UTC
     * (yyyy-MM-ddTHH:mm:ssZ). The envelope's timestamp is when Sent emitted the
     * event; this is when the thing occurred, and the two differ by the ingest delay.
     */
    #[Optional('occurred_at')]
    public ?string $occurredAt;

    /**
     * The caller-supplied label tying this link back to a position in the message, for example
     * body:0 for the first link in the body. Present when the link was created with one.
     */
    #[Optional('reference_key', nullable: true)]
    public ?string $referenceKey;

    /**
     * The host of the page that linked here, when the request supplied one. The host only — never
     * a full referring URL.
     */
    #[Optional('referrer_host', nullable: true)]
    public ?string $referrerHost;

    /**
     * The HTTP method of the request that was served, for an access event. Omitted on
     * link.expired and link.revoked, which describe no request.
     */
    #[Optional('request_method', nullable: true)]
    public ?string $requestMethod;

    /**
     * The sender profile that owns the link, or null when the organization owns it directly.
     * Always on the wire so a handler reads one shape rather than branching on whether the key
     * arrived.
     *
     * sender_profile_id, not profile_id: the API already publishes
     * messaging_profile_id and sending_phone_number_profile_id for provider-side
     * profiles, which are a different thing entirely. The unqualified name would read as one of
     * those.
     */
    #[Optional('sender_profile_id', nullable: true)]
    public ?string $senderProfileID;

    /**
     * The HTTP status Sent answered the request with: 302 for a link, 200 or
     * 206 for a file. Omitted on lifecycle events.
     */
    #[Optional('status_code', nullable: true)]
    public ?int $statusCode;

    /**
     * A coarse guess at what made the request: likely_human, provider (a messaging
     * platform prefetching the link), bot, or unknown. Derived from the user agent,
     * so it is a hint for filtering noise rather than a fact to bill or report on.
     */
    #[Optional('traffic_class', nullable: true)]
    public ?string $trafficClass;

    /**
     * `new Payload()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Payload::with(recordID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Payload)->withRecordID(...)
     * ```
     */
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
        string $recordID,
        ?string $accessCountry = null,
        ?string $accessOutcome = null,
        ?string $browser = null,
        ?int $bytesServed = null,
        ?string $channel = null,
        ?string $customerID = null,
        ?string $device = null,
        ?string $linkKind = null,
        ?string $messageID = null,
        ?string $occurredAt = null,
        ?string $referenceKey = null,
        ?string $referrerHost = null,
        ?string $requestMethod = null,
        ?string $senderProfileID = null,
        ?int $statusCode = null,
        ?string $trafficClass = null,
    ): self {
        $self = new self;

        $self['recordID'] = $recordID;

        null !== $accessCountry && $self['accessCountry'] = $accessCountry;
        null !== $accessOutcome && $self['accessOutcome'] = $accessOutcome;
        null !== $browser && $self['browser'] = $browser;
        null !== $bytesServed && $self['bytesServed'] = $bytesServed;
        null !== $channel && $self['channel'] = $channel;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $device && $self['device'] = $device;
        null !== $linkKind && $self['linkKind'] = $linkKind;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $occurredAt && $self['occurredAt'] = $occurredAt;
        null !== $referenceKey && $self['referenceKey'] = $referenceKey;
        null !== $referrerHost && $self['referrerHost'] = $referrerHost;
        null !== $requestMethod && $self['requestMethod'] = $requestMethod;
        null !== $senderProfileID && $self['senderProfileID'] = $senderProfileID;
        null !== $statusCode && $self['statusCode'] = $statusCode;
        null !== $trafficClass && $self['trafficClass'] = $trafficClass;

        return $self;
    }

    /**
     * The link's public identifier — the eight-character code in the short URL, for example
     * A78B2BU0. Unique across both kinds, and never reused, so it is the stable key to
     * group one link's events by.
     */
    public function withRecordID(string $recordID): self
    {
        $self = clone $this;
        $self['recordID'] = $recordID;

        return $self;
    }

    /**
     * Where the request appeared to come from, as an ISO 3166-1 alpha-2 code. Named separately
     * from the country on a channel event, which is a destination market the customer
     * registered for — this one is a property of a single visitor and is absent when the edge
     * could not resolve it.
     */
    public function withAccessCountry(?string $accessCountry): self
    {
        $self = clone $this;
        $self['accessCountry'] = $accessCountry;

        return $self;
    }

    /**
     * How the request was served, when the edge recorded it. Free text describing the outcome —
     * show it to a human rather than branching on it.
     */
    public function withAccessOutcome(?string $accessOutcome): self
    {
        $self = clone $this;
        $self['accessOutcome'] = $accessOutcome;

        return $self;
    }

    /**
     * The requesting browser family, for example chrome or safari, or
     * unknown. Derived from the user agent.
     */
    public function withBrowser(?string $browser): self
    {
        $self = clone $this;
        $self['browser'] = $browser;

        return $self;
    }

    /**
     * How many bytes were served, for a file access. A ranged request reports the bytes in that
     * range, not the size of the file, so several accesses of one file can each report a part.
     */
    public function withBytesServed(?int $bytesServed): self
    {
        $self = clone $this;
        $self['bytesServed'] = $bytesServed;

        return $self;
    }

    /**
     * The channel the message carrying this link went out on: sms, whatsapp, or
     * rcs.
     */
    public function withChannel(?string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * The organization the link belongs to. Always the parent account, never a sender profile —
     * read SenderProfileId for that.
     *
     * This family publishes the owner as an explicit pair rather than the single
     * account_id the other families use. The pair says which organization and which
     * profile without the subscriber deriving either, which is the trade: one more key against
     * not having to know that account_id silently becomes the profile when one exists.
     */
    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    /**
     * The requesting device class: mobile, tablet, desktop or
     * unknown. Derived from the user agent.
     */
    public function withDevice(?string $device): self
    {
        $self = clone $this;
        $self['device'] = $device;

        return $self;
    }

    /**
     * What the link points at: url for a destination the customer supplied, file for
     * media Sent hosts. Always present, and implied by the event — link.clicked is always
     * url and link.downloaded always file — but published as its own field so
     * a subscriber can branch on the kind without parsing the event name, the same separation the
     * channel family keeps between its event and its status.
     */
    public function withLinkKind(string $linkKind): self
    {
        $self = clone $this;
        $self['linkKind'] = $linkKind;

        return $self;
    }

    /**
     * The message the link was published in.
     *
     * The event can arrive before the message is readable through GET /v3/messages:
     * a provider may fetch a link within milliseconds of the send, and nothing here waits for the
     * message row. Retry the read rather than treating an unknown id as an error.
     */
    public function withMessageID(?string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    /**
     * When the access or lifecycle change actually happened, in UTC
     * (yyyy-MM-ddTHH:mm:ssZ). The envelope's timestamp is when Sent emitted the
     * event; this is when the thing occurred, and the two differ by the ingest delay.
     */
    public function withOccurredAt(string $occurredAt): self
    {
        $self = clone $this;
        $self['occurredAt'] = $occurredAt;

        return $self;
    }

    /**
     * The caller-supplied label tying this link back to a position in the message, for example
     * body:0 for the first link in the body. Present when the link was created with one.
     */
    public function withReferenceKey(?string $referenceKey): self
    {
        $self = clone $this;
        $self['referenceKey'] = $referenceKey;

        return $self;
    }

    /**
     * The host of the page that linked here, when the request supplied one. The host only — never
     * a full referring URL.
     */
    public function withReferrerHost(?string $referrerHost): self
    {
        $self = clone $this;
        $self['referrerHost'] = $referrerHost;

        return $self;
    }

    /**
     * The HTTP method of the request that was served, for an access event. Omitted on
     * link.expired and link.revoked, which describe no request.
     */
    public function withRequestMethod(?string $requestMethod): self
    {
        $self = clone $this;
        $self['requestMethod'] = $requestMethod;

        return $self;
    }

    /**
     * The sender profile that owns the link, or null when the organization owns it directly.
     * Always on the wire so a handler reads one shape rather than branching on whether the key
     * arrived.
     *
     * sender_profile_id, not profile_id: the API already publishes
     * messaging_profile_id and sending_phone_number_profile_id for provider-side
     * profiles, which are a different thing entirely. The unqualified name would read as one of
     * those.
     */
    public function withSenderProfileID(?string $senderProfileID): self
    {
        $self = clone $this;
        $self['senderProfileID'] = $senderProfileID;

        return $self;
    }

    /**
     * The HTTP status Sent answered the request with: 302 for a link, 200 or
     * 206 for a file. Omitted on lifecycle events.
     */
    public function withStatusCode(?int $statusCode): self
    {
        $self = clone $this;
        $self['statusCode'] = $statusCode;

        return $self;
    }

    /**
     * A coarse guess at what made the request: likely_human, provider (a messaging
     * platform prefetching the link), bot, or unknown. Derived from the user agent,
     * so it is a hint for filtering noise rather than a fact to bill or report on.
     */
    public function withTrafficClass(?string $trafficClass): self
    {
        $self = clone $this;
        $self['trafficClass'] = $trafficClass;

        return $self;
    }
}
