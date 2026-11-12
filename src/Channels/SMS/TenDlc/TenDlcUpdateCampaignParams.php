<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc;

use SentDm\Channels\SMS\TenDlc\TenDlcUpdateCampaignParams\UseCase1 as UseCase;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Changes **one campaign of your own** on the US `TEN_DLC` market, named by its `id` in the market's `compliance.campaigns`.
 *
 * ## What to send
 *
 * The fields to change, at the top level of the body, under the `compliance.campaign.*` keys `GET /v3/compliance/requirements?country=US&type=TEN_DLC` lists, without that prefix. A field you leave out keeps its value, and a rejected one is keyed by its name. `id` and `"inherit": false` are ignored, so an entry of `compliance.campaigns` can be sent as read; `"inherit": true` is `400`, because this call changes a campaign's fields, not whose campaign you run on. The campaign only: add numbers with `POST /v3/channels/sms/numbers/US/TEN_DLC`, and change the brand or documents with `PATCH /v3/channels/sms/US/TEN_DLC`.
 *
 * ## When it can be changed
 *
 * Until it is filed with The Campaign Registry, and again when we ask you to correct it. That correction sends it back for review. A filed campaign is otherwise `409`, and so is a change between low and high volume once it is registered. A campaign you run on from your organization is `409` too: it is the organization's to change. So is one out of service: expired, deactivated or released.
 *
 * Returns **the market**, in the shape `GET /v3/channels/sms/US/TEN_DLC` returns.
 *
 * @see SentDm\Services\Channels\SMS\TenDlcService::updateCampaign()
 *
 * @phpstan-import-type UseCase1Shape from \SentDm\Channels\SMS\TenDlc\TenDlcUpdateCampaignParams\UseCase1
 *
 * @phpstan-type TenDlcUpdateCampaignParamsShape = array{
 *   description?: string|null,
 *   helpKeywords?: string|null,
 *   helpMessage?: string|null,
 *   messageFlow?: string|null,
 *   optInKeywords?: string|null,
 *   optInMessage?: string|null,
 *   optOutKeywords?: string|null,
 *   optOutMessage?: string|null,
 *   privacyPolicyLink?: string|null,
 *   sandbox?: bool|null,
 *   termsAndConditionsLink?: string|null,
 *   useCases?: list<UseCase|UseCase1Shape>|null,
 *   volume?: string|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class TenDlcUpdateCampaignParams implements BaseModel
{
    /** @use SdkModel<TenDlcUpdateCampaignParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * What this programme sends. TCR description: what recipients will get and why, in a sentence. The only one of these TCR takes verbatim as a description of the programme, which is why it is asked for rather than derived from the customer's name. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional]
    public ?string $description;

    /**
     * Help keywords. TCR helpKeywords, comma separated, e.g. HELP,INFO. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('help_keywords')]
    public ?string $helpKeywords;

    /**
     * Help reply. TCR helpMessage. Its presence is what sets subscriberHelp. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('help_message')]
    public ?string $helpMessage;

    /**
     * Consent narrative. TCR messageFlow: how recipients opt in, in prose. Under 40 characters is refused, and carriers reject vague descriptions — say where opt-in happens, that the box is unchecked by default, and that consent is not a condition of purchase. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('message_flow')]
    public ?string $messageFlow;

    /**
     * Opt-in keywords. TCR optinKeywords, comma separated, e.g. START,YES. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('opt_in_keywords')]
    public ?string $optInKeywords;

    /**
     * Opt-in confirmation. TCR optinMessage. Should state message frequency and that rates may apply. Its presence is what sets subscriberOptin. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('opt_in_message')]
    public ?string $optInMessage;

    /**
     * Opt-out keywords. TCR optoutKeywords, comma separated. STOP, END, CANCEL, UNSUBSCRIBE and QUIT are honoured regardless of what is declared. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('opt_out_keywords')]
    public ?string $optOutKeywords;

    /**
     * Opt-out confirmation. TCR optoutMessage. Its presence is what sets subscriberOptout. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('opt_out_message')]
    public ?string $optOutMessage;

    /**
     * Privacy policy URL. TCR privacyPolicyLink. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('privacy_policy_link')]
    public ?string $privacyPolicyLink;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * Terms and conditions URL. TCR termsAndConditionsLink. Required when `compliance.campaign.inherit != true`.
     */
    #[Optional('terms_and_conditions_link')]
    public ?string $termsAndConditionsLink;

    /**
     * Use cases. What the campaign sends, and an example of each. One to five entries; how they register is decided by volume, never declared. Required when `compliance.campaign.inherit != true`.
     *
     * @var list<UseCase>|null $useCases
     */
    #[Optional('use_cases', list: UseCase::class)]
    public ?array $useCases;

    /**
     * Expected monthly volume. Decides how the campaign registers and which fee tier applies: below the low-volume threshold it registers as LOW_VOLUME with sub-use-cases, above it as a single use case or MIXED. Omitting it registers the campaign at the higher-fee standard tier.
     */
    #[Optional]
    public ?string $volume;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<UseCase|UseCase1Shape>|null $useCases
     */
    public static function with(
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
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $helpKeywords && $self['helpKeywords'] = $helpKeywords;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $messageFlow && $self['messageFlow'] = $messageFlow;
        null !== $optInKeywords && $self['optInKeywords'] = $optInKeywords;
        null !== $optInMessage && $self['optInMessage'] = $optInMessage;
        null !== $optOutKeywords && $self['optOutKeywords'] = $optOutKeywords;
        null !== $optOutMessage && $self['optOutMessage'] = $optOutMessage;
        null !== $privacyPolicyLink && $self['privacyPolicyLink'] = $privacyPolicyLink;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $termsAndConditionsLink && $self['termsAndConditionsLink'] = $termsAndConditionsLink;
        null !== $useCases && $self['useCases'] = $useCases;
        null !== $volume && $self['volume'] = $volume;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * What this programme sends. TCR description: what recipients will get and why, in a sentence. The only one of these TCR takes verbatim as a description of the programme, which is why it is asked for rather than derived from the customer's name. Required when `compliance.campaign.inherit != true`.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Help keywords. TCR helpKeywords, comma separated, e.g. HELP,INFO. Required when `compliance.campaign.inherit != true`.
     */
    public function withHelpKeywords(string $helpKeywords): self
    {
        $self = clone $this;
        $self['helpKeywords'] = $helpKeywords;

        return $self;
    }

    /**
     * Help reply. TCR helpMessage. Its presence is what sets subscriberHelp. Required when `compliance.campaign.inherit != true`.
     */
    public function withHelpMessage(string $helpMessage): self
    {
        $self = clone $this;
        $self['helpMessage'] = $helpMessage;

        return $self;
    }

    /**
     * Consent narrative. TCR messageFlow: how recipients opt in, in prose. Under 40 characters is refused, and carriers reject vague descriptions — say where opt-in happens, that the box is unchecked by default, and that consent is not a condition of purchase. Required when `compliance.campaign.inherit != true`.
     */
    public function withMessageFlow(string $messageFlow): self
    {
        $self = clone $this;
        $self['messageFlow'] = $messageFlow;

        return $self;
    }

    /**
     * Opt-in keywords. TCR optinKeywords, comma separated, e.g. START,YES. Required when `compliance.campaign.inherit != true`.
     */
    public function withOptInKeywords(string $optInKeywords): self
    {
        $self = clone $this;
        $self['optInKeywords'] = $optInKeywords;

        return $self;
    }

    /**
     * Opt-in confirmation. TCR optinMessage. Should state message frequency and that rates may apply. Its presence is what sets subscriberOptin. Required when `compliance.campaign.inherit != true`.
     */
    public function withOptInMessage(string $optInMessage): self
    {
        $self = clone $this;
        $self['optInMessage'] = $optInMessage;

        return $self;
    }

    /**
     * Opt-out keywords. TCR optoutKeywords, comma separated. STOP, END, CANCEL, UNSUBSCRIBE and QUIT are honoured regardless of what is declared. Required when `compliance.campaign.inherit != true`.
     */
    public function withOptOutKeywords(string $optOutKeywords): self
    {
        $self = clone $this;
        $self['optOutKeywords'] = $optOutKeywords;

        return $self;
    }

    /**
     * Opt-out confirmation. TCR optoutMessage. Its presence is what sets subscriberOptout. Required when `compliance.campaign.inherit != true`.
     */
    public function withOptOutMessage(string $optOutMessage): self
    {
        $self = clone $this;
        $self['optOutMessage'] = $optOutMessage;

        return $self;
    }

    /**
     * Privacy policy URL. TCR privacyPolicyLink. Required when `compliance.campaign.inherit != true`.
     */
    public function withPrivacyPolicyLink(string $privacyPolicyLink): self
    {
        $self = clone $this;
        $self['privacyPolicyLink'] = $privacyPolicyLink;

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
     * Terms and conditions URL. TCR termsAndConditionsLink. Required when `compliance.campaign.inherit != true`.
     */
    public function withTermsAndConditionsLink(
        string $termsAndConditionsLink
    ): self {
        $self = clone $this;
        $self['termsAndConditionsLink'] = $termsAndConditionsLink;

        return $self;
    }

    /**
     * Use cases. What the campaign sends, and an example of each. One to five entries; how they register is decided by volume, never declared. Required when `compliance.campaign.inherit != true`.
     *
     * @param list<UseCase|UseCase1Shape> $useCases
     */
    public function withUseCases(array $useCases): self
    {
        $self = clone $this;
        $self['useCases'] = $useCases;

        return $self;
    }

    /**
     * Expected monthly volume. Decides how the campaign registers and which fee tier applies: below the low-volume threshold it registers as LOW_VOLUME with sub-use-cases, above it as a single use case or MIXED. Omitting it registers the campaign at the higher-fee standard tier.
     */
    public function withVolume(string $volume): self
    {
        $self = clone $this;
        $self['volume'] = $volume;

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
