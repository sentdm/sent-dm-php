<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\SMS\APIResponseOfListOfSMSMarket;
use SentDm\Channels\SMS\APIResponseOfSMSMarket;
use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Channels\SMS\SMSCreateParams\NumberType;
use SentDm\Channels\SMS\SMSNumberRequest;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface SMSContract
{
    /**
     * @api
     *
     * @param NumberType|value-of<NumberType> $numberType Body param: Sender type. Decides the provisioning flow and what compliance is asked for.
     *
     * [Required] so the published document says so. The validator has always demanded it, but
     * requiredness reached the schema by matching a rule to a property name — which works for country,
     * whose wire name is its camel-cased C# name, and silently does not for number_type. A client
     * generating a request from our OpenAPI therefore sent what the document called sufficient and was
     * answered 400.
     * @param list<string>|null $areaCodes Body param: The area codes to put this sender in, in your own order of preference, e.g. ["415", "628"]
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
     * @param MarketCompliance|MarketComplianceShape $compliance Body param: The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     * @param string $country body param: ISO 3166-1 alpha-2 country the sender operates in
     * @param list<SMSNumberRequest|SMSNumberRequestShape>|null $numbers Body param: The numbers to assign, one entry per area code, e.g.
     * [{"area_code": "212", "quantity": 2}, {"area_code": "415"}, {"quantity": 1}]: two numbers in 212,
     * one in 415 and one in any area code. quantity defaults to 1, and an entry without
     * area_code means any area code. Omit numbers for one number.
     *
     * Only with LOCAL or TEN_DLC, and not together with area_codes. Each area code is
     * validated against country the same way area_codes is and may appear once, and at most one
     * entry may leave area_code out. On a LOCAL market you already hold, this adds the numbers to
     * it. US TEN_DLC numbers are assigned when the campaign is approved, not at request time. Not
     * available when the profile inherits the organization's campaign.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $senderValue Body param: The sender's identity where the caller chooses it. Required when number_type is
     * ALPHANUMERIC; optional for carrier-assigned types, which are procured afterwards.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        NumberType|string $numberType,
        ?array $areaCodes = null,
        MarketCompliance|array|null $compliance = null,
        ?string $country = null,
        ?array $numbers = null,
        ?bool $sandbox = null,
        ?string $senderValue = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfSMSMarket;

    /**
     * @api
     *
     * @param string $type Path param: Sender type: local, mobile, 10dlc (or ten_dlc), toll_free, short_code, alphanumeric. Matched ignoring case.
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. us
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $type,
        string $country,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfSMSMarket;

    /**
     * @api
     *
     * @param string $type Path param: Sender type, e.g. 10dlc (or ten_dlc), local or alphanumeric. Only 10dlc in us declares compliance values.
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. us
     * @param MarketCompliance|MarketComplianceShape $compliance Body param: The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     * @param bool $sandbox Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $type,
        string $country,
        MarketCompliance|array|null $compliance = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfSMSMarket;

    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfListOfSMSMarket;
}
