<?php

declare(strict_types=1);

namespace SentDm\ServiceContracts\Channels\SMS;

use SentDm\Channels\Markets\APIResponseOfChannelMarket;
use SentDm\Channels\SMS\TenDlc\TenDlcCampaignUseCase;
use SentDm\Channels\SMS\TenDlc\TenDlcListCampaignsResponse;
use SentDm\Core\Exceptions\APIException;
use SentDm\RequestOptions;

/**
 * @phpstan-import-type TenDlcCampaignUseCaseShape from \SentDm\Channels\SMS\TenDlc\TenDlcCampaignUseCase
 * @phpstan-import-type RequestOpts from \SentDm\RequestOptions
 */
interface TenDlcContract
{
    /**
     * @api
     *
     * @param string $description Body param: What this programme sends. TCR description: what recipients will get and why, in a sentence. The only one of these TCR takes verbatim as a description of the programme, which is why it is asked for rather than derived from the customer's name. Required when `compliance.campaign.inherit != true`.
     * @param string $helpKeywords Body param: Help keywords. TCR helpKeywords, comma separated, e.g. HELP,INFO. Required when `compliance.campaign.inherit != true`.
     * @param string $helpMessage Body param: Help reply. TCR helpMessage. Its presence is what sets subscriberHelp. Required when `compliance.campaign.inherit != true`.
     * @param string $messageFlow Body param: Consent narrative. TCR messageFlow: how recipients opt in, in prose. Under 40 characters is refused, and carriers reject vague descriptions — say where opt-in happens, that the box is unchecked by default, and that consent is not a condition of purchase. Required when `compliance.campaign.inherit != true`.
     * @param string $optInKeywords Body param: Opt-in keywords. TCR optinKeywords, comma separated, e.g. START,YES. Required when `compliance.campaign.inherit != true`.
     * @param string $optInMessage Body param: Opt-in confirmation. TCR optinMessage. Should state message frequency and that rates may apply. Its presence is what sets subscriberOptin. Required when `compliance.campaign.inherit != true`.
     * @param string $optOutKeywords Body param: Opt-out keywords. TCR optoutKeywords, comma separated. STOP, END, CANCEL, UNSUBSCRIBE and QUIT are honoured regardless of what is declared. Required when `compliance.campaign.inherit != true`.
     * @param string $optOutMessage Body param: Opt-out confirmation. TCR optoutMessage. Its presence is what sets subscriberOptout. Required when `compliance.campaign.inherit != true`.
     * @param string $privacyPolicyLink Body param: Privacy policy URL. TCR privacyPolicyLink. Required when `compliance.campaign.inherit != true`.
     * @param string $termsAndConditionsLink Body param: Terms and conditions URL. TCR termsAndConditionsLink. Required when `compliance.campaign.inherit != true`.
     * @param list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape> $useCases Body param: Use cases. What the campaign sends, and an example of each. One to five entries; how they register is decided by volume, never declared. Required when `compliance.campaign.inherit != true`.
     * @param string $volume Body param: Expected monthly volume. Required whenever the campaign's fields are written. A whole number of messages, e.g. 1000 or 10000. Decides how the campaign registers and which fee tier applies: below the low-volume threshold it registers as LOW_VOLUME with sub-use-cases, above it as a single use case or MIXED. Omitting it registers the campaign at the higher-fee standard tier. Required when `compliance.campaign.inherit != true`, whenever its block is written.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function addCampaign(
        string $description,
        string $helpKeywords,
        string $helpMessage,
        string $messageFlow,
        string $optInKeywords,
        string $optInMessage,
        string $optOutKeywords,
        string $optOutMessage,
        string $privacyPolicyLink,
        string $termsAndConditionsLink,
        array $useCases,
        string $volume,
        string $idempotencyKey,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket;

    /**
     * @api
     *
     * @param string $xProfileID Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listCampaigns(
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): TenDlcListCampaignsResponse;

    /**
     * @api
     *
     * @param string $campaignID Path param: The campaign: its id in the market's compliance.campaigns.
     * @param string $description Body param: What this programme sends. TCR description: what recipients will get and why, in a sentence. The only one of these TCR takes verbatim as a description of the programme, which is why it is asked for rather than derived from the customer's name. Required when `compliance.campaign.inherit != true`.
     * @param string $helpKeywords Body param: Help keywords. TCR helpKeywords, comma separated, e.g. HELP,INFO. Required when `compliance.campaign.inherit != true`.
     * @param string $helpMessage Body param: Help reply. TCR helpMessage. Its presence is what sets subscriberHelp. Required when `compliance.campaign.inherit != true`.
     * @param string $messageFlow Body param: Consent narrative. TCR messageFlow: how recipients opt in, in prose. Under 40 characters is refused, and carriers reject vague descriptions — say where opt-in happens, that the box is unchecked by default, and that consent is not a condition of purchase. Required when `compliance.campaign.inherit != true`.
     * @param string $optInKeywords Body param: Opt-in keywords. TCR optinKeywords, comma separated, e.g. START,YES. Required when `compliance.campaign.inherit != true`.
     * @param string $optInMessage Body param: Opt-in confirmation. TCR optinMessage. Should state message frequency and that rates may apply. Its presence is what sets subscriberOptin. Required when `compliance.campaign.inherit != true`.
     * @param string $optOutKeywords Body param: Opt-out keywords. TCR optoutKeywords, comma separated. STOP, END, CANCEL, UNSUBSCRIBE and QUIT are honoured regardless of what is declared. Required when `compliance.campaign.inherit != true`.
     * @param string $optOutMessage Body param: Opt-out confirmation. TCR optoutMessage. Its presence is what sets subscriberOptout. Required when `compliance.campaign.inherit != true`.
     * @param string $privacyPolicyLink Body param: Privacy policy URL. TCR privacyPolicyLink. Required when `compliance.campaign.inherit != true`.
     * @param bool $sandbox Body param: Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution
     * @param string $termsAndConditionsLink Body param: Terms and conditions URL. TCR termsAndConditionsLink. Required when `compliance.campaign.inherit != true`.
     * @param list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape> $useCases Body param: Use cases. What the campaign sends, and an example of each. One to five entries; how they register is decided by volume, never declared. Required when `compliance.campaign.inherit != true`.
     * @param string $volume Body param: Expected monthly volume. Required whenever the campaign's fields are written. A whole number of messages, e.g. 1000 or 10000. Decides how the campaign registers and which fee tier applies: below the low-volume threshold it registers as LOW_VOLUME with sub-use-cases, above it as a single use case or MIXED. Omitting it registers the campaign at the higher-fee standard tier. Required when `compliance.campaign.inherit != true`, whenever its block is written.
     * @param string $idempotencyKey Header param: Unique key to ensure idempotent request processing. Must be 1-255 alphanumeric characters, hyphens, or underscores. Responses are cached for 24 hours per key per customer.
     * @param string $xProfileID Header param: Profile UUID to scope the request to a child profile. Only organization API keys can use this header. The profile must belong to the calling organization.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateCampaign(
        string $campaignID,
        ?string $description = null,
        ?string $helpKeywords = null,
        ?string $helpMessage = null,
        ?string $messageFlow = null,
        ?string $optInKeywords = null,
        ?string $optInMessage = null,
        ?string $optOutKeywords = null,
        ?string $optOutMessage = null,
        ?string $privacyPolicyLink = null,
        ?bool $sandbox = null,
        ?string $termsAndConditionsLink = null,
        ?array $useCases = null,
        ?string $volume = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIResponseOfChannelMarket;
}
