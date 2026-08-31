<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns\CampaignUpdateResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\Campaigns\MessagingUseCaseUs;

/**
 * Customer-facing use-case representation for the public v3 campaign contract.
 * Exists for the same reason as BrandCampaignV3Response: nesting the
 * TcrCampaignUseCase database entity in a public response means any column added to
 * that table silently becomes part of the customer-facing contract. This DTO is an explicit
 * allowlist, so a new column stays invisible until it is added here on purpose.
 * This mirrors exactly the fields the entity already serialized, so it removes nothing from the
 * current response shape. It only closes the future-leak path.
 *
 * @phpstan-type UseCaseShape = array{
 *   id?: string|null,
 *   campaignID?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   customerID?: string|null,
 *   messagingUseCaseUs?: null|MessagingUseCaseUs|value-of<MessagingUseCaseUs>,
 *   sampleMessages?: list<string>|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class UseCase implements BaseModel
{
    /** @use SdkModel<UseCaseShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional('campaignId')]
    public ?string $campaignID;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional('customerId')]
    public ?string $customerID;

    /** @var value-of<MessagingUseCaseUs>|null $messagingUseCaseUs */
    #[Optional(enum: MessagingUseCaseUs::class)]
    public ?string $messagingUseCaseUs;

    /**
     * Sample messages submitted to the registry for this use case.
     *
     * @var list<string>|null $sampleMessages
     */
    #[Optional(list: 'string')]
    public ?array $sampleMessages;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MessagingUseCaseUs|value-of<MessagingUseCaseUs>|null $messagingUseCaseUs
     * @param list<string>|null $sampleMessages
     */
    public static function with(
        ?string $id = null,
        ?string $campaignID = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $customerID = null,
        MessagingUseCaseUs|string|null $messagingUseCaseUs = null,
        ?array $sampleMessages = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $campaignID && $self['campaignID'] = $campaignID;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $messagingUseCaseUs && $self['messagingUseCaseUs'] = $messagingUseCaseUs;
        null !== $sampleMessages && $self['sampleMessages'] = $sampleMessages;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCampaignID(string $campaignID): self
    {
        $self = clone $this;
        $self['campaignID'] = $campaignID;

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
     * @param MessagingUseCaseUs|value-of<MessagingUseCaseUs> $messagingUseCaseUs
     */
    public function withMessagingUseCaseUs(
        MessagingUseCaseUs|string $messagingUseCaseUs
    ): self {
        $self = clone $this;
        $self['messagingUseCaseUs'] = $messagingUseCaseUs;

        return $self;
    }

    /**
     * Sample messages submitted to the registry for this use case.
     *
     * @param list<string> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
