<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels\SMS;

use SentDm\Channels\SMS\APIResponseOfSMSMarket;
use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Channels\SMS\SMSNumberRequest;
use SentDm\Channels\SMS\TenDlc\APIResponseOfSuppliedCompliance;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface TenDlcContract
{
    /**
     * @api
     *
     * @param MarketCompliance|MarketComplianceShape $compliance Body param: The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     * @param bool $sandbox Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function addCampaign(
        MarketCompliance|array|null $compliance = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfSMSMarket;

    /**
     * @api
     *
     * @param string $campaignID Body param: The campaign to add the numbers to, as compliance.campaigns[].id reports it. Required.
     * @param list<SMSNumberRequest|SMSNumberRequestShape|null> $numbers Body param: The numbers to add, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * Added to what the campaign already asks for, never replacing it.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function addNumbers(
        string $campaignID,
        array $numbers,
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
    public function retrieveCompliance(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfSuppliedCompliance;

    /**
     * @api
     *
     * @param string $campaignID Path param: The campaign: its id in the market's compliance.campaigns.
     * @param MarketCompliance|MarketComplianceShape $compliance Body param: The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     * @param bool $sandbox Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateCampaign(
        string $campaignID,
        MarketCompliance|array|null $compliance = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfSMSMarket;
}
