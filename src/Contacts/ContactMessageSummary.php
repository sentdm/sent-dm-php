<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Contacts\ContactMessageSummary\ChannelScore;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ChannelScoreShape from \SentDm\Contacts\ContactMessageSummary\ChannelScore
 *
 * @phpstan-type ContactMessageSummaryShape = array{
 *   channelScores?: list<ChannelScore|ChannelScoreShape>|null,
 *   channelsUsed?: list<string>|null,
 *   contactID?: string|null,
 *   firstMessageAt?: \DateTimeInterface|null,
 *   lastMessageAt?: \DateTimeInterface|null,
 *   messageCount?: int|null,
 * }
 */
final class ContactMessageSummary implements BaseModel
{
    /** @use SdkModel<ContactMessageSummaryShape> */
    use SdkModel;

    /** @var list<ChannelScore>|null $channelScores */
    #[Optional('channel_scores', list: ChannelScore::class)]
    public ?array $channelScores;

    /** @var list<string>|null $channelsUsed */
    #[Optional('channels_used', list: 'string')]
    public ?array $channelsUsed;

    #[Optional('contact_id')]
    public ?string $contactID;

    #[Optional('first_message_at', nullable: true)]
    public ?\DateTimeInterface $firstMessageAt;

    #[Optional('last_message_at', nullable: true)]
    public ?\DateTimeInterface $lastMessageAt;

    #[Optional('message_count')]
    public ?int $messageCount;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ChannelScore|ChannelScoreShape>|null $channelScores
     * @param list<string>|null $channelsUsed
     */
    public static function with(
        ?array $channelScores = null,
        ?array $channelsUsed = null,
        ?string $contactID = null,
        ?\DateTimeInterface $firstMessageAt = null,
        ?\DateTimeInterface $lastMessageAt = null,
        ?int $messageCount = null,
    ): self {
        $self = new self;

        null !== $channelScores && $self['channelScores'] = $channelScores;
        null !== $channelsUsed && $self['channelsUsed'] = $channelsUsed;
        null !== $contactID && $self['contactID'] = $contactID;
        null !== $firstMessageAt && $self['firstMessageAt'] = $firstMessageAt;
        null !== $lastMessageAt && $self['lastMessageAt'] = $lastMessageAt;
        null !== $messageCount && $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * @param list<ChannelScore|ChannelScoreShape> $channelScores
     */
    public function withChannelScores(array $channelScores): self
    {
        $self = clone $this;
        $self['channelScores'] = $channelScores;

        return $self;
    }

    /**
     * @param list<string> $channelsUsed
     */
    public function withChannelsUsed(array $channelsUsed): self
    {
        $self = clone $this;
        $self['channelsUsed'] = $channelsUsed;

        return $self;
    }

    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }

    public function withFirstMessageAt(
        ?\DateTimeInterface $firstMessageAt
    ): self {
        $self = clone $this;
        $self['firstMessageAt'] = $firstMessageAt;

        return $self;
    }

    public function withLastMessageAt(?\DateTimeInterface $lastMessageAt): self
    {
        $self = clone $this;
        $self['lastMessageAt'] = $lastMessageAt;

        return $self;
    }

    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }
}
