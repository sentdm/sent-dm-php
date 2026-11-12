<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc\TenDlcAddCampaignParams;

use SentDm\Channels\SMS\TenDlc\TenDlcAddCampaignParams\UseCase1\UseCase;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type UseCase1Shape = array{
 *   sampleMessages: list<mixed>, useCase: UseCase|value-of<UseCase>
 * }
 */
final class UseCase1 implements BaseModel
{
    /** @use SdkModel<UseCase1Shape> */
    use SdkModel;

    /**
     * Sample messages. TCR sample1..sample5 for this use case. One to five, each carrying the brand name and an opt-out instruction.
     *
     * @var list<mixed> $sampleMessages
     */
    #[Required('sample_messages', list: 'mixed')]
    public array $sampleMessages;

    /**
     * Use case. What this entry sends. MIXED and LOW_VOLUME are refused — volume decides those.
     *
     * @var value-of<UseCase> $useCase
     */
    #[Required('use_case', enum: UseCase::class)]
    public string $useCase;

    /**
     * `new UseCase1()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UseCase1::with(sampleMessages: ..., useCase: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UseCase1)->withSampleMessages(...)->withUseCase(...)
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
     * @param list<mixed> $sampleMessages
     * @param UseCase|value-of<UseCase> $useCase
     */
    public static function with(
        array $sampleMessages,
        UseCase|string $useCase
    ): self {
        $self = new self;

        $self['sampleMessages'] = $sampleMessages;
        $self['useCase'] = $useCase;

        return $self;
    }

    /**
     * Sample messages. TCR sample1..sample5 for this use case. One to five, each carrying the brand name and an opt-out instruction.
     *
     * @param list<mixed> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

        return $self;
    }

    /**
     * Use case. What this entry sends. MIXED and LOW_VOLUME are refused — volume decides those.
     *
     * @param UseCase|value-of<UseCase> $useCase
     */
    public function withUseCase(UseCase|string $useCase): self
    {
        $self = clone $this;
        $self['useCase'] = $useCase;

        return $self;
    }
}
