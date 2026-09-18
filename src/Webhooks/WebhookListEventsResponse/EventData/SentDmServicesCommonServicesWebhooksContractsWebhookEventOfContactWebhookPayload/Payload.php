<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfContactWebhookPayload;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of a contact.opt_in, contact.opt_out or contact.help event. Delivered
 * when a contact signals a consent change or asks for help.
 *
 * These events state the signal outright, so you do not have to recognise keywords in the
 * text of a message.received event. They also cover cases that produce no inbound message
 * at all, such as a network handling an opt-out on your behalf.
 *
 * Fields are ordered identity → resulting state → provenance → join key. Nothing here
 * restates the envelope: which of the three signals occurred is the envelope's event, and
 * when it was emitted is its timestamp. Retries carry the same X-Webhook-Event-ID
 * header, which is what to deduplicate on.
 *
 * @phpstan-type PayloadShape = array{
 *   optOut: bool,
 *   source: string,
 *   accountID?: string|null,
 *   channel?: string|null,
 *   contactID?: string|null,
 *   messageID?: string|null,
 *   phoneNumber?: string|null,
 *   text?: string|null,
 * }
 */
final class Payload implements BaseModel
{
    /** @use SdkModel<PayloadShape> */
    use SdkModel;

    /**
     * Whether the contact is opted out after this signal — the state to write to your own record.
     * Same meaning as opt_out on the contact resource. On contact.help this reports
     * the contact's existing state, which help does not change.
     *
     * Two signals from the same contact can arrive out of order, because each one is queued
     * on its own rather than against the contact. Compare the envelope's timestamp before
     * you overwrite a newer state with an older one. That timestamp is second-precision, so treat
     * two signals stamped in the same second as unordered and read the contact resource to settle
     * them.
     */
    #[Required('opt_out')]
    public bool $optOut;

    /**
     * How the signal reached us. INBOUND_KEYWORD means the contact sent a message whose
     * text matched one of the keywords; PROVIDER_SIGNAL means the network reported it.
     * A provider signal usually carries no message_id or text, so read both for null
     * rather than inferring them from this field.
     */
    #[Required]
    public string $source;

    /**
     * The account the contact belongs to. Present so one endpoint can serve several accounts.
     */
    #[Optional('account_id')]
    public ?string $accountID;

    /**
     * The channel the signal arrived on, for example sms or whatsapp.
     */
    #[Optional]
    public ?string $channel;

    /**
     * The contact who raised the signal. Always populated, including for contact.help from
     * a number you have not messaged before — the contact is created if it does not exist yet, so
     * this identifier is always resolvable against the contacts API.
     */
    #[Optional('contact_id')]
    public ?string $contactID;

    /**
     * The inbound message that carried the signal, matching message_id on the
     * corresponding message.received event so the two can be joined.
     *
     * Sent as null when the signal did not arrive as a message — for example when a
     * network processed an opt-out on your behalf — and also when the message belongs to a
     * different account than this event, which can happen on a shared WhatsApp number. The field
     * is always present, so read it and check for null rather than checking whether the key
     * exists.
     */
    #[Optional('message_id', nullable: true)]
    public ?string $messageID;

    /**
     * The contact's number in E.164 format. Same value as phone_number on the contact
     * resource.
     */
    #[Optional('phone_number')]
    public ?string $phoneNumber;

    /**
     * The text the contact sent, for example STOP or UNSUBSCRIBE. Sent as
     * null when the signal did not arrive as text. The field is always present, so read it
     * and check for null rather than checking whether the key exists.
     */
    #[Optional(nullable: true)]
    public ?string $text;

    /**
     * `new Payload()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Payload::with(optOut: ..., source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Payload)->withOptOut(...)->withSource(...)
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
        bool $optOut,
        string $source,
        ?string $accountID = null,
        ?string $channel = null,
        ?string $contactID = null,
        ?string $messageID = null,
        ?string $phoneNumber = null,
        ?string $text = null,
    ): self {
        $self = new self;

        $self['optOut'] = $optOut;
        $self['source'] = $source;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $channel && $self['channel'] = $channel;
        null !== $contactID && $self['contactID'] = $contactID;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * Whether the contact is opted out after this signal — the state to write to your own record.
     * Same meaning as opt_out on the contact resource. On contact.help this reports
     * the contact's existing state, which help does not change.
     *
     * Two signals from the same contact can arrive out of order, because each one is queued
     * on its own rather than against the contact. Compare the envelope's timestamp before
     * you overwrite a newer state with an older one. That timestamp is second-precision, so treat
     * two signals stamped in the same second as unordered and read the contact resource to settle
     * them.
     */
    public function withOptOut(bool $optOut): self
    {
        $self = clone $this;
        $self['optOut'] = $optOut;

        return $self;
    }

    /**
     * How the signal reached us. INBOUND_KEYWORD means the contact sent a message whose
     * text matched one of the keywords; PROVIDER_SIGNAL means the network reported it.
     * A provider signal usually carries no message_id or text, so read both for null
     * rather than inferring them from this field.
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * The account the contact belongs to. Present so one endpoint can serve several accounts.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * The channel the signal arrived on, for example sms or whatsapp.
     */
    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * The contact who raised the signal. Always populated, including for contact.help from
     * a number you have not messaged before — the contact is created if it does not exist yet, so
     * this identifier is always resolvable against the contacts API.
     */
    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }

    /**
     * The inbound message that carried the signal, matching message_id on the
     * corresponding message.received event so the two can be joined.
     *
     * Sent as null when the signal did not arrive as a message — for example when a
     * network processed an opt-out on your behalf — and also when the message belongs to a
     * different account than this event, which can happen on a shared WhatsApp number. The field
     * is always present, so read it and check for null rather than checking whether the key
     * exists.
     */
    public function withMessageID(?string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    /**
     * The contact's number in E.164 format. Same value as phone_number on the contact
     * resource.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * The text the contact sent, for example STOP or UNSUBSCRIBE. Sent as
     * null when the signal did not arrive as text. The field is always present, so read it
     * and check for null rather than checking whether the key exists.
     */
    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
