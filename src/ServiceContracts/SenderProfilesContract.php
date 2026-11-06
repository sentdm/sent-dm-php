<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts;

use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;
use SentDm\SenderProfiles\APIResponseOfSenderProfile;
use SentDm\SenderProfiles\SenderProfile;
use SentDm\SenderProfiles\SenderProfileBillingRequest;
use SentDm\SenderProfiles\SenderProfileChannels;
use SentDm\SenderProfilesPage;

/**
 * @phpstan-import-type SenderProfileBillingRequestShape from \SentDm\SenderProfiles\SenderProfileBillingRequest
 * @phpstan-import-type SenderProfileChannelsShape from \SentDm\SenderProfiles\SenderProfileChannels
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface SenderProfilesContract
{
    /**
     * @api
     *
     * @param SenderProfileBillingRequest|SenderProfileBillingRequestShape|null $billing Body param: Who pays for what a sender profile sends.
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
     * @param SenderProfileChannels|SenderProfileChannelsShape|null $channels Body param: The channels the profile sends on. Each is independently the profile's own or absent — none can be
     * inherited, so none carries a mode and presence is the whole of the request.
     *
     * A profile can send SMS in several markets, but create takes one — the market it starts in.
     * Further markets are added through POST /v3/channels/sms with x-profile-id, and a read returns
     * them all as a list. Create stays singular permanently rather than being a list that accepts one entry:
     * the constraint is in the type, and there is no later widening to break the contract.
     * @param MarketCompliance|MarketComplianceShape $compliance Body param: The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     * @param string|null $description Body param
     * @param string $name Body param: Display name for the profile. Required.
     * @param string|null $notifications Body param: Who is notified about this profile's events: ORGANIZATION, SENDER_PROFILE, or
     * ORGANIZATION_AND_SENDER_PROFILE. Omitting it leaves the profile on the Organization default.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $shortName Body param: Short name, which is also the SMS sender id — required. 3–11 characters of letters, numbers and
     * spaces, with at least one letter.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        SenderProfileBillingRequest|array|null $billing = null,
        SenderProfileChannels|array|null $channels = null,
        MarketCompliance|array|null $compliance = null,
        ?string $description = null,
        ?string $name = null,
        ?string $notifications = null,
        ?bool $sandbox = null,
        ?string $shortName = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfSenderProfile;

    /**
     * @api
     *
     * @param string $id identifier of the profile, as returned by POST /v3/sender-profiles
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): APIResponseOfSenderProfile;

    /**
     * @api
     *
     * @param string $id Path param
     * @param string|null $description Body param
     * @param string $name Body param
     * @param string|null $notifications Body param: Who is notified about this profile's events: ORGANIZATION, SENDER_PROFILE, or
     * ORGANIZATION_AND_SENDER_PROFILE. Cannot be cleared — a supplied value must be one of those.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string|null $shortName Body param
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?string $description = null,
        ?string $name = null,
        ?string $notifications = null,
        ?bool $sandbox = null,
        ?string $shortName = null,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfSenderProfile;

    /**
     * @api
     *
     * @param int $page page number, 1-indexed
     * @param int $pageSize Profiles per page. Between 1 and 100.
     * @param RequestOpts|null $requestOptions
     *
     * @return SenderProfilesPage<SenderProfile>
     *
     * @throws APIException
     */
    public function list(
        ?int $page = null,
        ?int $pageSize = null,
        RequestOptions|array|null $requestOptions = null,
    ): SenderProfilesPage;

    /**
     * @api
     *
     * @param string $id identifier of the profile
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
