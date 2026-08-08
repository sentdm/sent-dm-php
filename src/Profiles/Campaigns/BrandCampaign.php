<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\Campaigns\BrandCampaign\Status;

/**
 * A 10DLC campaign registered for a brand.
 *
 * @phpstan-import-type CampaignUseCaseShape from \SentDm\Profiles\Campaigns\CampaignUseCase
 *
 * @phpstan-type BrandCampaignShape = array{
 *   id?: string|null,
 *   billedDate?: \DateTimeInterface|null,
 *   brandID?: string|null,
 *   cost?: float|null,
 *   createdAt?: \DateTimeInterface|null,
 *   customerID?: string|null,
 *   dcaElectionsComplete?: bool|null,
 *   dcaElectionsCompletedAt?: \DateTimeInterface|null,
 *   description?: string|null,
 *   hasSubmissionTransaction?: bool|null,
 *   helpKeywords?: string|null,
 *   helpMessage?: string|null,
 *   messageFlow?: string|null,
 *   name?: string|null,
 *   optinKeywords?: string|null,
 *   optinMessage?: string|null,
 *   optoutKeywords?: string|null,
 *   optoutMessage?: string|null,
 *   privacyPolicyLink?: string|null,
 *   status?: null|Status|value-of<Status>,
 *   submittedAt?: \DateTimeInterface|null,
 *   submittedToTcr?: bool|null,
 *   tcrCampaignID?: string|null,
 *   tcrSyncError?: string|null,
 *   termsAndConditionsLink?: string|null,
 *   type?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   useCases?: list<CampaignUseCase|CampaignUseCaseShape>|null,
 *   volume?: string|null,
 * }
 */
final class BrandCampaign implements BaseModel
{
    /** @use SdkModel<BrandCampaignShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $billedDate;

    #[Optional('brandId', nullable: true)]
    public ?string $brandID;

    #[Optional(nullable: true)]
    public ?float $cost;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional('customerId')]
    public ?string $customerID;

    /**
     * True once every carrier has completed its DCA election and the campaign is
     * operationally ready for traffic.
     */
    #[Optional(nullable: true)]
    public ?bool $dcaElectionsComplete;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $dcaElectionsCompletedAt;

    #[Optional]
    public ?string $description;

    /**
     * True when the one-time campaign submission fee has already been charged.
     */
    #[Optional]
    public ?bool $hasSubmissionTransaction;

    #[Optional(nullable: true)]
    public ?string $helpKeywords;

    #[Optional(nullable: true)]
    public ?string $helpMessage;

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

    /** @var value-of<Status>|null $status */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $submittedAt;

    #[Optional('submittedToTCR')]
    public ?bool $submittedToTcr;

    /**
     * The Campaign Registry identifier, once the campaign has been accepted.
     */
    #[Optional('tcrCampaignId', nullable: true)]
    public ?string $tcrCampaignID;

    /**
     * Surfaced so customers can see why a submission did not reach the registry.
     */
    #[Optional(nullable: true)]
    public ?string $tcrSyncError;

    #[Optional(nullable: true)]
    public ?string $termsAndConditionsLink;

    /**
     * Campaign type (for example KYC or App).
     */
    #[Optional]
    public ?string $type;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    /** @var list<CampaignUseCase>|null $useCases */
    #[Optional(list: CampaignUseCase::class)]
    public ?array $useCases;

