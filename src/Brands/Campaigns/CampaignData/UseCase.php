<?php

declare(strict_types=1);

namespace SentDm\Brands\Campaigns\CampaignData;

use SentDm\Brands\Campaigns\MessagingUseCaseUs;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Campaign use case with sample messages.
 *
 * @phpstan-type UseCaseShape = array{
 *   messagingUseCaseUs: MessagingUseCaseUs|value-of<MessagingUseCaseUs>,
 *   sampleMessages: list<string>,
 * }
 */
final class UseCase implements BaseModel
{
    /** @use SdkModel<UseCaseShape> */
    use SdkModel;

    /**
     * US messaging use case category.
     *
     * @var value-of<MessagingUseCaseUs> $messagingUseCaseUs
     */
    #[Required(enum: MessagingUseCaseUs::class)]
    public string $messagingUseCaseUs;

    /**
     * Sample messages for this use case (1-5 messages, max 1024 characters each).
     *
     * @var list<string> $sampleMessages
     */
    #[Required(list: 'string')]
    public array $sampleMessages;

    /**
     * `new UseCase()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UseCase::with(messagingUseCaseUs: ..., sampleMessages: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UseCase)->withMessagingUseCaseUs(...)->withSampleMessages(...)
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
     * @param MessagingUseCaseUs|value-of<MessagingUseCaseUs> $messagingUseCaseUs
     * @param list<string> $sampleMessages
     */
    public static function with(
        MessagingUseCaseUs|string $messagingUseCaseUs,
        array $sampleMessages
    ): self {
        $self = new self;

        $self['messagingUseCaseUs'] = $messagingUseCaseUs;
        $self['sampleMessages'] = $sampleMessages;

        return $self;
    }

    /**
     * US messaging use case category.
     *
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
     * Sample messages for this use case (1-5 messages, max 1024 characters each).
     *
     * @param list<string> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

        return $self;
    }
}
