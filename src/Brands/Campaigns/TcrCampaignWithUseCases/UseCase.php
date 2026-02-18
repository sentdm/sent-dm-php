<?php

declare(strict_types=1);

namespace SentDm\Brands\Campaigns\TcrCampaignWithUseCases;

use SentDm\Brands\Campaigns\MessagingUseCaseUs;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type UseCaseShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   campaignID?: string|null,
 *   customerID?: string|null,
 *   messagingUseCaseUs?: null|MessagingUseCaseUs|value-of<MessagingUseCaseUs>,
 *   sampleMessages?: list<string>|null,
 * }
 */
final class UseCase implements BaseModel
{
    /** @use SdkModel<UseCaseShape> */
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

    #[Optional('campaignId')]
    public ?string $campaignID;

    #[Optional('customerId')]
    public ?string $customerID;

    /** @var value-of<MessagingUseCaseUs>|null $messagingUseCaseUs */
    #[Optional(enum: MessagingUseCaseUs::class)]
    public ?string $messagingUseCaseUs;

    /** @var list<string>|null $sampleMessages */
    #[Optional(list: 'string')]
    public ?array $sampleMessages;

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
        ?\DateTimeInterface $createdAt = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $campaignID = null,
        ?string $customerID = null,
        MessagingUseCaseUs|string|null $messagingUseCaseUs = null,
        ?array $sampleMessages = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $campaignID && $self['campaignID'] = $campaignID;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $messagingUseCaseUs && $self['messagingUseCaseUs'] = $messagingUseCaseUs;
        null !== $sampleMessages && $self['sampleMessages'] = $sampleMessages;

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

    public function withCampaignID(string $campaignID): self
    {
        $self = clone $this;
        $self['campaignID'] = $campaignID;

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
     * @param list<string> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

        return $self;
    }
}
