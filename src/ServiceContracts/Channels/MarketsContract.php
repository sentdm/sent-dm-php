<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels;

use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\Markets\APIResponseOfListOfChannelMarket;
use SentDm\Channels\Markets\APIResponseOfMarketNumbers;
use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Channels\SMS\SMSNumberRequest;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 */
interface MarketsContract
{
    /**
     * @api
     *
     * @param string $type Path param: Sender type: local, mobile, 10dlc (or ten_dlc), toll_free, short_code, alphanumeric. Matched ignoring case.
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until they have markets
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. us
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $type,
        string $channel,
        string $country,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket;

    /**
     * @api
     *
     * @param string $type Path param: Sender type, e.g. 10dlc (or ten_dlc), local or alphanumeric. Only 10dlc in us declares a brand.
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until they have markets
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
        string $channel,
        string $country,
        MarketCompliance|array|null $compliance = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket;

    /**
     * @api
     *
     * @param string $channel The channel: `sms`. Other channels are `501` until they have markets
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $channel,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfListOfChannelMarket;

    /**
     * @api
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`) or `local`
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until their numbers are available
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. `US`
     * @param list<SMSNumberRequest|SMSNumberRequestShape|null> $numbers Body param: The numbers, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * POST adds them to what the market or campaign already asks for; PATCH replaces that list
     * with them, and has to cover every number already held, since none is ever released.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string|null $campaignID Body param: The campaign to add the numbers to, as campaigns[].id reports it. Required on SMS US TEN_DLC,
     * where every number belongs to a campaign; refused on a market without campaigns.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function addNumbers(
        string $type,
        string $channel,
        string $country,
        array $numbers,
        string $idempotencyKey,
        ?string $campaignID = null,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket;

    /**
     * @api
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`), `local`, `mobile`, `toll_free`, `short_code`, `alphanumeric`
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until their numbers are available
     * @param string $country Path param: ISO 3166-1 country code, e.g. `US`
     * @param string|null $campaignID query param: Only the numbers of this campaign (US TEN_DLC); all of the market's when absent
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listNumbers(
        string $type,
        string $channel,
        string $country,
        ?string $campaignID = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfMarketNumbers;

    /**
     * @api
     *
     * @param string $type Path param: Sender type: `ten_dlc` (or `10dlc`) or `local`
     * @param string $channel Path param: The channel: `sms`. Other channels are `501` until their numbers are available
     * @param string $country Path param: ISO 3166-1 alpha-2 country code, e.g. `US`
     * @param list<SMSNumberRequest|SMSNumberRequestShape|null> $numbers Body param: The numbers, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * POST adds them to what the market or campaign already asks for; PATCH replaces that list
     * with them, and has to cover every number already held, since none is ever released.
     * @param string|null $campaignID Body param: The campaign to add the numbers to, as campaigns[].id reports it. Required on SMS US TEN_DLC,
     * where every number belongs to a campaign; refused on a market without campaigns.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function replaceNumbers(
        string $type,
        string $channel,
        string $country,
        array $numbers,
        ?string $campaignID = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket;
}
