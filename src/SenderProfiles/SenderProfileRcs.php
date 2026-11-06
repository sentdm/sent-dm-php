<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Channels\Rcs\RcsAddress;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Asks for an RCS agent of the profile's own, optionally with the full order form inline.
 *
 * Two modes, distinguished by whether any field is populated:
 * "rcs": {} — intent only. Records that the profile wants its own agent; the order form is
 * submitted separately through POST /v3/channels/rcs once the fields are ready.
 * "rcs": { ...fields... } — full form. All required fields must be present; the agent is
 * created alongside the profile in one call. Omitting opt_in_screenshot_url is allowed.
 *
 * @phpstan-import-type RcsAddressShape from \SentDm\Channels\Rcs\RcsAddress
 *
 * @phpstan-type SenderProfileRcsShape = array{
 *   description: string,
 *   agentUseCase?: string|null,
 *   bannerURL?: string|null,
 *   billingCategory?: string|null,
 *   brandColor?: string|null,
 *   brandEmail?: string|null,
 *   brandName?: string|null,
 *   brandPhoneNumber?: string|null,
 *   briefCompanyDescription?: string|null,
 *   companyEin?: string|null,
 *   contactNameAndTitle?: string|null,
 *   customerSupportEmail?: string|null,
 *   customerSupportPhoneNumber?: string|null,
 *   displayName?: string|null,
 *   entityType?: string|null,
 *   helpMessage?: string|null,
 *   hostingRegion?: string|null,
 *   logoURL?: string|null,
 *   officialAddress?: null|RcsAddress|RcsAddressShape,
 *   optInProcessDescription?: string|null,
 *   optInScreenshotURL?: string|null,
 *   privacyPolicyURL?: string|null,
 *   sampleMessages?: list<string>|null,
 *   startMessage?: string|null,
 *   stopMessage?: string|null,
 *   termsAndConditionsURL?: string|null,
 *   websiteURL?: string|null,
 * }
 */
final class SenderProfileRcs implements BaseModel
{
    /** @use SdkModel<SenderProfileRcsShape> */
    use SdkModel;

    #[Required]
    public string $description;

    #[Optional('agent_use_case', nullable: true)]
    public ?string $agentUseCase;

    #[Optional('banner_url', nullable: true)]
    public ?string $bannerURL;

    #[Optional('billing_category', nullable: true)]
    public ?string $billingCategory;

    #[Optional('brand_color', nullable: true)]
    public ?string $brandColor;

    #[Optional('brand_email', nullable: true)]
    public ?string $brandEmail;

    #[Optional('brand_name', nullable: true)]
    public ?string $brandName;

    #[Optional('brand_phone_number', nullable: true)]
    public ?string $brandPhoneNumber;

    #[Optional('brief_company_description', nullable: true)]
    public ?string $briefCompanyDescription;

    #[Optional('company_ein', nullable: true)]
    public ?string $companyEin;

    #[Optional('contact_name_and_title', nullable: true)]
    public ?string $contactNameAndTitle;

    #[Optional('customer_support_email', nullable: true)]
    public ?string $customerSupportEmail;

    #[Optional('customer_support_phone_number', nullable: true)]
    public ?string $customerSupportPhoneNumber;

    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    #[Optional('entity_type', nullable: true)]
    public ?string $entityType;

    #[Optional('help_message', nullable: true)]
    public ?string $helpMessage;

    #[Optional('hosting_region', nullable: true)]
    public ?string $hostingRegion;

    #[Optional('logo_url', nullable: true)]
    public ?string $logoURL;

    /**
     * The registered address of the company behind the agent.
     */
    #[Optional('official_address', nullable: true)]
    public ?RcsAddress $officialAddress;

    #[Optional('opt_in_process_description', nullable: true)]
    public ?string $optInProcessDescription;

    /**
     * Optional — uploaded separately and its URL may not be known at submission time.
     */
    #[Optional('opt_in_screenshot_url', nullable: true)]
    public ?string $optInScreenshotURL;

    #[Optional('privacy_policy_url', nullable: true)]
    public ?string $privacyPolicyURL;

    /** @var list<string>|null $sampleMessages */
    #[Optional('sample_messages', list: 'string', nullable: true)]
    public ?array $sampleMessages;