    /**
     * Expected messaging volume for this campaign — customer-supplied on create/update, and the
     *             input to both the TCR usecase classification (LOW_VOLUME vs MIXED/specific) and the campaign fee
     *             tier. Surfaced so customers can read back the value they set.
     */
    #[Optional(nullable: true)]
    public ?string $volume;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Status|value-of<Status>|null $status
     * @param list<CampaignUseCase|CampaignUseCaseShape>|null $useCases
     */
    public static function with(
        ?string $id = null,
        ?\DateTimeInterface $billedDate = null,
        ?string $brandID = null,
        ?float $cost = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $customerID = null,
        ?bool $dcaElectionsComplete = null,
        ?\DateTimeInterface $dcaElectionsCompletedAt = null,
        ?string $description = null,
        ?bool $hasSubmissionTransaction = null,
        ?string $helpKeywords = null,
        ?string $helpMessage = null,
        ?string $messageFlow = null,
        ?string $name = null,
        ?string $optinKeywords = null,
        ?string $optinMessage = null,
        ?string $optoutKeywords = null,
        ?string $optoutMessage = null,
        ?string $privacyPolicyLink = null,
        Status|string|null $status = null,
        ?\DateTimeInterface $submittedAt = null,
        ?bool $submittedToTcr = null,
        ?string $tcrCampaignID = null,
        ?string $tcrSyncError = null,
        ?string $termsAndConditionsLink = null,
        ?string $type = null,
        ?\DateTimeInterface $updatedAt = null,
        ?array $useCases = null,
        ?string $volume = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $billedDate && $self['billedDate'] = $billedDate;
        null !== $brandID && $self['brandID'] = $brandID;
        null !== $cost && $self['cost'] = $cost;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $dcaElectionsComplete && $self['dcaElectionsComplete'] = $dcaElectionsComplete;
        null !== $dcaElectionsCompletedAt && $self['dcaElectionsCompletedAt'] = $dcaElectionsCompletedAt;
        null !== $description && $self['description'] = $description;
        null !== $hasSubmissionTransaction && $self['hasSubmissionTransaction'] = $hasSubmissionTransaction;
        null !== $helpKeywords && $self['helpKeywords'] = $helpKeywords;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $messageFlow && $self['messageFlow'] = $messageFlow;
        null !== $name && $self['name'] = $name;
        null !== $optinKeywords && $self['optinKeywords'] = $optinKeywords;
        null !== $optinMessage && $self['optinMessage'] = $optinMessage;
        null !== $optoutKeywords && $self['optoutKeywords'] = $optoutKeywords;
        null !== $optoutMessage && $self['optoutMessage'] = $optoutMessage;
        null !== $privacyPolicyLink && $self['privacyPolicyLink'] = $privacyPolicyLink;
        null !== $status && $self['status'] = $status;
        null !== $submittedAt && $self['submittedAt'] = $submittedAt;
        null !== $submittedToTcr && $self['submittedToTcr'] = $submittedToTcr;
        null !== $tcrCampaignID && $self['tcrCampaignID'] = $tcrCampaignID;
        null !== $tcrSyncError && $self['tcrSyncError'] = $tcrSyncError;
        null !== $termsAndConditionsLink && $self['termsAndConditionsLink'] = $termsAndConditionsLink;
        null !== $type && $self['type'] = $type;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $useCases && $self['useCases'] = $useCases;
        null !== $volume && $self['volume'] = $volume;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    /**
     * True once every carrier has completed its DCA election and the campaign is
     * operationally ready for traffic.
     */
    public function withDcaElectionsComplete(?bool $dcaElectionsComplete): self
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

    /**
     * True when the one-time campaign submission fee has already been charged.
     */
    public function withHasSubmissionTransaction(
        bool $hasSubmissionTransaction
    ): self {
        $self = clone $this;
        $self['hasSubmissionTransaction'] = $hasSubmissionTransaction;

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

    /**
     * The Campaign Registry identifier, once the campaign has been accepted.
     */
    public function withTcrCampaignID(?string $tcrCampaignID): self
    {
        $self = clone $this;
        $self['tcrCampaignID'] = $tcrCampaignID;

        return $self;
    }

    /**
     * Surfaced so customers can see why a submission did not reach the registry.
     */
    public function withTcrSyncError(?string $tcrSyncError): self
    {
        $self = clone $this;
        $self['tcrSyncError'] = $tcrSyncError;

        return $self;
    }

    public function withTermsAndConditionsLink(
        ?string $termsAndConditionsLink
    ): self {
        $self = clone $this;
        $self['termsAndConditionsLink'] = $termsAndConditionsLink;

        return $self;
    }

    /**
     * Campaign type (for example KYC or App).
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * @param list<CampaignUseCase|CampaignUseCaseShape> $useCases
     */
    public function withUseCases(array $useCases): self
    {
        $self = clone $this;
        $self['useCases'] = $useCases;

        return $self;
    }

    /**
     * Expected messaging volume for this campaign — customer-supplied on create/update, and the
     *             input to both the TCR usecase classification (LOW_VOLUME vs MIXED/specific) and the campaign fee
     *             tier. Surfaced so customers can read back the value they set.
     */
    public function withVolume(?string $volume): self
    {
        $self = clone $this;
        $self['volume'] = $volume;

        return $self;
    }
}
