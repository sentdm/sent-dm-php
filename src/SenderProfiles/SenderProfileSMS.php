<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Channels\SMS\SMSNumberRequest;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One SMS market a profile sends in — a country and a sender type.
 *
 * A profile may have several. It is a tenant, not a market: a business sending to two countries is
 * one customer of yours, and forcing it into two profiles would give it two API keys, two inboxes and two
 * contact lists for one business. The platform already assumes many —
 * CustomerChannelProviders is unique on (customer, channel, iso, number).
 *
 * No mode: a sender is the profile's own or it has none. Listing a market is the request
 * for one.
 *
 * Also the discriminator for everything else: the compliance catalog is keyed on (country, number
 * type), and that pair decides which fields brand accepts and what compliance is asked
 * for.
 *
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 *
 * @phpstan-type SenderProfileSMSShape = array{
 *   country: string,
 *   areaCodes?: list<string>|null,
 *   numberType?: string|null,
 *   numbers?: list<SMSNumberRequest|SMSNumberRequestShape>|null,
 *   senderValue?: string|null,
 * }
 */
final class SenderProfileSMS implements BaseModel
{
    /** @use SdkModel<SenderProfileSMSShape> */
    use SdkModel;

    /**
     * ISO 3166-1 alpha-2 country the sender operates in, e.g. US.
     */
    #[Required]
    public string $country;

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
     * Sender type: LOCAL, MOBILE, TEN_DLC, TOLL_FREE, SHORT_CODE or
     * ALPHANUMERIC. 10DLC is accepted as a synonym of TEN_DLC. Availability varies
     * by country.
     */
    #[Optional('number_type', nullable: true)]
    public ?string $numberType;

    /**
     * The numbers to assign, one entry per area code, e.g.
     * [{"area_code": "212", "quantity": 2}, {"area_code": "415"}, {"quantity": 1}]: two numbers in 212,
     * one in 415 and one in any area code. quantity defaults to 1, and an entry without
     * area_code means any area code. Omit numbers for one number.
     *
     * Only with LOCAL or TEN_DLC, and not together with area_codes. Each area code is
     * validated against country the same way area_codes is and may appear once, and at most one
     * entry may leave area_code out. US TEN_DLC numbers are assigned when the campaign is
     * approved, not at request time. Not available when the profile inherits the organization's
     * campaign.
     *
     * @var list<SMSNumberRequest>|null $numbers
     */
    #[Optional(list: SMSNumberRequest::class, nullable: true)]
    public ?array $numbers;

    /**
     * The sender's identity, where the caller chooses it rather than the carrier assigning it. Required
     * when number_type is ALPHANUMERIC; omit for carrier-assigned types and one is
     * provisioned.
     */
    #[Optional('sender_value', nullable: true)]
    public ?string $senderValue;

    /**
     * `new SenderProfileSMS()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SenderProfileSMS::with(country: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderProfileSMS)->withCountry(...)
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
     * @param list<string>|null $areaCodes
     * @param list<SMSNumberRequest|SMSNumberRequestShape>|null $numbers
     */
    public static function with(
        string $country,
        ?array $areaCodes = null,
        ?string $numberType = null,
        ?array $numbers = null,
        ?string $senderValue = null,
    ): self {
        $self = new self;

        $self['country'] = $country;

        null !== $areaCodes && $self['areaCodes'] = $areaCodes;
        null !== $numberType && $self['numberType'] = $numberType;
        null !== $numbers && $self['numbers'] = $numbers;
        null !== $senderValue && $self['senderValue'] = $senderValue;

        return $self;
    }

    /**
     * ISO 3166-1 alpha-2 country the sender operates in, e.g. US.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

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
     * Sender type: LOCAL, MOBILE, TEN_DLC, TOLL_FREE, SHORT_CODE or
     * ALPHANUMERIC. 10DLC is accepted as a synonym of TEN_DLC. Availability varies
     * by country.
     */
    public function withNumberType(?string $numberType): self
    {
        $self = clone $this;
        $self['numberType'] = $numberType;

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
     * entry may leave area_code out. US TEN_DLC numbers are assigned when the campaign is
     * approved, not at request time. Not available when the profile inherits the organization's
     * campaign.
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
     * The sender's identity, where the caller chooses it rather than the carrier assigning it. Required
     * when number_type is ALPHANUMERIC; omit for carrier-assigned types and one is
     * provisioned.
     */
    public function withSenderValue(?string $senderValue): self
    {
        $self = clone $this;
        $self['senderValue'] = $senderValue;

        return $self;
    }
}
