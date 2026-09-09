<?php

declare(strict_types=1);

namespace SentDm\Contacts\ContactMessageSummary;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-type ChannelScoreShape = array{
 *   channel?: string|null, failScore?: int|null, successScore?: int|null
 * }
 */
final class ChannelScore implements BaseModel
{
    /** @use SdkModel<ChannelScoreShape> */
    use SdkModel;

    #[Optional]
    public ?string $channel;

    /**
     * Percentage (0-100) of messages on this channel that ended in FAILED.
     */
    #[Optional('fail_score')]
    public ?int $failScore;

    /**
     * Percentage (0-100) of messages on this channel that reached a successful terminal state: SENT/DELIVERED/READ for outbound, RECEIVED for inbound.
     */
    #[Optional('success_score')]
    public ?int $successScore;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $channel = null,
        ?int $failScore = null,
        ?int $successScore = null
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $failScore && $self['failScore'] = $failScore;
        null !== $successScore && $self['successScore'] = $successScore;

        return $self;
    }

    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * Percentage (0-100) of messages on this channel that ended in FAILED.
     */
    public function withFailScore(int $failScore): self
    {
        $self = clone $this;
        $self['failScore'] = $failScore;

        return $self;
    }

    /**
     * Percentage (0-100) of messages on this channel that reached a successful terminal state: SENT/DELIVERED/READ for outbound, RECEIVED for inbound.
     */
    public function withSuccessScore(int $successScore): self
    {
        $self = clone $this;
        $self['successScore'] = $successScore;

        return $self;
    }
}
