<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageSendParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One entry of a channel's list in Channels, e.g.
 * {"country": "US", "from": ["+15559990002", "+15559990003"], "strategy": "sticky"}.
 *
 * @phpstan-type ChannelShape = array{
 *   country?: string|null, from?: list<string>|null, strategy?: string|null
 * }
 */
final class Channel implements BaseModel
{
    /** @use SdkModel<ChannelShape> */
    use SdkModel;

    /**
     * Recipient country this entry is meant for (ISO 3166-1 alpha-2, e.g. US). Optional. Accepted
     * and stored, not acted on yet.
     */
    #[Optional(nullable: true)]
    public ?string $country;

    /**
     * Sender numbers in E.164. Each must be an active sender on your account for this channel. That is
     * account state rather than request shape, so it is decided per message: the request is accepted
     * with 202 and a message naming an unusable number is recorded BLOCKED with error code
     * BUSINESS_029.
     *
     * @var list<string>|null $from
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $from;

    /**
     * How to pick a number from From, e.g. sticky or geo. Optional. Accepted
     * and stored, not acted on yet.
     */
    #[Optional(nullable: true)]
    public ?string $strategy;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $from
     */
    public static function with(
        ?string $country = null,
        ?array $from = null,
        ?string $strategy = null
    ): self {
        $self = new self;

        null !== $country && $self['country'] = $country;
        null !== $from && $self['from'] = $from;
        null !== $strategy && $self['strategy'] = $strategy;

        return $self;
    }

    /**
     * Recipient country this entry is meant for (ISO 3166-1 alpha-2, e.g. US). Optional. Accepted
     * and stored, not acted on yet.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Sender numbers in E.164. Each must be an active sender on your account for this channel. That is
     * account state rather than request shape, so it is decided per message: the request is accepted
     * with 202 and a message naming an unusable number is recorded BLOCKED with error code
     * BUSINESS_029.
     *
     * @param list<string>|null $from
     */
    public function withFrom(?array $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * How to pick a number from From, e.g. sticky or geo. Optional. Accepted
     * and stored, not acted on yet.
     */
    public function withStrategy(?string $strategy): self
    {
        $self = clone $this;
        $self['strategy'] = $strategy;

        return $self;
    }
}
