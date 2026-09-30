<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\ChannelEventPayload\Compliance;

/**
 * Body of a channel event: where one of the customer's channels stands in provisioning and
 * compliance. Delivered when a milestone moves — a registration filed, a verdict returned, a
 * resubmission asked for, a sender gone live — so a customer's own onboarding UI does not have to
 * poll GET /v3/channels.
 *
 * The subject is one item, never the account. A customer's "SMS channel" has no
 * status; a market does. Country, NumberType and
 * SenderValue name which one, so a customer terminating only to Kosovo never
 * receives an event about US 10DLC.
 *
 * Status is the stable half of the contract. It is the same four-value
 * set GET /v3/channels publishes, computed through the same code, so an event and a read of
 * the same market cannot disagree. A subscriber that reads nothing but the status and the subject
 * fields is a correct subscriber. The sub-type on the envelope names the specific milestone and is
 * additive — that vocabulary comes from registries and carriers, which are parties Sent does not
 * control.
 *
 * Status means provisioning and compliance are complete, not that a send
 * will succeed right now. An account can be suspended, or a destination blocked by a routing
 * rule, without either showing up here. Those are separate surfaces and deliberately not modelled
 * on this payload.
 *
 * @phpstan-import-type ComplianceShape from \SentDm\Webhooks\ChannelEventPayload\Compliance
 *
 * @phpstan-type ChannelEventPayloadShape = array{
 *   country: string,
 *   accountID?: string|null,
 *   channel?: string|null,
 *   compliance?: null|Compliance|ComplianceShape,
 *   numberType?: string|null,
 *   reason?: string|null,
 *   reasonCode?: string|null,
 *   senderValue?: string|null,
 *   status?: string|null,
 *   updatedAt?: string|null,
 * }
 */
final class ChannelEventPayload implements BaseModel
{
    /** @use SdkModel<ChannelEventPayloadShape> */
    use SdkModel;

    /**
     * The market's destination country as an ISO 3166-1 alpha-2 code, for example XK. Always
     * present, and the property that identifies this payload among the delivered envelopes — see
     * DeliveredWebhookEvents. Every event in this family reports one market, and a market has
     * a country.
     */
    #[Required]
    public string $country;

    /**
     * The account whose market this is, named as on every other family. When an organization
     * receives an event for one of its sender profiles this is the profile, so a reseller compares
     * it with its own id and anything different is one of its profiles.
     * Matches customer_id on GET /v3/channels and the sender profile's id.
     * Together with channel, country, and number_type, it identifies the market.
     */
    #[Optional('account_id')]
    public ?string $accountID;

    /**
     * The channel this market belongs to: sms, whatsapp, or rcs. Never
     * sent — that value belongs to message events, where it names the smart-routing brand
     * rather than a channel that can be provisioned.
     */
    #[Optional]
    public ?string $channel;

    /**
     * What a market has been given: the identity it registers under, its programme, and any documents attached.
     *
     * What it does not carry is what the market asks for. That is the subject of
     * GET /v3/compliance/requirements, and it is the same answer for every caller — a description of what
     * a compliance regime wants, not a record of one customer's progress through it. It was reported here as
     * well for a while, which put the same array in six response shapes and left a caller deciding which of two
     * sources to believe.
     *
     * Present on a list read for markets that register (carrying brand and campaign), but with
     * documents absent — documents are not fetched for a list, because a catalog lookup and a document
     * read per market would multiply across a page. Absent documents is distinct from an empty list:
     * absent says they were not fetched; empty says the market has been given none. The parent object is null
     * only when the market registers with nobody and compliance was not computed — nothing to show at all.
     */
    #[Optional(nullable: true)]
    public ?Compliance $compliance;

    /**
     * The kind of sender the market uses, for example TEN_DLC, LOCAL, or
     * ALPHANUMERIC. Omitted when the subject has no sender type of its own.
     */
    #[Optional('number_type', nullable: true)]
    public ?string $numberType;

    /**
     * Why the market reached this state, as a sentence to show a person: the specific explanation when one was
     * given (a correction explained, a campaign lapse), otherwise what reason_code means for this market.
     * Not a value to branch on.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * Why the market is not ACTIVE, as a stable code: an ErrorCodes CHANNEL_xxx value such
     * as CHANNEL_001 (something you owe) or CHANNEL_002 (a correction was requested). The same code
     * the channels resource reports for the market. Switch on this rather than on reason. Omitted while
     * ACTIVE.
     */
    #[Optional('reason_code', nullable: true)]
    public ?string $reasonCode;

    /**
     * The sender itself — a number in E.164, or an alphanumeric sender ID.
     *
     * Always present, and null until a sender exists. The key is on every delivery so a
     * subscriber reads one shape rather than branching on whether the field arrived — the same choice
     * template_id makes on the message payload.
     *
     * It can carry a value at any point in the lifecycle, not only once the market is live: a
     * number ordered and not yet active at the carrier is already known during PROVISIONING,
     * and an alphanumeric sender the customer chose themselves is known before anything is filed. It
     * is null while the market is still waiting on a number, which for a US 10DLC registration is
     * every event up to channel.activated.
     */
    #[Optional('sender_value', nullable: true)]
    public ?string $senderValue;

    /**
     * Where the market stands: PENDING_REVIEW, ACTION_NEEDED, PROVISIONING,
     * ACTIVE or INACTIVE. PENDING_REVIEW means a registry or a carrier holds it
     * and the wait is theirs; ACTION_NEEDED means it is yours; PROVISIONING means the
     * verdict is in and Sent is acquiring the sender; INACTIVE means it had a working sender
     * and no longer does.
     *
     * Each event name is the transition into one of these, but the two are separate fields
     * and may legitimately differ. A resubmission filed against a market whose sender is already
     * live is channel.submitted carrying ACTIVE: a correction is with the registry and
     * the sender keeps working. Read both.
     */
    #[Optional]
    public ?string $status;

