<?php

declare(strict_types=1);

namespace SentDm\Channels\Rcs;

use SentDm\Channels\Rcs\RcsAgent\Status;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * An RCS agent as its owner sees it: the order form back, plus where the submission stands.
 *
 * Not RcsSenderResponse. That one is the admin projection and carries the pipeline we
 * track about a customer's request — internalStatus, statusReason,
 * isLaunched — and the S3 keys behind the assets. None of that is the customer's to read: an internal
 * status is a note to ourselves, and an S3 key is a storage detail that would become a contract the moment
 * it was published.
 *
 * What is here is what the caller sent, in the names it sent them under, plus the three things only we
 * can answer: the record's id, its status, and the number it sends from. So a read after a
 * write shows the form as stored rather than as echoed.
 *
 * @phpstan-import-type RcsAddressShape from \SentDm\Channels\Rcs\RcsAddress
 *
 * @phpstan-type RcsAgentShape = array{
 *   id?: string|null,
 *   agentUseCase?: string|null,
 *   brandColor?: string|null,
 *   brandEmail?: string|null,
 *   brandName?: string|null,
 *   brandPhoneNumber?: string|null,
 *   briefCompanyDescription?: string|null,
 *   companyEin?: string|null,
 *   contactNameAndTitle?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   customerSupportEmail?: string|null,
 *   customerSupportPhoneNumber?: string|null,
 *   description?: string|null,
 *   displayName?: string|null,
 *   entityType?: string|null,
 *   helpMessage?: string|null,
 *   officialAddress?: null|RcsAddress|RcsAddressShape,
 *   optInProcessDescription?: string|null,
 *   phoneNumber?: string|null,
 *   privacyPolicyURL?: string|null,
 *   reason?: string|null,
 *   reasonCode?: string|null,
 *   sampleMessages?: list<string>|null,
 *   startMessage?: string|null,
 *   status?: null|Status|value-of<Status>,
 *   stopMessage?: string|null,
 *   termsAndConditionsURL?: string|null,
 *   websiteURL?: string|null,
 * }
 */
final class RcsAgent implements BaseModel
{
    /** @use SdkModel<RcsAgentShape> */
    use SdkModel;

    /**
     * The agent record. Stable across the whole approval, and what support will ask for.
     *
     * Nullable and omitted when absent: a sender profile with RCS intent records the channel but has no
     * agent until the order form is submitted, so no id exists to report. A zero GUID is not a valid id
     * and is worse than the field being absent.
     */
    #[Optional(nullable: true)]
    public ?string $id;

    #[Optional('agent_use_case', nullable: true)]
    public ?string $agentUseCase;

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

    /**
     * Omitted when no real agent record exists — the intent-only path has no creation timestamp.
     */
    #[Optional('created_at', nullable: true)]
    public ?\DateTimeInterface $createdAt;

    #[Optional('customer_support_email', nullable: true)]
    public ?string $customerSupportEmail;

    #[Optional('customer_support_phone_number', nullable: true)]
    public ?string $customerSupportPhoneNumber;

    #[Optional(nullable: true)]
    public ?string $description;

    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    #[Optional('entity_type', nullable: true)]
    public ?string $entityType;

    #[Optional('help_message', nullable: true)]
    public ?string $helpMessage;

    /**
     * The registered address of the company behind the agent.
     */
    #[Optional('official_address', nullable: true)]
    public ?RcsAddress $officialAddress;

    #[Optional('opt_in_process_description', nullable: true)]
    public ?string $optInProcessDescription;

    /**
     * The number the agent sends from, derived from brand_phone_number.
     */
    #[Optional('phone_number', nullable: true)]
    public ?string $phoneNumber;

    #[Optional('privacy_policy_url', nullable: true)]
    public ?string $privacyPolicyURL;

    /**
     * A sentence for reason_code, saying what to do where it is yours. Omitted while ACTIVE.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * Why the agent is not ACTIVE, as a stable code: an ErrorCodes CHANNEL_xxx value such
     * as CHANNEL_001 (something you owe) or CHANNEL_009 (under review). Switch on this rather than
     * on reason. Omitted while ACTIVE. Read-only; when nothing more specific is known it is the
     * generic reason for the status.
     */
    #[Optional('reason_code', nullable: true)]
    public ?string $reasonCode;

    /** @var list<string>|null $sampleMessages */
    #[Optional('sample_messages', list: 'string', nullable: true)]
    public ?array $sampleMessages;

    #[Optional('start_message', nullable: true)]
    public ?string $startMessage;

