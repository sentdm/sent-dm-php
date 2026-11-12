<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a sender profile under your organization. A profile is a customer of yours: it sends under its own or your identity, and your customers never see Sent.
 *
 * ## The minimum
 *
 * `{ "name": "Example Retail", "short_name": "Example" }`. `short_name` is the SMS sender id and is required. Inbox and opt-out list come from your organization. Its brand and campaign are your organization's only where `compliance` says `{ "inherit": true }` — omitted, the profile has neither. Billing defaults to the profile's own balance, with your organization covering what it cannot.
 *
 * **A sender is not one of them.** The brand and the campaign can be inherited; a number cannot. A profile either has a sender of its own — `channels.sms` — or it has none and reaches only the countries Sent runs a shared route for. The US has none: without a `TEN_DLC` number of its own, a profile's SMS to US numbers ends as `FAILED` with `DELIVERY_003`.
 *
 * ## Saying what a profile owns
 *
 * Every capability is one of three things, and there is no flag per state:
 *
 * - **Its own** — supply the capability's fields. Data is what owning looks like.
 * - **The organization's** — `{ "inherit": true }`, with nothing else.
 * - **None** — omit the block.
 *
 * There is no `"inherit": false` that also carries no data. A second way to say the same thing would let a request contradict itself.
 *
 * Inheriting needs no id. A customer has exactly one brand, so `brand` resolves without one.
 *
 * **The campaign has no block of its own.** It is only ever a registration, and every field of one is something a specific market demands — so it lives in `compliance`, alongside the rest of what that market asks for, and it says whose it is there too: `"compliance": { "campaign": { "inherit": true } }` runs the profile on your organization's campaign and brand, and stops this call asking for any campaign field. `"brand": { "inherit": true }` alone inherits the brand only: the campaign is then the profile's own. Inheriting takes *all* of your organization's, because inheritance resolves an owner rather than a single row.
 *
 * A profile with a `brand` of its own **cannot** inherit the campaign, and asking is refused with `400`: a campaign is filed against a brand registration, and your organization's campaign is filed against your organization's brand rather than this profile's. Inherit both, own both, or inherit the brand and own the campaign.
 *
 * `channels.sms` is the market the profile starts in — one `country` and `number_type`. It decides what else this call asks for: the compliance catalog is keyed on that pair, and it determines which fields `brand` accepts and what `compliance` answers for.
 *
 * **Several numbers in that market**: `channels.sms.numbers` lists them, one entry per area code, e.g. `[{"area_code": "212", "quantity": 2}, {"quantity": 1}]` for two in 212 and one in any area code. `quantity` defaults to 1, an entry without `area_code` means any area code, and the total is at most 49. The market is created with **one campaign**, the one in `compliance.campaign`, and a US `TEN_DLC` market's numbers are stored on it and assigned when it is approved. A profile inheriting your organization's campaign keeps one number. Every number is listed in `channels.sms[].numbers` with its area code and status.
 *
 * A profile is a tenant, not a market, so it can go on to send in several — but through `POST /v3/channels/sms` with the `x-profile-id` header, one market and its compliance at a time. Reads return every market as `channels.sms[]`, so the read shape is a list even where this one is not.
 *
 * `brand` is required when `number_type` is `TEN_DLC` — inherited or its own. A 10DLC registration has nothing to attach to without one, and no later call can supply it, so omitting it is refused with `400` rather than reported as outstanding.
 *
 * ## Use cases and volume
 *
 * A TCR campaign declares one to five `use_cases`, each with its own `sample_messages` — TCR attributes samples to the use case they illustrate, so they travel together.
 *
 * How that set registers is derived from `volume` and never declared. Below the low-volume threshold the campaign registers as `LOW_VOLUME` with every entry as a sub-use-case; above it, one entry registers as that use case outright and several register as `MIXED` with sub-use-cases. `MIXED` and `LOW_VOLUME` are therefore refused as `use_case` values: they describe the shape of a set, which is ours to work out.
 *
 * **Leaving `volume` out is accepted and costs more.** An absent value registers the campaign at the standard tier, which carries the higher fee — so say so when a campaign is low volume. Sole proprietor brands are the exception: their fee is fixed by entity type, and volume only decides the use case.
 *
 * ## Compliance
 *
 * `brand` is captured identically in every country. Everything a specific market demands on top of it — including every field of the campaign — goes in `compliance`, as key/value entries whose keys depend on the sender's country and type. US `TEN_DLC` registers with The Campaign Registry and asks for a substantial set; an alphanumeric sender may pre-register with documents, or need nothing at all.
 *
 * You do not have to know any of it. Omit `compliance` and the response lists exactly what is outstanding, with types and accepted values — or call `GET /v3/compliance/requirements` first. Anything Sent supplies on your behalf is never asked for, and is rejected if sent.
 *
 * Requirements can be conditional, and the condition is published as `required_when` so you can render a form from it rather than discover the rule by being rejected. Every US `TEN_DLC` campaign field carries `compliance.inherit != true` — send `"inherit": true` and none of them is asked for or accepted, because the profile is running on your organization's campaign.
 *
 * ## Uploading documents
 *
 * Send `application/json` for everything except a market that pre-registers a sender with supporting documents. For those, send `multipart/form-data` instead: put this entire document — unchanged — in a single field named `profile`, and attach each file under a field named after the compliance key it satisfies. Individual form fields per property are not read; the payload is always the one `profile` field.
 *
 * A pre-registration market has no `brand` and no `campaign` — those are asked for only where a regime registers one — so its `compliance` carries nothing at all, and the documents are the request:
 *
 * ```bash
 * curl -X POST https://api.sent.dm/v3/sender-profiles \
 *   -H 'x-api-key: YOUR_SECRET_TOKEN' \
 *   -F 'profile={
 *         "name": "Example Retail",
 *         "short_name": "EXAMPLE",
 *         "channels": {
 *           "sms": {
 *             "country": "XK",
 *             "number_type": "ALPHANUMERIC",
 *             "sender_value": "EXAMPLE"
 *           }
 *         }
 *       }' \
 *   -F 'business_registration=@registration.pdf' \
 *   -F 'letter_of_authorization=@loa.pdf'
 * ```
 *
 * `business_registration` and `letter_of_authorization` are illustrative. The real field names are whatever that market configures, so read them from `GET /v3/compliance/requirements`, which lists documents separately from the values — under `attachments`, each with the `field_name` to put the file under.
 *
 * A document has no JSON form, so naming one in `compliance` is refused with `400` rather than ignored: accepting it would report the requirement as satisfied while no file was ever stored.
 *
 * ## WhatsApp and RCS
 *
 * Neither can be inherited, so neither takes an `inherit`: the profile's WhatsApp account and RCS agent are its own or it has none. Sharing your organization's would share its inbox and its throughput, which makes the two indistinguishable to a recipient.
 *
 * `channels.whatsapp` names one of the accounts shared into your organization, and takes the two identifiers nothing else can supply: `waba_id`, because your organization holds one account per client, and `phone_number_id`, because naming the account's number is what assigns it to the profile as the number it sends from.
 *
 * Everything else is resolved from your organization — the Multi-Partner Solution the account arrived through, the client business portfolio that owns it, the access token and that token's expiry. None of them is accepted here: the first two are Meta's answer about provenance, so a value you sent could assert a partnership Meta disagrees with, and the token is minted per client business and rotates roughly every sixty days.
 *
 * `phone_number_id` is optional. Omit it to connect the account now and settle the number later — the channel reads as `ACTION_NEEDED` with `reason_code` `CHANNEL_007`, and the profile's WhatsApp messages fail until a number is named. They do not fall back to your organization's account. `POST /v3/channels/whatsapp` connects an account to an existing profile and resolves the same fields the same way.
 *
 * An account of its own needs a sender of its own, so `channels.whatsapp` requires `channels.sms`. A profile sending SMS on your organization's sender shares that inbox and opt-out list, and is not a separate tenant to give an account to — asking is refused with `400`, before your organization is asked to resolve anything.
 *
 * `channels.rcs` records the RCS agent. RCS (Rich Communication Services) is the next-generation SMS standard built into Android — it lets you send branded messages with images, buttons and read receipts over the carrier network, with no app install required. Learn more in the [Google RCS documentation](https://developers.google.com/business-communications/rcs-business-messaging).
 *
 * All fields on the agent form are required except `opt_in_screenshot_url`. The full form must be submitted in one go so the carrier review has everything it needs. A carrier approval no API call can trigger is arranged offline, so the status reports `PROVISIONING` until it is.
 *
 * ## Responses
 *
 * `201` when the profile is complete on return — the fully-inherited case, where nothing needs registering. `202` when something is still provisioning, with per-capability status and outstanding requirements. `409` when the WhatsApp account supplied is already recorded. `400` covers a wrong value as well as a missing one: a missing brand under `TEN_DLC`, a brand or campaign inherited under `TEN_DLC` that your organization does not have yet, an unknown compliance key, a bad type, a sender id the market does not allow, a `waba_id` that is not one of the accounts shared into your organization, or a WhatsApp account Meta rejects. `502` when Meta could not be reached to verify the WhatsApp account; nothing was created, so retry.
 *
 * @see SentDm\Services\SenderProfilesService::create()
 *
 * @phpstan-import-type SenderProfileBillingRequestShape from \SentDm\SenderProfiles\SenderProfileBillingRequest
 * @phpstan-import-type SenderProfileChannelsShape from \SentDm\SenderProfiles\SenderProfileChannels
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 *
 * @phpstan-type SenderProfileCreateParamsShape = array{
 *   billing?: null|SenderProfileBillingRequest|SenderProfileBillingRequestShape,
 *   channels?: null|SenderProfileChannels|SenderProfileChannelsShape,
 *   compliance?: null|MarketCompliance|MarketComplianceShape,
 *   description?: string|null,
 *   name?: string|null,
 *   notifications?: string|null,
 *   sandbox?: bool|null,
 *   shortName?: string|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class SenderProfileCreateParams implements BaseModel
{
    /** @use SdkModel<SenderProfileCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Who pays for what a sender profile sends.
     *
     * Ownership reads the same way as BrandRequest and CampaignRequest:
     * inherit: true is the organization paying; inherit: false (or an empty block) is the
     * profile paying for itself.
     *
     * An absent block is the one place billing differs from brand and campaign: a profile still has to be
     * paid for, so omitting billing stores ProfileAndOrganizationBilling — the profile pays first
     * and its organization covers what the profile's balance cannot (see
     * ResolveStored). { "name": "..." } stays a complete request.
     *
     * Billing carries no fields of its own yet, so a profile paying for itself is
     * { "inherit": false } — or an empty block, which means the same. That is thinner than brand and
     * campaign, where supplying data is the act of owning; it becomes ordinary the moment billing gains a
     * contact or a payment method to carry.
     */
    #[Optional(nullable: true)]
    public ?SenderProfileBillingRequest $billing;

    /**
     * The channels the profile sends on. Each is independently the profile's own or absent — none can be
     * inherited, so none carries a mode and presence is the whole of the request.
     *
     * A profile can send SMS in several markets, but create takes one — the market it starts in.
     * Further markets are added through POST /v3/channels/sms with x-profile-id, and a read returns
     * them all as a list. Create stays singular permanently rather than being a list that accepts one entry:
     * the constraint is in the type, and there is no later widening to break the contract.
     */
    #[Optional(nullable: true)]
    public ?SenderProfileChannels $channels;

    /**
     * The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     */
    #[Optional]
    public ?MarketCompliance $compliance;

    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Display name for the profile. Required.
     */
    #[Optional]
    public ?string $name;

    /**
     * Who is notified about this profile's events: ORGANIZATION, SENDER_PROFILE, or
     * ORGANIZATION_AND_SENDER_PROFILE. Omitting it leaves the profile on the Organization default.
     */
    #[Optional(nullable: true)]
    public ?string $notifications;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * Short name, which is also the SMS sender id — required. 3–11 characters of letters, numbers and
     * spaces, with at least one letter.
     */
    #[Optional('short_name')]
    public ?string $shortName;

    #[Optional]
    public ?string $idempotencyKey;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param SenderProfileBillingRequest|SenderProfileBillingRequestShape|null $billing
     * @param SenderProfileChannels|SenderProfileChannelsShape|null $channels
     * @param MarketCompliance|MarketComplianceShape|null $compliance
     */
    public static function with(
        SenderProfileBillingRequest|array|null $billing = null,
        SenderProfileChannels|array|null $channels = null,
        MarketCompliance|array|null $compliance = null,
        ?string $description = null,
        ?string $name = null,
        ?string $notifications = null,
        ?bool $sandbox = null,
        ?string $shortName = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $billing && $self['billing'] = $billing;
        null !== $channels && $self['channels'] = $channels;
        null !== $compliance && $self['compliance'] = $compliance;
        null !== $description && $self['description'] = $description;
        null !== $name && $self['name'] = $name;
        null !== $notifications && $self['notifications'] = $notifications;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Who pays for what a sender profile sends.
     *
     * Ownership reads the same way as BrandRequest and CampaignRequest:
     * inherit: true is the organization paying; inherit: false (or an empty block) is the
     * profile paying for itself.
     *
     * An absent block is the one place billing differs from brand and campaign: a profile still has to be
     * paid for, so omitting billing stores ProfileAndOrganizationBilling — the profile pays first
     * and its organization covers what the profile's balance cannot (see
     * ResolveStored). { "name": "..." } stays a complete request.
     *
     * Billing carries no fields of its own yet, so a profile paying for itself is
     * { "inherit": false } — or an empty block, which means the same. That is thinner than brand and
     * campaign, where supplying data is the act of owning; it becomes ordinary the moment billing gains a
     * contact or a payment method to carry.
     *
     * @param SenderProfileBillingRequest|SenderProfileBillingRequestShape|null $billing
     */
    public function withBilling(
        SenderProfileBillingRequest|array|null $billing
    ): self {
        $self = clone $this;
        $self['billing'] = $billing;

        return $self;
    }

    /**
     * The channels the profile sends on. Each is independently the profile's own or absent — none can be
     * inherited, so none carries a mode and presence is the whole of the request.
     *
     * A profile can send SMS in several markets, but create takes one — the market it starts in.
     * Further markets are added through POST /v3/channels/sms with x-profile-id, and a read returns
     * them all as a list. Create stays singular permanently rather than being a list that accepts one entry:
     * the constraint is in the type, and there is no later widening to break the contract.
     *
     * @param SenderProfileChannels|SenderProfileChannelsShape|null $channels
     */
    public function withChannels(
        SenderProfileChannels|array|null $channels
    ): self {
        $self = clone $this;
        $self['channels'] = $channels;

        return $self;
    }

    /**
     * The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     *
     * @param MarketCompliance|MarketComplianceShape $compliance
     */
    public function withCompliance(MarketCompliance|array $compliance): self
    {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Display name for the profile. Required.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Who is notified about this profile's events: ORGANIZATION, SENDER_PROFILE, or
     * ORGANIZATION_AND_SENDER_PROFILE. Omitting it leaves the profile on the Organization default.
     */
    public function withNotifications(?string $notifications): self
    {
        $self = clone $this;
        $self['notifications'] = $notifications;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    /**
     * Short name, which is also the SMS sender id — required. 3–11 characters of letters, numbers and
     * spaces, with at least one letter.
     */
    public function withShortName(string $shortName): self
    {
        $self = clone $this;
        $self['shortName'] = $shortName;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