    /**
     * When the transition happened, in UTC (yyyy-MM-ddTHH:mm:ssZ).
     */
    #[Optional('updated_at')]
    public ?string $updatedAt;

    /**
     * `new ChannelEventPayload()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChannelEventPayload::with(country: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChannelEventPayload)->withCountry(...)
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
     *
     * @param Compliance|ComplianceShape|null $compliance
     */
    public static function with(
        string $country,
        ?string $accountID = null,
        ?string $channel = null,
        Compliance|array|null $compliance = null,
        ?string $numberType = null,
        ?string $reason = null,
        ?string $reasonCode = null,
        ?string $senderValue = null,
        ?string $status = null,
        ?string $updatedAt = null,
    ): self {
        $self = new self;

        $self['country'] = $country;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $channel && $self['channel'] = $channel;
        null !== $compliance && $self['compliance'] = $compliance;
        null !== $numberType && $self['numberType'] = $numberType;
        null !== $reason && $self['reason'] = $reason;
        null !== $reasonCode && $self['reasonCode'] = $reasonCode;
        null !== $senderValue && $self['senderValue'] = $senderValue;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The market's destination country as an ISO 3166-1 alpha-2 code, for example XK. Always
     * present, and the property that identifies this payload among the delivered envelopes — see
     * DeliveredWebhookEvents. Every event in this family reports one market, and a market has
     * a country.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * The account whose market this is, named as on every other family. When an organization
     * receives an event for one of its sender profiles this is the profile, so a reseller compares
     * it with its own id and anything different is one of its profiles.
     * Matches customer_id on GET /v3/channels and the sender profile's id.
     * Together with channel, country, and number_type, it identifies the market.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * The channel this market belongs to: sms, whatsapp, or rcs. Never
     * sent — that value belongs to message events, where it names the smart-routing brand
     * rather than a channel that can be provisioned.
     */
    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * What a market has been given: the identity it registers under, its programme, and any documents attached.
     *
     * What it does not carry is what the market asks for. That is the subject of
     * GET /v3/compliance/requirements, and it is the same answer for every caller — a description of what
     * a compliance regime wants, not a record of one customer's progress through it. It was reported here as
     * well for a while, which put the same array in six response shapes and left a caller deciding which of two
     * sources to believe.
     *
     * Present on a list read for markets that register (carrying brand and campaign), but with
     * documents absent — documents are not fetched for a list, because a catalog lookup and a document
     * read per market would multiply across a page. Absent documents is distinct from an empty list:
     * absent says they were not fetched; empty says the market has been given none. The parent object is null
     * only when the market registers with nobody and compliance was not computed — nothing to show at all.
     *
     * @param Compliance|ComplianceShape|null $compliance
     */
    public function withCompliance(Compliance|array|null $compliance): self
    {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    /**
     * The kind of sender the market uses, for example TEN_DLC, LOCAL, or
     * ALPHANUMERIC. Omitted when the subject has no sender type of its own.
     */
    public function withNumberType(?string $numberType): self
    {
        $self = clone $this;
        $self['numberType'] = $numberType;

        return $self;
    }

    /**
     * Why the market reached this state, as a sentence to show a person: the specific explanation when one was
     * given (a correction explained, a campaign lapse), otherwise what reason_code means for this market.
     * Not a value to branch on.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the market is not ACTIVE, as a stable code: an ErrorCodes CHANNEL_xxx value such
     * as CHANNEL_001 (something you owe) or CHANNEL_002 (a correction was requested). The same code
     * the channels resource reports for the market. Switch on this rather than on reason. Omitted while
     * ACTIVE.
     */
    public function withReasonCode(?string $reasonCode): self
    {
        $self = clone $this;
        $self['reasonCode'] = $reasonCode;

        return $self;
    }

    /**
     * The sender itself — a number in E.164, or an alphanumeric sender ID.
     *
     * Always present, and null until a sender exists. The key is on every delivery so a
     * subscriber reads one shape rather than branching on whether the field arrived — the same choice
     * template_id makes on the message payload.
     *
     * It can carry a value at any point in the lifecycle, not only once the market is live: a
     * number ordered and not yet active at the carrier is already known during PROVISIONING,
     * and an alphanumeric sender the customer chose themselves is known before anything is filed. It
     * is null while the market is still waiting on a number, which for a US 10DLC registration is
     * every event up to channel.activated.
     */
    public function withSenderValue(?string $senderValue): self
    {
        $self = clone $this;
        $self['senderValue'] = $senderValue;

        return $self;
    }

    /**
     * Where the market stands: PENDING_REVIEW, ACTION_NEEDED, PROVISIONING,
     * ACTIVE or INACTIVE. PENDING_REVIEW means a registry or a carrier holds it
     * and the wait is theirs; ACTION_NEEDED means it is yours; PROVISIONING means the
     * verdict is in and Sent is acquiring the sender; INACTIVE means it had a working sender
     * and no longer does.
     *
     * Each event name is the transition into one of these, but the two are separate fields
     * and may legitimately differ. A resubmission filed against a market whose sender is already
     * live is channel.submitted carrying ACTIVE: a correction is with the registry and
     * the sender keeps working. Read both.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When the transition happened, in UTC (yyyy-MM-ddTHH:mm:ssZ).
     */
    public function withUpdatedAt(string $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
