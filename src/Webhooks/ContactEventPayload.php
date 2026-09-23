<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of a contact.opt_in, contact.opt_out, contact.help or
 * contact.custom_keyword event. Delivered when a contact signals a consent change, asks for
 * help, or sends one of your own auto-reply keywords.
 *
 * These events state the signal outright, so you do not have to recognise keywords in the
 * text of a message.received event. They also cover cases that produce no inbound message
 * at all, such as a network handling an opt-out on your behalf.
 *
 * Two of the four change consent and two do not: contact.help and
 * contact.custom_keyword report the state the contact already had. Read opt_out for
 * the state and the envelope's event for what happened, rather than inferring one from the
 * other.
 *
 * Fields are ordered identity → resulting state → provenance → join keys. The two
 * parties are from and to. Note that the message family has not moved to those
 * names yet — message.received still calls the same two parties
 * inbound_number and outbound_number. Nothing here restates the
 * envelope: which signal occurred is the envelope's event, and when it was emitted is its
 * timestamp. Retries carry the same X-Webhook-Event-ID header, which is what to
 * deduplicate on.
 *
 * @phpstan-type ContactEventPayloadShape = array{
 *   optOut: bool,
 *   source: string,
 *   accountID?: string|null,
 *   agentID?: string|null,
 *   channel?: string|null,
 *   contactID?: string|null,
 *   from?: string|null,
 *   messageID?: string|null,
 *   templateID?: string|null,
 *   text?: string|null,
 *   to?: string|null,
 * }
 */
final class ContactEventPayload implements BaseModel
{
    /** @use SdkModel<ContactEventPayloadShape> */
    use SdkModel;

    /**
     * Whether the contact is opted out after this signal — the state to write to your own record.
     * Same meaning as opt_out on the contact resource. On contact.help and
     * contact.custom_keyword this reports the contact's existing state, which neither
     * changes.
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
     * The RCS agent the signal reached, when it reached one.
     *
     * Omitted entirely on channels that have no agent, rather than sent as null — an SMS
     * or WhatsApp payload does not carry this key at all. On RCS it is the counterpart to
     * To: a contact reaches an agent rather than a number, so exactly one of the
     * two is populated and never both. If you run more than one agent, this is what tells you
     * which of them the contact acted on.
     */
    #[Optional('agent_id', nullable: true)]
    public ?string $agentID;

    /**
     * The channel the signal arrived on, for example sms or whatsapp.
     */
    #[Optional]
    public ?string $channel;

    /**
     * The contact who raised the signal. Always populated, including for contact.help or
     * contact.custom_keyword from a number you have not messaged before — the contact is
     * created if it does not exist yet, so this identifier is always resolvable against the
     * contacts API.
     */
    #[Optional('contact_id')]
    public ?string $contactID;

    /**
     * The contact's number, in E.164 format with the leading + — who raised the signal.
     * The same party message.received publishes as inbound_number.
     */
    #[Optional]
    public ?string $from;

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
     * The auto-reply template whose keyword the contact matched, joinable against the templates
     * API.
     *
     * This is what identifies which signal arrived on
     * contact.custom_keyword: every custom template reports the same event name, so the
     * event alone cannot tell your booking keyword from your opening-hours one. One template holds
     * as many keywords as you configured, so this is steadier to switch on than text.
     *
     * Populated on the compliance sub-types too, where it names the template that replied.
     * Sent as null when no template was involved — a network-reported opt-out matches no
     * keyword. The field is always present, so read it and check for null.
     */
    #[Optional('template_id', nullable: true)]
    public ?string $templateID;

    /**
     * The text the contact sent, for example STOP or UNSUBSCRIBE. Sent as
     * null when the signal did not arrive as text. The field is always present, so read it
     * and check for null rather than checking whether the key exists.
     */
    #[Optional(nullable: true)]
    public ?string $text;

    /**
     * The number of yours that received the signal, in E.164 format with the leading +.
     * Tells a multi-number account which of its senders the contact acted on, which nothing else
     * on this payload answers.
     *
     * This is your number, not the contact's. That is the opposite of what
     * to means on POST /v3/messages, where it is the list of recipients you are
     * sending to. Reply to From, not to this field, or the message goes back to
     * yourself.
     *
     * Sent as null when the signal did not arrive at a number of yours — an RCS
     * signal terminates at an agent rather than a number, and a provider-reported opt-out may
     * name no receiving number at all. The field is always present, so read it and check for null
     * rather than checking whether the key exists.
     */
    #[Optional(nullable: true)]
    public ?string $to;

    /**
     * `new ContactEventPayload()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactEventPayload::with(optOut: ..., source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactEventPayload)->withOptOut(...)->withSource(...)
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
        ?string $agentID = null,
        ?string $channel = null,
        ?string $contactID = null,
        ?string $from = null,
        ?string $messageID = null,
        ?string $templateID = null,
        ?string $text = null,
        ?string $to = null,
    ): self {
        $self = new self;

        $self['optOut'] = $optOut;
        $self['source'] = $source;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $agentID && $self['agentID'] = $agentID;
        null !== $channel && $self['channel'] = $channel;
        null !== $contactID && $self['contactID'] = $contactID;
        null !== $from && $self['from'] = $from;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $text && $self['text'] = $text;
        null !== $to && $self['to'] = $to;

        return $self;
    }

    /**
     * Whether the contact is opted out after this signal — the state to write to your own record.
     * Same meaning as opt_out on the contact resource. On contact.help and
     * contact.custom_keyword this reports the contact's existing state, which neither
     * changes.
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
     * The RCS agent the signal reached, when it reached one.
     *
     * Omitted entirely on channels that have no agent, rather than sent as null — an SMS
     * or WhatsApp payload does not carry this key at all. On RCS it is the counterpart to
     * To: a contact reaches an agent rather than a number, so exactly one of the
     * two is populated and never both. If you run more than one agent, this is what tells you
     * which of them the contact acted on.
     */
    public function withAgentID(?string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

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
     * The contact who raised the signal. Always populated, including for contact.help or
     * contact.custom_keyword from a number you have not messaged before — the contact is
     * created if it does not exist yet, so this identifier is always resolvable against the
     * contacts API.
     */
    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }

    /**
     * The contact's number, in E.164 format with the leading + — who raised the signal.
     * The same party message.received publishes as inbound_number.
     */
    public function withFrom(string $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

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
     * The auto-reply template whose keyword the contact matched, joinable against the templates
     * API.
     *
     * This is what identifies which signal arrived on
     * contact.custom_keyword: every custom template reports the same event name, so the
     * event alone cannot tell your booking keyword from your opening-hours one. One template holds
     * as many keywords as you configured, so this is steadier to switch on than text.
     *
     * Populated on the compliance sub-types too, where it names the template that replied.
     * Sent as null when no template was involved — a network-reported opt-out matches no
     * keyword. The field is always present, so read it and check for null.
     */
    public function withTemplateID(?string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

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

    /**
     * The number of yours that received the signal, in E.164 format with the leading +.
     * Tells a multi-number account which of its senders the contact acted on, which nothing else
     * on this payload answers.
     *
     * This is your number, not the contact's. That is the opposite of what
     * to means on POST /v3/messages, where it is the list of recipients you are
     * sending to. Reply to From, not to this field, or the message goes back to
     * yourself.
     *
     * Sent as null when the signal did not arrive at a number of yours — an RCS
     * signal terminates at an agent rather than a number, and a provider-reported opt-out may
     * name no receiving number at all. The field is always present, so read it and check for null
     * rather than checking whether the key exists.
     */
    public function withTo(?string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }
}
