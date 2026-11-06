<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Channels\SMS\SMSCreateParams\NumberType;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Gives the customer a sender in one country — the first market it sends in, and the fifth.
 *
 * ## What to have in place first
 *
 * **Call `GET /v3/compliance/requirements?country=US&type=TEN_DLC` first.** It returns this request's body ready to fill in, plus the brand and campaign calls to make before it, in order. You never have to track forty countries' rules yourself.
 *
 * **A market that registers with a compliance regime needs an identity, and this call takes one.** US `TEN_DLC` registers with The Campaign Registry and files that registration against a business identity. Send it in `compliance.brand` and it is recorded here, before the registration that attaches to it — so a customer with no identity reaches a first 10DLC market in one call.
 *
 * `{ "inherit": true }` runs on your organization's instead. A market with neither — none stored, none sent — is `400`, because accepting it would write a channel that could never register and leave it provisioning for ever with nothing saying why.
 *
 * **Everything the regime wants arrives in this request's `compliance`**, as two declared objects: `brand` — the identity the registration is filed against — and `campaign`, with the use case, the consent narrative, the volume, the sample messages and the keywords. There is nothing to set up first. Nothing is submitted here either: the rows are what a submission is later assembled from, and filing is externally rejectable so it happens on its own path.
 *
 * **A half you run yourself has to be complete here.** Whichever of `brand` and `campaign` is your own rather than your organization's must carry every field the regime asks of it, counting what you already hold — send the rest in this request. A missing one is `400` naming each field, rather than a `202` for a market that could never be filed. A half you inherit is asked for nothing.
 *
 * A market that registers with nobody — an alphanumeric sender in most countries — needs neither, and may need documents instead.
 *
 * ## Sending it
 *
 * Takes the same fields `channels.sms` takes on `POST /v3/sender-profiles`, because it is the same work, and both run one provisioning path. `compliance` is top-level and answers for the market in this request, carrying `brand` and `campaign` where the market registers.
 *
 * **Accepts multipart as well as JSON**, with each file named after the compliance key it satisfies — a market that pre-registers its sender needs its documents at the same moment it needs the sender. Every required document must be attached to this request; a missing or invalid file is rejected before the market is added.
 *
 * **`area_codes` puts the sender somewhere specific**, in your order of preference, for a `LOCAL` sender in any country or a US `TEN_DLC` sender — a 10DLC number is an ordinary local long code bound to a registered campaign, so both take the same codes out of the same inventory. It is honoured exactly: you get a number in one of the codes you named or you get none, never one in a code you left out.
 *
 * ## Several numbers
 *
 * **`numbers` lists the numbers you want, one entry per area code**, e.g. `[{"area_code": "212", "quantity": 2}, {"quantity": 1}]` for two numbers in 212 and one in any area code. `quantity` defaults to 1, and an entry without `area_code` means any area code. Omit `numbers` for one number. It is for `LOCAL` and `TEN_DLC` only and cannot be combined with `area_codes`. A market holds at most 49 numbers, counting the ones it already has.
 *
 * **On a `LOCAL` market you already hold, `numbers` adds those numbers to it** instead of `409`. US `TEN_DLC` numbers belong to the market's campaign and are assigned when the campaign is approved, not at request time. Until then they read as `PROVISIONING` in the response's `numbers`, each with the area code it was asked for. A profile inheriting your organization's campaign cannot request `numbers` (`400`). `numbers` on a `TEN_DLC` market you already hold is `409`: its numbers belong to its one campaign and are set when the market is created.
 *
 * **A market you already send in is `409`**: adding what is already there is a mistake worth reporting rather than a silent no-op. A market is a `(country, sender_type)` pair, so a **second sender type in a country you already send in is fine** — `US TOLL_FREE` alongside `US TEN_DLC` is the ordinary case. Two of the same type is not.
 *
 * **A market you hold that has no sender yet is not a duplicate**, and re-sending it re-asks for a sender rather than being refused. That is the way out of an area-code request nothing could fill: send the call again to name different codes, or no codes at all to take a number anywhere in the country. It answers `201` with the sender when the pool has one, otherwise `202` with the codes recorded — and changes nothing else; compliance on a market you hold is `PATCH /v3/channels/sms/{country}/{type}`.
 *
 * One exception: while a market's sender type is still unassigned, adding any type to that country is `409` once it has a sender, because the market you have may be about to become the one you asked for.
 *
 * Returns **the market**, in the shape `GET` and `PATCH` on `/v3/channels/sms/{country}/{type}` use — so what this answers can be read back and written back without reshaping. Not every channel you have: adding a market cannot change an RCS agent or a WhatsApp account, and `GET /v3/channels` is the whole picture. `201` when the market is ready; `202` while a sender or a registration is still outstanding.
 *
 * Send `x-profile-id` with an organization key to add a market to one of your profiles.
 *
 * @see SentDm\Services\Channels\SMSService::create()
 *
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 *
 * @phpstan-type SMSCreateParamsShape = array{
 *   numberType: NumberType|value-of<NumberType>,
 *   areaCodes?: list<string>|null,
 *   compliance?: null|MarketCompliance|MarketComplianceShape,
 *   country?: string|null,
 *   numbers?: list<SMSNumberRequest|SMSNumberRequestShape>|null,
 *   sandbox?: bool|null,
 *   senderValue?: string|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class SMSCreateParams implements BaseModel
{
    /** @use SdkModel<SMSCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Sender type. Decides the provisioning flow and what compliance is asked for.
     *
     * [Required] so the published document says so. The validator has always demanded it, but
     * requiredness reached the schema by matching a rule to a property name — which works for country,
     * whose wire name is its camel-cased C# name, and silently does not for number_type. A client
     * generating a request from our OpenAPI therefore sent what the document called sufficient and was
     * answered 400.
     *
     * @var value-of<NumberType> $numberType
     */
    #[Required('number_type', enum: NumberType::class)]
    public string $numberType;

    /**
     * The area codes to put this sender in, in your own order of preference, e.g. ["415", "628"]
     * for the US or ["20"] for London. Omit it and a number is claimed anywhere in the country.
     *
     * Ordered, and the order is the request. The claim tries each code in turn and stops at the
     * first that yields a number. Nothing sorts the list and a code listed twice is refused.
     *
     * One to fifty entries, each the area code as digits: 415, with the trunk prefix as
     * 020, or with the country's dialing prefix as +1415 (all are stored as the bare code). A
     * dialing prefix from a different country than country is refused. Each code is checked against
     * the country's numbering plan: it must start real local or mobile numbers there, so toll-free and
     * premium ranges, service codes and another country's codes are refused with a reason.
     *
     * LOCAL senders in any country, and US TEN_DLC senders. No other sender type
     * has a geographic area code, and the list is refused with one rather than accepted and dropped.
     *
     * Honoured exactly or not at all. Ask for 415 and you get a 415 number or you
     * get none, never a neighbouring code you did not name. A miss leaves the market with no sender yet and
     * the codes recorded on it, so it is filled when stock appears rather than filled now from somewhere else.
     * Many countries outside North America require address or business documents before a local number can
     * be bought, which can delay or prevent the fill.
     *
     * @var list<string>|null $areaCodes
     */
    #[Optional('area_codes', list: 'string', nullable: true)]
    public ?array $areaCodes;

    /**
     * The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     */
    #[Optional]
    public ?MarketCompliance $compliance;

    /**
     * ISO 3166-1 alpha-2 country the sender operates in.
     */
    #[Optional]
    public ?string $country;

    /**
     * The numbers to assign, one entry per area code, e.g.
     * [{"area_code": "212", "quantity": 2}, {"area_code": "415"}, {"quantity": 1}]: two numbers in 212,
     * one in 415 and one in any area code. quantity defaults to 1, and an entry without
     * area_code means any area code. Omit numbers for one number.
     *
     * Only with LOCAL or TEN_DLC, and not together with area_codes. Each area code is
     * validated against country the same way area_codes is and may appear once, and at most one
     * entry may leave area_code out. On a LOCAL market you already hold, this adds the numbers to
     * it. US TEN_DLC numbers are assigned when the campaign is approved, not at request time. Not
     * available when the profile inherits the organization's campaign.
     *
     * @var list<SMSNumberRequest>|null $numbers
     */
    #[Optional(list: SMSNumberRequest::class, nullable: true)]
    public ?array $numbers;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * The sender's identity where the caller chooses it. Required when number_type is
     * ALPHANUMERIC; optional for carrier-assigned types, which are procured afterwards.
     */
    #[Optional('sender_value', nullable: true)]
    public ?string $senderValue;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new SMSCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SMSCreateParams::with(numberType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SMSCreateParams)->withNumberType(...)
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
     * @param NumberType|value-of<NumberType> $numberType
     * @param list<string>|null $areaCodes
     * @param MarketCompliance|MarketComplianceShape|null $compliance
     * @param list<SMSNumberRequest|SMSNumberRequestShape>|null $numbers
     */
    public static function with(
        NumberType|string $numberType,
        ?array $areaCodes = null,
        MarketCompliance|array|null $compliance = null,
        ?string $country = null,
        ?array $numbers = null,
        ?bool $sandbox = null,
        ?string $senderValue = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['numberType'] = $numberType;

        null !== $areaCodes && $self['areaCodes'] = $areaCodes;
        null !== $compliance && $self['compliance'] = $compliance;
        null !== $country && $self['country'] = $country;
        null !== $numbers && $self['numbers'] = $numbers;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $senderValue && $self['senderValue'] = $senderValue;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Sender type. Decides the provisioning flow and what compliance is asked for.
     *
     * [Required] so the published document says so. The validator has always demanded it, but
     * requiredness reached the schema by matching a rule to a property name — which works for country,
     * whose wire name is its camel-cased C# name, and silently does not for number_type. A client
     * generating a request from our OpenAPI therefore sent what the document called sufficient and was
     * answered 400.
     *
     * @param NumberType|value-of<NumberType> $numberType
     */
    public function withNumberType(NumberType|string $numberType): self
    {
        $self = clone $this;
        $self['numberType'] = $numberType;

        return $self;
    }

    /**
     * The area codes to put this sender in, in your own order of preference, e.g. ["415", "628"]
     * for the US or ["20"] for London. Omit it and a number is claimed anywhere in the country.
     *
     * Ordered, and the order is the request. The claim tries each code in turn and stops at the
     * first that yields a number. Nothing sorts the list and a code listed twice is refused.
     *
     * One to fifty entries, each the area code as digits: 415, with the trunk prefix as
     * 020, or with the country's dialing prefix as +1415 (all are stored as the bare code). A
     * dialing prefix from a different country than country is refused. Each code is checked against
     * the country's numbering plan: it must start real local or mobile numbers there, so toll-free and
     * premium ranges, service codes and another country's codes are refused with a reason.
     *
     * LOCAL senders in any country, and US TEN_DLC senders. No other sender type
     * has a geographic area code, and the list is refused with one rather than accepted and dropped.
     *
     * Honoured exactly or not at all. Ask for 415 and you get a 415 number or you
     * get none, never a neighbouring code you did not name. A miss leaves the market with no sender yet and
     * the codes recorded on it, so it is filled when stock appears rather than filled now from somewhere else.
     * Many countries outside North America require address or business documents before a local number can
     * be bought, which can delay or prevent the fill.
     *
     * @param list<string>|null $areaCodes
     */
    public function withAreaCodes(?array $areaCodes): self
    {
        $self = clone $this;
        $self['areaCodes'] = $areaCodes;

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

    /**
     * ISO 3166-1 alpha-2 country the sender operates in.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * The numbers to assign, one entry per area code, e.g.
     * [{"area_code": "212", "quantity": 2}, {"area_code": "415"}, {"quantity": 1}]: two numbers in 212,
     * one in 415 and one in any area code. quantity defaults to 1, and an entry without
     * area_code means any area code. Omit numbers for one number.
     *
     * Only with LOCAL or TEN_DLC, and not together with area_codes. Each area code is
     * validated against country the same way area_codes is and may appear once, and at most one
     * entry may leave area_code out. On a LOCAL market you already hold, this adds the numbers to
     * it. US TEN_DLC numbers are assigned when the campaign is approved, not at request time. Not
     * available when the profile inherits the organization's campaign.
     *
     * @param list<SMSNumberRequest|SMSNumberRequestShape>|null $numbers
     */
    public function withNumbers(?array $numbers): self
    {
        $self = clone $this;
        $self['numbers'] = $numbers;

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
     * The sender's identity where the caller chooses it. Required when number_type is
     * ALPHANUMERIC; optional for carrier-assigned types, which are procured afterwards.
     */
    public function withSenderValue(?string $senderValue): self
    {
        $self = clone $this;
        $self['senderValue'] = $senderValue;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
