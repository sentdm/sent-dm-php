<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\Campaigns\TcrCampaignWithUseCases\SharingStatus;
use SentDm\Profiles\Campaigns\TcrCampaignWithUseCases\Status;
use SentDm\Profiles\Campaigns\TcrCampaignWithUseCases\UseCase;

/**
 * @phpstan-import-type UseCaseShape from \SentDm\Profiles\Campaigns\TcrCampaignWithUseCases\UseCase
 *
 * @phpstan-type TcrCampaignWithUseCasesShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   billedDate?: \DateTimeInterface|null,
 *   brandID?: string|null,
 *   cost?: float|null,
 *   cspID?: string|null,
 *   customerID?: string|null,
 *   dcaElectionsComplete?: bool|null,
 *   dcaElectionsCompletedAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   helpKeywords?: string|null,
 *   helpMessage?: string|null,
 *   kycSubmissionFormID?: string|null,
 *   messageFlow?: string|null,
 *   name?: string|null,
 *   optinKeywords?: string|null,
 *   optinMessage?: string|null,
 *   optoutKeywords?: string|null,
 *   optoutMessage?: string|null,
 *   privacyPolicyLink?: string|null,
 *   resellerID?: string|null,
 *   sharingStatus?: null|SharingStatus|value-of<SharingStatus>,
 *   status?: null|Status|value-of<Status>,
 *   submittedAt?: \DateTimeInterface|null,
 *   submittedToTcr?: bool|null,
 *   tcrCampaignID?: string|null,
 *   tcrSyncError?: string|null,
 *   telnyxCampaignID?: string|null,
 *   termsAndConditionsLink?: string|null,
 *   type?: string|null,
 *   upstreamCnpID?: string|null,
 *   useCases?: list<UseCase|UseCaseShape>|null,
 * }
 */
final class TcrCampaignWithUseCases implements BaseModel
{
    /** @use SdkModel<TcrCampaignWithUseCasesShape> */
    use SdkModel;

    /**
     * Unique identifier.
     */
    #[Optional]
    public ?string $id;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $billedDate;

    #[Optional('brandId', nullable: true)]
    public ?string $brandID;

    #[Optional(nullable: true)]
    public ?float $cost;

    #[Optional('cspId', nullable: true)]
    public ?string $cspID;

    #[Optional('customerId')]
    public ?string $customerID;

    #[Optional]
    public ?bool $dcaElectionsComplete;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $dcaElectionsCompletedAt;

    #[Optional]
    public ?string $description;

    #[Optional(nullable: true)]
    public ?string $helpKeywords;

    #[Optional(nullable: true)]
    public ?string $helpMessage;

    #[Optional('kycSubmissionFormId', nullable: true)]
    public ?string $kycSubmissionFormID;

    #[Optional(nullable: true)]
    public ?string $messageFlow;

    #[Optional]
    public ?string $name;

    #[Optional(nullable: true)]
    public ?string $optinKeywords;

    #[Optional(nullable: true)]
    public ?string $optinMessage;

    #[Optional(nullable: true)]
    public ?string $optoutKeywords;

    #[Optional(nullable: true)]
    public ?string $optoutMessage;

    #[Optional(nullable: true)]
    public ?string $privacyPolicyLink;

    #[Optional('resellerId', nullable: true)]
    public ?string $resellerID;

    /** @var value-of<SharingStatus>|null $sharingStatus */
    #[Optional(enum: SharingStatus::class, nullable: true)]
    public ?string $sharingStatus;

    /** @var value-of<Status>|null $status */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $submittedAt;

    #[Optional('submittedToTCR')]
    public ?bool $submittedToTcr;

    #[Optional('tcrCampaignId', nullable: true)]
    public ?string $tcrCampaignID;

    #[Optional(nullable: true)]
    public ?string $tcrSyncError;

    #[Optional('telnyxCampaignId', nullable: true)]
    public ?string $telnyxCampaignID;

    #[Optional(nullable: true)]
    public ?string $termsAndConditionsLink;

    #[Optional]
    public ?string $type;

    #[Optional('upstreamCnpId', nullable: true)]
    public ?string $upstreamCnpID;