    #[Optional('start_message', nullable: true)]
    public ?string $startMessage;

    #[Optional('stop_message', nullable: true)]
    public ?string $stopMessage;

    #[Optional('terms_and_conditions_url', nullable: true)]
    public ?string $termsAndConditionsURL;

    #[Optional('website_url', nullable: true)]
    public ?string $websiteURL;

    /**
     * `new SenderProfileRcs()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SenderProfileRcs::with(description: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderProfileRcs)->withDescription(...)
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
     * @param RcsAddress|RcsAddressShape|null $officialAddress
     * @param list<string>|null $sampleMessages
     */
    public static function with(
        string $description,
        ?string $agentUseCase = null,
        ?string $bannerURL = null,
        ?string $billingCategory = null,
        ?string $brandColor = null,
        ?string $brandEmail = null,
        ?string $brandName = null,
        ?string $brandPhoneNumber = null,
        ?string $briefCompanyDescription = null,
        ?string $companyEin = null,
        ?string $contactNameAndTitle = null,
        ?string $customerSupportEmail = null,
        ?string $customerSupportPhoneNumber = null,
        ?string $displayName = null,
        ?string $entityType = null,
        ?string $helpMessage = null,
        ?string $hostingRegion = null,
        ?string $logoURL = null,
        RcsAddress|array|null $officialAddress = null,
        ?string $optInProcessDescription = null,
        ?string $optInScreenshotURL = null,
        ?string $privacyPolicyURL = null,
        ?array $sampleMessages = null,
        ?string $startMessage = null,
        ?string $stopMessage = null,
        ?string $termsAndConditionsURL = null,
        ?string $websiteURL = null,
    ): self {
        $self = new self;

        $self['description'] = $description;

        null !== $agentUseCase && $self['agentUseCase'] = $agentUseCase;
        null !== $bannerURL && $self['bannerURL'] = $bannerURL;
        null !== $billingCategory && $self['billingCategory'] = $billingCategory;
        null !== $brandColor && $self['brandColor'] = $brandColor;
        null !== $brandEmail && $self['brandEmail'] = $brandEmail;
        null !== $brandName && $self['brandName'] = $brandName;
        null !== $brandPhoneNumber && $self['brandPhoneNumber'] = $brandPhoneNumber;
        null !== $briefCompanyDescription && $self['briefCompanyDescription'] = $briefCompanyDescription;
        null !== $companyEin && $self['companyEin'] = $companyEin;
        null !== $contactNameAndTitle && $self['contactNameAndTitle'] = $contactNameAndTitle;
        null !== $customerSupportEmail && $self['customerSupportEmail'] = $customerSupportEmail;
        null !== $customerSupportPhoneNumber && $self['customerSupportPhoneNumber'] = $customerSupportPhoneNumber;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $hostingRegion && $self['hostingRegion'] = $hostingRegion;
        null !== $logoURL && $self['logoURL'] = $logoURL;
        null !== $officialAddress && $self['officialAddress'] = $officialAddress;
        null !== $optInProcessDescription && $self['optInProcessDescription'] = $optInProcessDescription;
        null !== $optInScreenshotURL && $self['optInScreenshotURL'] = $optInScreenshotURL;
        null !== $privacyPolicyURL && $self['privacyPolicyURL'] = $privacyPolicyURL;
        null !== $sampleMessages && $self['sampleMessages'] = $sampleMessages;
        null !== $startMessage && $self['startMessage'] = $startMessage;
        null !== $stopMessage && $self['stopMessage'] = $stopMessage;
        null !== $termsAndConditionsURL && $self['termsAndConditionsURL'] = $termsAndConditionsURL;
        null !== $websiteURL && $self['websiteURL'] = $websiteURL;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withAgentUseCase(?string $agentUseCase): self
    {
        $self = clone $this;
        $self['agentUseCase'] = $agentUseCase;

        return $self;
    }

    public function withBannerURL(?string $bannerURL): self
    {
        $self = clone $this;
        $self['bannerURL'] = $bannerURL;

        return $self;
    }

    public function withBillingCategory(?string $billingCategory): self
    {
        $self = clone $this;
        $self['billingCategory'] = $billingCategory;

        return $self;
    }

    public function withBrandColor(?string $brandColor): self
    {
        $self = clone $this;
        $self['brandColor'] = $brandColor;

        return $self;
    }

    public function withBrandEmail(?string $brandEmail): self
    {
        $self = clone $this;
        $self['brandEmail'] = $brandEmail;

        return $self;
    }

    public function withBrandName(?string $brandName): self
    {
        $self = clone $this;
        $self['brandName'] = $brandName;

        return $self;
    }

    public function withBrandPhoneNumber(?string $brandPhoneNumber): self
    {
        $self = clone $this;
        $self['brandPhoneNumber'] = $brandPhoneNumber;

        return $self;
    }

    public function withBriefCompanyDescription(
        ?string $briefCompanyDescription
    ): self {
        $self = clone $this;
        $self['briefCompanyDescription'] = $briefCompanyDescription;

        return $self;
    }

    public function withCompanyEin(?string $companyEin): self
    {
        $self = clone $this;
        $self['companyEin'] = $companyEin;

        return $self;
    }

    public function withContactNameAndTitle(?string $contactNameAndTitle): self
    {
        $self = clone $this;
        $self['contactNameAndTitle'] = $contactNameAndTitle;

        return $self;
    }

    public function withCustomerSupportEmail(
        ?string $customerSupportEmail
    ): self {
        $self = clone $this;
        $self['customerSupportEmail'] = $customerSupportEmail;

        return $self;
    }

    public function withCustomerSupportPhoneNumber(
        ?string $customerSupportPhoneNumber
    ): self {
        $self = clone $this;
        $self['customerSupportPhoneNumber'] = $customerSupportPhoneNumber;

        return $self;
    }

    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    public function withEntityType(?string $entityType): self
    {
        $self = clone $this;
        $self['entityType'] = $entityType;

        return $self;
    }

    public function withHelpMessage(?string $helpMessage): self
    {
        $self = clone $this;
        $self['helpMessage'] = $helpMessage;

        return $self;
    }

    public function withHostingRegion(?string $hostingRegion): self
    {
        $self = clone $this;
        $self['hostingRegion'] = $hostingRegion;

        return $self;
    }

    public function withLogoURL(?string $logoURL): self
    {
        $self = clone $this;
        $self['logoURL'] = $logoURL;

        return $self;
    }

    /**
     * The registered address of the company behind the agent.
     *
     * @param RcsAddress|RcsAddressShape|null $officialAddress
     */
    public function withOfficialAddress(
        RcsAddress|array|null $officialAddress
    ): self {
        $self = clone $this;
        $self['officialAddress'] = $officialAddress;

        return $self;
    }

    public function withOptInProcessDescription(
        ?string $optInProcessDescription
    ): self {
        $self = clone $this;
        $self['optInProcessDescription'] = $optInProcessDescription;

        return $self;
    }

    /**
     * Optional — uploaded separately and its URL may not be known at submission time.
     */
    public function withOptInScreenshotURL(?string $optInScreenshotURL): self
    {
        $self = clone $this;
        $self['optInScreenshotURL'] = $optInScreenshotURL;

        return $self;
    }

    public function withPrivacyPolicyURL(?string $privacyPolicyURL): self
    {
        $self = clone $this;
        $self['privacyPolicyURL'] = $privacyPolicyURL;

        return $self;
    }

    /**
     * @param list<string>|null $sampleMessages
     */
    public function withSampleMessages(?array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

        return $self;
    }

    public function withStartMessage(?string $startMessage): self
    {
        $self = clone $this;
        $self['startMessage'] = $startMessage;

        return $self;
    }

    public function withStopMessage(?string $stopMessage): self
    {
        $self = clone $this;
        $self['stopMessage'] = $stopMessage;

        return $self;
    }

    public function withTermsAndConditionsURL(
        ?string $termsAndConditionsURL
    ): self {
        $self = clone $this;
        $self['termsAndConditionsURL'] = $termsAndConditionsURL;

        return $self;
    }

    public function withWebsiteURL(?string $websiteURL): self
    {
        $self = clone $this;
        $self['websiteURL'] = $websiteURL;

        return $self;
    }
}
