<?php

declare(strict_types=1);

namespace SentDm\Channels\Rcs;

use SentDm\Channels\Rcs\RcCreateParams\AgentUseCase;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Asks for an RCS agent and records the order form the carriers vet it against. Always `202`: an agent is approved by the carriers, not by this call, and nothing here can make that happen sooner.
 *
 * ## What it asks for
 *
 * The RCS Agent Order Form — the same one our team fills in on your behalf today, so nothing has to be collected from you twice. **All fields are required** and must be submitted together so the carrier review has everything it needs. The only exception is `opt_in_screenshot_url`.
 *
 * **Agent identity:** `display_name`, `description`, `agent_use_case` (must be one of the accepted use cases; the error names the set), `brand_color` (six-digit hex, `#RRGGBB`).
 *
 * **Brand identity:** `brand_name` — the brand this agent presents. Not taken from `compliance.brand`: a business may present a different brand on RCS than the one its 10DLC registration is filed against, and the carriers vet this one. `privacy_policy_url`, `terms_and_conditions_url`, `website_url`, `logo_url`, and `banner_url` must be absolute `http(s)` URLs that the carriers can fetch without authentication. The form specifies 224×224 px and 50 KB for the logo and 1440×448 px and 200 KB for the banner; these cannot be checked without the image bytes.
 *
 * **Contact details:** `brand_phone_number`, `customer_support_phone_number`, `brand_email`, `customer_support_email`, `contact_name_and_title`.
 *
 * **Company:** `company_ein`, `entity_type`, `official_address` (street, city, state, postal_code, country), `brief_company_description`.
 *
 * **Consent and messages:** `opt_in_process_description`, `start_message`, `help_message`, `stop_message`, `sample_messages` (at least one example message).
 *
 * **Optional:** `opt_in_screenshot_url` (validated as an http(s) URL if supplied).
 *
 * Anything supplied is checked against accepted values rather than passed through: a value the provider rejects would otherwise surface days later, to somebody who cannot fix it without asking you.
 *
 * **A customer has one agent.** Asking again while you have one is `409`.
 *
 * ## What comes back, and what does not
 *
 * Returns **the agent** — the form as stored, plus `id` and `status`. Not your other channels, which this call cannot have changed.
 *
 * `status` is `PROVISIONING` until the agent is handed to the carriers and approved. **`GET /v3/channels` reports `rcs: null` until then** — a channel row is what routing reads to decide you are sendable, and writing one for an unapproved agent would claim a channel that cannot carry traffic.
 *
 * Send `x-profile-id` with an organization key to ask for one of your profiles' agents.
 *
 * @see SentDm\Services\Channels\RcsService::create()
 *
 * @phpstan-import-type RcsAddressShape from \SentDm\Channels\Rcs\RcsAddress
 *
 * @phpstan-type RcCreateParamsShape = array{
 *   agentUseCase?: null|AgentUseCase|value-of<AgentUseCase>,
 *   bannerURL?: string|null,
 *   brandColor?: string|null,
 *   brandEmail?: string|null,
 *   brandName?: string|null,
 *   brandPhoneNumber?: string|null,
 *   briefCompanyDescription?: string|null,
 *   companyEin?: string|null,
 *   contactNameAndTitle?: string|null,
 *   customerSupportEmail?: string|null,
 *   customerSupportPhoneNumber?: string|null,
 *   description?: string|null,
 *   displayName?: string|null,
 *   entityType?: string|null,
 *   helpMessage?: string|null,
 *   logoURL?: string|null,
 *   officialAddress?: null|RcsAddress|RcsAddressShape,
 *   optInProcessDescription?: string|null,
 *   optInScreenshotURL?: string|null,
 *   privacyPolicyURL?: string|null,
 *   sampleMessages?: list<string>|null,
 *   sandbox?: bool|null,
 *   startMessage?: string|null,
 *   stopMessage?: string|null,
 *   termsAndConditionsURL?: string|null,
 *   websiteURL?: string|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class RcCreateParams implements BaseModel
{
    /** @use SdkModel<RcCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Which kind of traffic the agent carries. One of the accepted use cases; the error names the set.
     *
     * @var value-of<AgentUseCase>|null $agentUseCase
     */
    #[Optional('agent_use_case', enum: AgentUseCase::class)]
    public ?string $agentUseCase;

    #[Optional('banner_url')]
    public ?string $bannerURL;

    /**
     * Primary brand colour, as #RRGGBB. Three-digit shorthand is refused: the value is submitted
     * verbatim, so two spellings of one colour is only a way for the stored value to disagree with the form.
     */
    #[Optional('brand_color')]
    public ?string $brandColor;

    #[Optional('brand_email')]
    public ?string $brandEmail;

    /**
     * The brand this agent presents over RCS.
     *
     * Not taken from your compliance.brand: a business may present a different brand on RCS than
     * the one its 10DLC registration is filed against, and the carriers vet this one.
     */
    #[Optional('brand_name')]
    public ?string $brandName;

    /**
     * The brand's own number. Also becomes the agent's canonical sending number for routing, which is why it
     * is normalised to E.164 rather than stored as sent.
     */
    #[Optional('brand_phone_number')]
    public ?string $brandPhoneNumber;

    #[Optional('brief_company_description')]
    public ?string $briefCompanyDescription;

    #[Optional('company_ein')]
    public ?string $companyEin;

    #[Optional('contact_name_and_title')]
    public ?string $contactNameAndTitle;

    #[Optional('customer_support_email')]
    public ?string $customerSupportEmail;

    #[Optional('customer_support_phone_number')]
    public ?string $customerSupportPhoneNumber;

    /**
     * What the agent is for, shown to recipients. Capped by the carriers, not by us.
     */
    #[Optional]
    public ?string $description;

    /**
     * The name the agent shows in the messaging client.
     */
    #[Optional('display_name')]
    public ?string $displayName;

    #[Optional('entity_type')]
    public ?string $entityType;

    #[Optional('help_message')]
    public ?string $helpMessage;

    /**
     * Publicly reachable logo. It has to be fetchable without authentication at review time, so a URL behind
     * a login passes this call and fails the review.
     */
    #[Optional('logo_url')]
    public ?string $logoURL;

    /**
     * The registered address of the company behind the agent.
     */
    #[Optional('official_address')]
    public ?RcsAddress $officialAddress;

    /**
     * How recipients opt in, in prose. The carriers read this one.
     */
    #[Optional('opt_in_process_description')]
    public ?string $optInProcessDescription;

    /**
     * A screenshot of the opt-in, as a publicly fetchable URL.
     */
    #[Optional('opt_in_screenshot_url', nullable: true)]
    public ?string $optInScreenshotURL;

    /**
     * Required by US carriers. Must be an absolute http(s) URL they can fetch.
     */
    #[Optional('privacy_policy_url')]
    public ?string $privacyPolicyURL;

    /**
     * Examples of what the agent will send, for the review.
     *
     * @var list<string>|null $sampleMessages
     */
    #[Optional('sample_messages', list: 'string')]
    public ?array $sampleMessages;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional('start_message')]
    public ?string $startMessage;

    #[Optional('stop_message')]
    public ?string $stopMessage;

    #[Optional('terms_and_conditions_url')]
    public ?string $termsAndConditionsURL;

    /**
     * The brand's own site.
     */
    #[Optional('website_url')]
    public ?string $websiteURL;

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
     * @param AgentUseCase|value-of<AgentUseCase>|null $agentUseCase
     * @param RcsAddress|RcsAddressShape|null $officialAddress
     * @param list<string>|null $sampleMessages
     */
    public static function with(
        AgentUseCase|string|null $agentUseCase = null,
        ?string $bannerURL = null,
        ?string $brandColor = null,
        ?string $brandEmail = null,
        ?string $brandName = null,
        ?string $brandPhoneNumber = null,
        ?string $briefCompanyDescription = null,
        ?string $companyEin = null,
        ?string $contactNameAndTitle = null,
        ?string $customerSupportEmail = null,
        ?string $customerSupportPhoneNumber = null,
        ?string $description = null,
        ?string $displayName = null,
        ?string $entityType = null,
        ?string $helpMessage = null,
        ?string $logoURL = null,
        RcsAddress|array|null $officialAddress = null,
        ?string $optInProcessDescription = null,
        ?string $optInScreenshotURL = null,
        ?string $privacyPolicyURL = null,
        ?array $sampleMessages = null,
        ?bool $sandbox = null,
        ?string $startMessage = null,
        ?string $stopMessage = null,
        ?string $termsAndConditionsURL = null,
        ?string $websiteURL = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $agentUseCase && $self['agentUseCase'] = $agentUseCase;
        null !== $bannerURL && $self['bannerURL'] = $bannerURL;
        null !== $brandColor && $self['brandColor'] = $brandColor;
        null !== $brandEmail && $self['brandEmail'] = $brandEmail;
        null !== $brandName && $self['brandName'] = $brandName;
        null !== $brandPhoneNumber && $self['brandPhoneNumber'] = $brandPhoneNumber;
        null !== $briefCompanyDescription && $self['briefCompanyDescription'] = $briefCompanyDescription;
        null !== $companyEin && $self['companyEin'] = $companyEin;
        null !== $contactNameAndTitle && $self['contactNameAndTitle'] = $contactNameAndTitle;
        null !== $customerSupportEmail && $self['customerSupportEmail'] = $customerSupportEmail;
        null !== $customerSupportPhoneNumber && $self['customerSupportPhoneNumber'] = $customerSupportPhoneNumber;
        null !== $description && $self['description'] = $description;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $logoURL && $self['logoURL'] = $logoURL;
        null !== $officialAddress && $self['officialAddress'] = $officialAddress;
        null !== $optInProcessDescription && $self['optInProcessDescription'] = $optInProcessDescription;
        null !== $optInScreenshotURL && $self['optInScreenshotURL'] = $optInScreenshotURL;
        null !== $privacyPolicyURL && $self['privacyPolicyURL'] = $privacyPolicyURL;
        null !== $sampleMessages && $self['sampleMessages'] = $sampleMessages;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $startMessage && $self['startMessage'] = $startMessage;
        null !== $stopMessage && $self['stopMessage'] = $stopMessage;
        null !== $termsAndConditionsURL && $self['termsAndConditionsURL'] = $termsAndConditionsURL;
        null !== $websiteURL && $self['websiteURL'] = $websiteURL;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Which kind of traffic the agent carries. One of the accepted use cases; the error names the set.
     *
     * @param AgentUseCase|value-of<AgentUseCase> $agentUseCase
     */
    public function withAgentUseCase(AgentUseCase|string $agentUseCase): self
    {
        $self = clone $this;
        $self['agentUseCase'] = $agentUseCase;

        return $self;
    }

    public function withBannerURL(string $bannerURL): self
    {
        $self = clone $this;
        $self['bannerURL'] = $bannerURL;

        return $self;
    }

    /**
     * Primary brand colour, as #RRGGBB. Three-digit shorthand is refused: the value is submitted
     * verbatim, so two spellings of one colour is only a way for the stored value to disagree with the form.
     */
    public function withBrandColor(string $brandColor): self
    {
        $self = clone $this;
        $self['brandColor'] = $brandColor;

        return $self;
    }

    public function withBrandEmail(string $brandEmail): self
    {
        $self = clone $this;
        $self['brandEmail'] = $brandEmail;

        return $self;
    }

    /**
     * The brand this agent presents over RCS.
     *
     * Not taken from your compliance.brand: a business may present a different brand on RCS than
     * the one its 10DLC registration is filed against, and the carriers vet this one.
     */
    public function withBrandName(string $brandName): self
    {
        $self = clone $this;
        $self['brandName'] = $brandName;

        return $self;
    }

    /**
     * The brand's own number. Also becomes the agent's canonical sending number for routing, which is why it
     * is normalised to E.164 rather than stored as sent.
     */
    public function withBrandPhoneNumber(string $brandPhoneNumber): self
    {
        $self = clone $this;
        $self['brandPhoneNumber'] = $brandPhoneNumber;

        return $self;
    }

    public function withBriefCompanyDescription(
        string $briefCompanyDescription
    ): self {
        $self = clone $this;
        $self['briefCompanyDescription'] = $briefCompanyDescription;

        return $self;
    }

    public function withCompanyEin(string $companyEin): self
    {
        $self = clone $this;
        $self['companyEin'] = $companyEin;

        return $self;
    }

    public function withContactNameAndTitle(string $contactNameAndTitle): self
    {
        $self = clone $this;
        $self['contactNameAndTitle'] = $contactNameAndTitle;

        return $self;
    }

    public function withCustomerSupportEmail(string $customerSupportEmail): self
    {
        $self = clone $this;
        $self['customerSupportEmail'] = $customerSupportEmail;

        return $self;
    }

    public function withCustomerSupportPhoneNumber(
        string $customerSupportPhoneNumber
    ): self {
        $self = clone $this;
        $self['customerSupportPhoneNumber'] = $customerSupportPhoneNumber;

        return $self;
    }

    /**
     * What the agent is for, shown to recipients. Capped by the carriers, not by us.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The name the agent shows in the messaging client.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    public function withEntityType(string $entityType): self
    {
        $self = clone $this;
        $self['entityType'] = $entityType;

        return $self;
    }

    public function withHelpMessage(string $helpMessage): self
    {
        $self = clone $this;
        $self['helpMessage'] = $helpMessage;

        return $self;
    }

    /**
     * Publicly reachable logo. It has to be fetchable without authentication at review time, so a URL behind
     * a login passes this call and fails the review.
     */
    public function withLogoURL(string $logoURL): self
    {
        $self = clone $this;
        $self['logoURL'] = $logoURL;

        return $self;
    }

    /**
     * The registered address of the company behind the agent.
     *
     * @param RcsAddress|RcsAddressShape $officialAddress
     */
    public function withOfficialAddress(RcsAddress|array $officialAddress): self
    {
        $self = clone $this;
        $self['officialAddress'] = $officialAddress;

        return $self;
    }

    /**
     * How recipients opt in, in prose. The carriers read this one.
     */
    public function withOptInProcessDescription(
        string $optInProcessDescription
    ): self {
        $self = clone $this;
        $self['optInProcessDescription'] = $optInProcessDescription;

        return $self;
    }

    /**
     * A screenshot of the opt-in, as a publicly fetchable URL.
     */
    public function withOptInScreenshotURL(?string $optInScreenshotURL): self
    {
        $self = clone $this;
        $self['optInScreenshotURL'] = $optInScreenshotURL;

        return $self;
    }

    /**
     * Required by US carriers. Must be an absolute http(s) URL they can fetch.
     */
    public function withPrivacyPolicyURL(string $privacyPolicyURL): self
    {
        $self = clone $this;
        $self['privacyPolicyURL'] = $privacyPolicyURL;

        return $self;
    }

    /**
     * Examples of what the agent will send, for the review.
     *
     * @param list<string> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

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

    public function withStartMessage(string $startMessage): self
    {
        $self = clone $this;
        $self['startMessage'] = $startMessage;

        return $self;
    }

    public function withStopMessage(string $stopMessage): self
    {
        $self = clone $this;
        $self['stopMessage'] = $stopMessage;

        return $self;
    }

    public function withTermsAndConditionsURL(
        string $termsAndConditionsURL
    ): self {
        $self = clone $this;
        $self['termsAndConditionsURL'] = $termsAndConditionsURL;

        return $self;
    }

    /**
     * The brand's own site.
     */
    public function withWebsiteURL(string $websiteURL): self
    {
        $self = clone $this;
        $self['websiteURL'] = $websiteURL;

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