    /** @var list<UseCase>|null $useCases */
    #[Optional(list: UseCase::class)]
    public ?array $useCases;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param SharingStatus|value-of<SharingStatus>|null $sharingStatus
     * @param Status|value-of<Status>|null $status
     * @param list<UseCase|UseCaseShape>|null $useCases
     */
    public static function with(
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?\DateTimeInterface $updatedAt = null,
        ?\DateTimeInterface $billedDate = null,
        ?string $brandID = null,
        ?float $cost = null,
        ?string $cspID = null,
        ?string $customerID = null,
        ?bool $dcaElectionsComplete = null,
        ?\DateTimeInterface $dcaElectionsCompletedAt = null,
        ?string $description = null,
        ?string $helpKeywords = null,
        ?string $helpMessage = null,
        ?string $kycSubmissionFormID = null,
        ?string $messageFlow = null,
        ?string $name = null,
        ?string $optinKeywords = null,
        ?string $optinMessage = null,
        ?string $optoutKeywords = null,
        ?string $optoutMessage = null,
        ?string $privacyPolicyLink = null,
        ?string $resellerID = null,
        SharingStatus|string|null $sharingStatus = null,
        Status|string|null $status = null,
        ?\DateTimeInterface $submittedAt = null,
        ?bool $submittedToTcr = null,
        ?string $tcrCampaignID = null,
        ?string $tcrSyncError = null,
        ?string $telnyxCampaignID = null,
        ?string $termsAndConditionsLink = null,
        ?string $type = null,
        ?string $upstreamCnpID = null,
        ?array $useCases = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $billedDate && $self['billedDate'] = $billedDate;
        null !== $brandID && $self['brandID'] = $brandID;
        null !== $cost && $self['cost'] = $cost;
        null !== $cspID && $self['cspID'] = $cspID;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $dcaElectionsComplete && $self['dcaElectionsComplete'] = $dcaElectionsComplete;
        null !== $dcaElectionsCompletedAt && $self['dcaElectionsCompletedAt'] = $dcaElectionsCompletedAt;
        null !== $description && $self['description'] = $description;
        null !== $helpKeywords && $self['helpKeywords'] = $helpKeywords;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $kycSubmissionFormID && $self['kycSubmissionFormID'] = $kycSubmissionFormID;
        null !== $messageFlow && $self['messageFlow'] = $messageFlow;
        null !== $name && $self['name'] = $name;
        null !== $optinKeywords && $self['optinKeywords'] = $optinKeywords;
        null !== $optinMessage && $self['optinMessage'] = $optinMessage;
        null !== $optoutKeywords && $self['optoutKeywords'] = $optoutKeywords;
        null !== $optoutMessage && $self['optoutMessage'] = $optoutMessage;
        null !== $privacyPolicyLink && $self['privacyPolicyLink'] = $privacyPolicyLink;
        null !== $resellerID && $self['resellerID'] = $resellerID;
        null !== $sharingStatus && $self['sharingStatus'] = $sharingStatus;
        null !== $status && $self['status'] = $status;
        null !== $submittedAt && $self['submittedAt'] = $submittedAt;
        null !== $submittedToTcr && $self['submittedToTcr'] = $submittedToTcr;
        null !== $tcrCampaignID && $self['tcrCampaignID'] = $tcrCampaignID;
        null !== $tcrSyncError && $self['tcrSyncError'] = $tcrSyncError;
        null !== $telnyxCampaignID && $self['telnyxCampaignID'] = $telnyxCampaignID;
        null !== $termsAndConditionsLink && $self['termsAndConditionsLink'] = $termsAndConditionsLink;
        null !== $type && $self['type'] = $type;
        null !== $upstreamCnpID && $self['upstreamCnpID'] = $upstreamCnpID;
        null !== $useCases && $self['useCases'] = $useCases;

        return $self;
    }