    /**
     * Where the agent stands, in terms of who is holding it up — PROVISIONING, ACTION_NEEDED,
     * PENDING_REVIEW or ACTIVE.
     *
     * Resolved from both of the provider's axes rather than reported raw: an agent whose resubmission
     * we have asked for reads ACTION_NEEDED however its carrier status still reads, and an agent not
     * yet handed over reads PROVISIONING rather than pending a review nobody has started.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    #[Optional('stop_message', nullable: true)]
    public ?string $stopMessage;

    #[Optional('terms_and_conditions_url', nullable: true)]
    public ?string $termsAndConditionsURL;

    #[Optional('website_url', nullable: true)]
    public ?string $websiteURL;

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
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?string $id = null,
        ?string $agentUseCase = null,
        ?string $brandColor = null,
        ?string $brandEmail = null,
        ?string $brandName = null,
        ?string $brandPhoneNumber = null,
        ?string $briefCompanyDescription = null,
        ?string $companyEin = null,
        ?string $contactNameAndTitle = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $customerSupportEmail = null,
        ?string $customerSupportPhoneNumber = null,
        ?string $description = null,
        ?string $displayName = null,
        ?string $entityType = null,
        ?string $helpMessage = null,
        RcsAddress|array|null $officialAddress = null,
        ?string $optInProcessDescription = null,
        ?string $phoneNumber = null,
        ?string $privacyPolicyURL = null,
        ?string $reason = null,
        ?string $reasonCode = null,
        ?array $sampleMessages = null,
        ?string $startMessage = null,
        Status|string|null $status = null,
        ?string $stopMessage = null,
        ?string $termsAndConditionsURL = null,
        ?string $websiteURL = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $agentUseCase && $self['agentUseCase'] = $agentUseCase;
        null !== $brandColor && $self['brandColor'] = $brandColor;
        null !== $brandEmail && $self['brandEmail'] = $brandEmail;
        null !== $brandName && $self['brandName'] = $brandName;
        null !== $brandPhoneNumber && $self['brandPhoneNumber'] = $brandPhoneNumber;
        null !== $briefCompanyDescription && $self['briefCompanyDescription'] = $briefCompanyDescription;
        null !== $companyEin && $self['companyEin'] = $companyEin;
        null !== $contactNameAndTitle && $self['contactNameAndTitle'] = $contactNameAndTitle;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $customerSupportEmail && $self['customerSupportEmail'] = $customerSupportEmail;
        null !== $customerSupportPhoneNumber && $self['customerSupportPhoneNumber'] = $customerSupportPhoneNumber;
        null !== $description && $self['description'] = $description;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $officialAddress && $self['officialAddress'] = $officialAddress;
        null !== $optInProcessDescription && $self['optInProcessDescription'] = $optInProcessDescription;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $privacyPolicyURL && $self['privacyPolicyURL'] = $privacyPolicyURL;
        null !== $reason && $self['reason'] = $reason;
        null !== $reasonCode && $self['reasonCode'] = $reasonCode;
        null !== $sampleMessages && $self['sampleMessages'] = $sampleMessages;
        null !== $startMessage && $self['startMessage'] = $startMessage;
        null !== $status && $self['status'] = $status;
        null !== $stopMessage && $self['stopMessage'] = $stopMessage;
        null !== $termsAndConditionsURL && $self['termsAndConditionsURL'] = $termsAndConditionsURL;
        null !== $websiteURL && $self['websiteURL'] = $websiteURL;

        return $self;
    }

    /**
     * The agent record. Stable across the whole approval, and what support will ask for.
     *
     * Nullable and omitted when absent: a sender profile with RCS intent records the channel but has no
     * agent until the order form is submitted, so no id exists to report. A zero GUID is not a valid id
     * and is worse than the field being absent.
     */
    public function withID(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAgentUseCase(?string $agentUseCase): self
    {
        $self = clone $this;
        $self['agentUseCase'] = $agentUseCase;

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

    /**
     * Omitted when no real agent record exists — the intent-only path has no creation timestamp.
     */
    public function withCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

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
     * The number the agent sends from, derived from brand_phone_number.
     */
    public function withPhoneNumber(?string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withPrivacyPolicyURL(?string $privacyPolicyURL): self
    {
        $self = clone $this;
        $self['privacyPolicyURL'] = $privacyPolicyURL;

        return $self;
    }

    /**
     * A sentence for reason_code, saying what to do where it is yours. Omitted while ACTIVE.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the agent is not ACTIVE, as a stable code: an ErrorCodes CHANNEL_xxx value such
     * as CHANNEL_001 (something you owe) or CHANNEL_009 (under review). Switch on this rather than
     * on reason. Omitted while ACTIVE. Read-only; when nothing more specific is known it is the
     * generic reason for the status.
     */
    public function withReasonCode(?string $reasonCode): self
    {
        $self = clone $this;
        $self['reasonCode'] = $reasonCode;

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

    /**
     * Where the agent stands, in terms of who is holding it up — PROVISIONING, ACTION_NEEDED,
     * PENDING_REVIEW or ACTIVE.
     *
     * Resolved from both of the provider's axes rather than reported raw: an agent whose resubmission
     * we have asked for reads ACTION_NEEDED however its carrier status still reads, and an agent not
     * yet handed over reads PROVISIONING rather than pending a review nobody has started.
     *
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

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
