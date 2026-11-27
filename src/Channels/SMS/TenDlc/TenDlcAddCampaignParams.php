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
 * The new campaign's fields, at the top level of the body: use cases, consent narrative, volume, sample messages and keywords, under their keys (`description`, `message_flow`, `use_cases`, `volume`, …). It has to be complete. A rejected field is keyed by its name (`description`). `id` and `inherit` are ignored, so an entry of `campaigns` can be sent as read.
 *
 * The identity is the market's and is not sent here. A market whose identity has no registration yet, or one not yet submitted for review, is `400`.
 *
 * ## What happens
 *
 * The campaign is recorded and goes for review; it is not filed with The Campaign Registry by this call. **It comes without numbers**: send its `id` from `compliance.campaigns` to `POST /v3/channels/sms/{country}/{type}/numbers` to give it some. **The campaign you already have, and its numbers, are not touched** — including a campaign you run on from your organization.
 *
 * **Each call files a new campaign**, which is charged when it is submitted. Send an `Idempotency-Key` so a retried request does not file a second one.
 *
 * To change a campaign, use `PATCH /v3/channels/sms/US/TEN_DLC/campaigns/{campaignId}`; `PATCH /v3/channels/sms/US/TEN_DLC` changes the brand and documents only, and refuses a campaign or numbers (`400`).
 *
 * Returns **the market**, in the shape `GET /v3/channels/sms/US/TEN_DLC` returns, with `202`.
 *
 * @see SentDm\Services\Channels\SMS\TenDlcService::addCampaign()
 *
 * @phpstan-import-type TenDlcCampaignUseCaseShape from \SentDm\Channels\SMS\TenDlc\TenDlcCampaignUseCase
 *
 * @phpstan-type TenDlcAddCampaignParamsShape = array{
 *   description: string,
 *   helpKeywords: string,
 *   helpMessage: string,
 *   messageFlow: string,
 *   optInKeywords: string,
 *   optInMessage: string,
 *   optOutKeywords: string,
 *   optOutMessage: string,
 *   privacyPolicyLink: string,
 *   termsAndConditionsLink: string,
 *   useCases: list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape>,
 *   volume: string,
 *   idempotencyKey: string,
 *   sandbox?: bool|null,
 *   xProfileID?: string|null,
 * }
 */
final class TenDlcAddCampaignParams implements BaseModel
{
    /** @use SdkModel<TenDlcAddCampaignParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * What this programme sends. TCR description: what recipients will get and why, in a sentence. The only one of these TCR takes verbatim as a description of the programme, which is why it is asked for rather than derived from the customer's name. Required when `compliance.campaign.inherit != true`.
     */
    #[Required]
    public string $description;

    /**
     * Help keywords. TCR helpKeywords, comma separated, e.g. HELP,INFO. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('help_keywords')]
    public string $helpKeywords;

    /**
     * Help reply. TCR helpMessage. Its presence is what sets subscriberHelp. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('help_message')]
    public string $helpMessage;

    /**
     * Consent narrative. TCR messageFlow: how recipients opt in, in prose. Under 40 characters is refused, and carriers reject vague descriptions — say where opt-in happens, that the box is unchecked by default, and that consent is not a condition of purchase. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('message_flow')]
    public string $messageFlow;

    /**
     * Opt-in keywords. TCR optinKeywords, comma separated, e.g. START,YES. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('opt_in_keywords')]
    public string $optInKeywords;

    /**
     * Opt-in confirmation. TCR optinMessage. Should state message frequency and that rates may apply. Its presence is what sets subscriberOptin. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('opt_in_message')]
    public string $optInMessage;

    /**
     * Opt-out keywords. TCR optoutKeywords, comma separated. STOP, END, CANCEL, UNSUBSCRIBE and QUIT are honoured regardless of what is declared. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('opt_out_keywords')]
    public string $optOutKeywords;

    /**
     * Opt-out confirmation. TCR optoutMessage. Its presence is what sets subscriberOptout. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('opt_out_message')]
    public string $optOutMessage;

    /**
     * Privacy policy URL. TCR privacyPolicyLink. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('privacy_policy_link')]
    public string $privacyPolicyLink;

    /**
     * Terms and conditions URL. TCR termsAndConditionsLink. Required when `compliance.campaign.inherit != true`.
     */
    #[Required('terms_and_conditions_link')]
    public string $termsAndConditionsLink;

    /**
     * Use cases. What the campaign sends, and an example of each. One to five entries; how they register is decided by volume, never declared. Required when `compliance.campaign.inherit != true`.
     *
     * @var list<TenDlcCampaignUseCase> $useCases
     */
    #[Required('use_cases', list: TenDlcCampaignUseCase::class)]
    public array $useCases;

    /**
     * Expected monthly volume. Required whenever the campaign's fields are written. A whole number of messages, e.g. 1000 or 10000. Decides how the campaign registers and which fee tier applies: below the low-volume threshold it registers as LOW_VOLUME with sub-use-cases, above it as a single use case or MIXED. Omitting it registers the campaign at the higher-fee standard tier. Required when `compliance.campaign.inherit != true`, whenever its block is written.
     */
    #[Required]
    public string $volume;

    #[Required]
    public string $idempotencyKey;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new TenDlcAddCampaignParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TenDlcAddCampaignParams::with(
     *   description: ...,
     *   helpKeywords: ...,
     *   helpMessage: ...,
     *   messageFlow: ...,
     *   optInKeywords: ...,
     *   optInMessage: ...,
     *   optOutKeywords: ...,
     *   optOutMessage: ...,
     *   privacyPolicyLink: ...,
     *   termsAndConditionsLink: ...,
     *   useCases: ...,
     *   volume: ...,
     *   idempotencyKey: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TenDlcAddCampaignParams)
     *   ->withDescription(...)
     *   ->withHelpKeywords(...)
     *   ->withHelpMessage(...)
     *   ->withMessageFlow(...)
     *   ->withOptInKeywords(...)
     *   ->withOptInMessage(...)
     *   ->withOptOutKeywords(...)
     *   ->withOptOutMessage(...)
     *   ->withPrivacyPolicyLink(...)
     *   ->withTermsAndConditionsLink(...)
     *   ->withUseCases(...)
     *   ->withVolume(...)
     *   ->withIdempotencyKey(...)
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
     * @param list<TenDlcCampaignUseCase|TenDlcCampaignUseCaseShape> $useCases
     */
    public static function with(
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
    ): self {
        $self = new self;

        $self['description'] = $description;
        $self['helpKeywords'] = $helpKeywords;
        $self['helpMessage'] = $helpMessage;
        $self['messageFlow'] = $messageFlow;
        $self['optInKeywords'] = $optInKeywords;
        $self['optInMessage'] = $optInMessage;
        $self['optOutKeywords'] = $optOutKeywords;
        $self['optOutMessage'] = $optOutMessage;
        $self['privacyPolicyLink'] = $privacyPolicyLink;
        $self['termsAndConditionsLink'] = $termsAndConditionsLink;
        $self['useCases'] = $useCases;
        $self['volume'] = $volume;
        $self['idempotencyKey'] = $idempotencyKey;

        null !== $sandbox && $self['sandbox'] = $sandbox;
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
     * Expected monthly volume. Required whenever the campaign's fields are written. A whole number of messages, e.g. 1000 or 10000. Decides how the campaign registers and which fee tier applies: below the low-volume threshold it registers as LOW_VOLUME with sub-use-cases, above it as a single use case or MIXED. Omitting it registers the campaign at the higher-fee standard tier. Required when `compliance.campaign.inherit != true`, whenever its block is written.
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

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