    /**
     * Unique identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withBilledDate(?\DateTimeInterface $billedDate): self
    {
        $self = clone $this;
        $self['billedDate'] = $billedDate;

        return $self;
    }

    public function withBrandID(?string $brandID): self
    {
        $self = clone $this;
        $self['brandID'] = $brandID;

        return $self;
    }

    public function withCost(?float $cost): self
    {
        $self = clone $this;
        $self['cost'] = $cost;

        return $self;
    }

    public function withCspID(?string $cspID): self
    {
        $self = clone $this;
        $self['cspID'] = $cspID;

        return $self;
    }

    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    public function withDcaElectionsComplete(bool $dcaElectionsComplete): self
    {
        $self = clone $this;
        $self['dcaElectionsComplete'] = $dcaElectionsComplete;

        return $self;
    }

    public function withDcaElectionsCompletedAt(
        ?\DateTimeInterface $dcaElectionsCompletedAt
    ): self {
        $self = clone $this;
        $self['dcaElectionsCompletedAt'] = $dcaElectionsCompletedAt;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withHelpKeywords(?string $helpKeywords): self
    {
        $self = clone $this;
        $self['helpKeywords'] = $helpKeywords;

        return $self;
    }

    public function withHelpMessage(?string $helpMessage): self
    {
        $self = clone $this;
        $self['helpMessage'] = $helpMessage;

        return $self;
    }

    public function withKYCSubmissionFormID(?string $kycSubmissionFormID): self
    {
        $self = clone $this;
        $self['kycSubmissionFormID'] = $kycSubmissionFormID;

        return $self;
    }

    public function withMessageFlow(?string $messageFlow): self
    {
        $self = clone $this;
        $self['messageFlow'] = $messageFlow;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withOptinKeywords(?string $optinKeywords): self
    {
        $self = clone $this;
        $self['optinKeywords'] = $optinKeywords;

        return $self;
    }

    public function withOptinMessage(?string $optinMessage): self
    {
        $self = clone $this;
        $self['optinMessage'] = $optinMessage;

        return $self;
    }

    public function withOptoutKeywords(?string $optoutKeywords): self
    {
        $self = clone $this;
        $self['optoutKeywords'] = $optoutKeywords;

        return $self;
    }

    public function withOptoutMessage(?string $optoutMessage): self
    {
        $self = clone $this;
        $self['optoutMessage'] = $optoutMessage;

        return $self;
    }

    public function withPrivacyPolicyLink(?string $privacyPolicyLink): self
    {
        $self = clone $this;
        $self['privacyPolicyLink'] = $privacyPolicyLink;

        return $self;
    }

    public function withResellerID(?string $resellerID): self
    {
        $self = clone $this;
        $self['resellerID'] = $resellerID;

        return $self;
    }

    /**
     * @param SharingStatus|value-of<SharingStatus>|null $sharingStatus
     */
    public function withSharingStatus(
        SharingStatus|string|null $sharingStatus
    ): self {
        $self = clone $this;
        $self['sharingStatus'] = $sharingStatus;

        return $self;
    }

    /**
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withSubmittedAt(?\DateTimeInterface $submittedAt): self
    {
        $self = clone $this;
        $self['submittedAt'] = $submittedAt;

        return $self;
    }

    public function withSubmittedToTcr(bool $submittedToTcr): self
    {
        $self = clone $this;
        $self['submittedToTcr'] = $submittedToTcr;

        return $self;
    }

    public function withTcrCampaignID(?string $tcrCampaignID): self
    {
        $self = clone $this;
        $self['tcrCampaignID'] = $tcrCampaignID;

        return $self;
    }

    public function withTcrSyncError(?string $tcrSyncError): self
    {
        $self = clone $this;
        $self['tcrSyncError'] = $tcrSyncError;

        return $self;
    }

    public function withTelnyxCampaignID(?string $telnyxCampaignID): self
    {
        $self = clone $this;
        $self['telnyxCampaignID'] = $telnyxCampaignID;

        return $self;
    }

    public function withTermsAndConditionsLink(
        ?string $termsAndConditionsLink
    ): self {
        $self = clone $this;
        $self['termsAndConditionsLink'] = $termsAndConditionsLink;

        return $self;
    }

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withUpstreamCnpID(?string $upstreamCnpID): self
    {
        $self = clone $this;
        $self['upstreamCnpID'] = $upstreamCnpID;

        return $self;
    }

    /**
     * @param list<UseCase|UseCaseShape> $useCases
     */
    public function withUseCases(array $useCases): self
    {
        $self = clone $this;
        $self['useCases'] = $useCases;

        return $self;
    }
}
