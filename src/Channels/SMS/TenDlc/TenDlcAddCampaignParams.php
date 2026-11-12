<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Registers **a new campaign** on the US `TEN_DLC` market you already hold — the one market that registers campaigns. Use it when you want numbers for a different use case than the market's existing campaign covers. The campaign is filed under the brand the market files under — your organization's when you inherit its identity.
 *
 * ## What to send
 *
 * The new campaign's fields, at the top level of the body: use cases, consent narrative, volume, sample messages and keywords, under the `compliance.campaign.*` keys `GET /v3/compliance/requirements?country=US&type=TEN_DLC` lists, without that prefix. It has to be complete. A rejected field is keyed by its name (`description`). `id` and `inherit` are ignored, so an entry of `compliance.campaigns` can be sent as read.
 *
 * The identity is the market's and is not sent here. A market whose identity has no registration yet, or one not yet submitted for review, is `400`.
 *
 * ## What happens
 *
 * The campaign is recorded and goes for review; it is not filed with The Campaign Registry by this call. **It comes without numbers**: send its `id` from `compliance.campaigns` to `POST /v3/channels/sms/numbers/US/TEN_DLC` to give it some. **The campaign you already have, and its numbers, are not touched** — including a campaign you run on from your organization.
 *
 * **Each call files a new campaign**, which is charged when it is submitted. Send an `Idempotency-Key` so a retried request does not file a second one.
 *
 * To change the campaign a market already has, use `PATCH /v3/channels/sms/US/TEN_DLC`. Once a market holds more than one campaign, that `PATCH` refuses a campaign or numbers change (`409`) rather than guess which campaign is meant; numbers are added to a named campaign with `POST /v3/channels/sms/numbers/US/TEN_DLC`.
 *
 * Returns **the market**, in the shape `GET /v3/channels/sms/US/TEN_DLC` returns, with `202`.
 *
 * @see SentDm\Services\Channels\SMS\TenDlcService::addCampaign()
 *
 * @phpstan-import-type TenDlcCampaignUseCaseShape from \SentDm\Channels\SMS\TenDlc\TenDlcCampaignUseCase
 *
 * @phpstan-type TenDlcAddCampaignParamsShape = array{
 *   idempotencyKey: string,
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
 *   useCases?: list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape>|null,
 *   volume?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class TenDlcAddCampaignParams implements BaseModel
{
    /** @use SdkModel<TenDlcAddCampaignParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $idempotencyKey;

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
     * @var list<TenDlcCampaignUseCase>|null $useCases
     */
    #[Optional('use_cases', list: TenDlcCampaignUseCase::class)]
    public ?array $useCases;

    /**
     * Expected monthly volume. Decides how the campaign registers and which fee tier applies: below the low-volume threshold it registers as LOW_VOLUME with sub-use-cases, above it as a single use case or MIXED. Omitting it registers the campaign at the higher-fee standard tier.
     */
    #[Optional]
    public ?string $volume;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new TenDlcAddCampaignParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TenDlcAddCampaignParams::with(idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TenDlcAddCampaignParams)->withIdempotencyKey(...)
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
     * @param list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape>|null $useCases
     */
    public static function with(
        string $idempotencyKey,
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
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['idempotencyKey'] = $idempotencyKey;

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
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

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
     * @param list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape> $useCases
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

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
