<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns\TcrCampaignWithUseCases;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\Campaigns\MessagingUseCaseUs;

/**
 * @phpstan-type UseCaseShape = array{
 *   id?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   sampleMessages: list<string>,
 *   campaignID?: string|null,
 *   customerID?: string|null,
 *   messagingUseCaseUs?: null|MessagingUseCaseUs|value-of<MessagingUseCaseUs>,
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

    /** @var list<string> $sampleMessages */
    #[Required(list: 'string')]
    public array $sampleMessages;

    #[Optional('campaignId')]
    public ?string $campaignID;

    #[Optional('customerId')]
    public ?string $customerID;

    /** @var value-of<MessagingUseCaseUs>|null $messagingUseCaseUs */
    #[Optional(enum: MessagingUseCaseUs::class)]
    public ?string $messagingUseCaseUs;

    /**
     * `new UseCase()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UseCase::with(sampleMessages: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UseCase)->withSampleMessages(...)
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
     * @param list<string> $sampleMessages
     * @param MessagingUseCaseUs|value-of<MessagingUseCaseUs>|null $messagingUseCaseUs
     */
    public static function with(
        array $sampleMessages,
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $campaignID = null,
        ?string $customerID = null,
        MessagingUseCaseUs|string|null $messagingUseCaseUs = null,
    ): self {
        $self = new self;

        $self['sampleMessages'] = $sampleMessages;

        null !== $id && $self['id'] = $id;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $campaignID && $self['campaignID'] = $campaignID;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $messagingUseCaseUs && $self['messagingUseCaseUs'] = $messagingUseCaseUs;

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

    /**
     * @param list<string> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

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
}
