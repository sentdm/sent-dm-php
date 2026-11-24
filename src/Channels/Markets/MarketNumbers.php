<?php

declare(strict_types=1);

namespace SentDm\Channels\Markets;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The numbers a customer holds in one market: GET /v3/channels/{channel}/{country}/{type}/numbers.
 *
 * @phpstan-import-type MarketNumberShape from \SentDm\Channels\Markets\MarketNumber
 *
 * @phpstan-type MarketNumbersShape = array{
 *   channel?: string|null,
 *   country?: string|null,
 *   numbers?: list<MarketNumber|MarketNumberShape>|null,
 * }
 */
final class MarketNumbers implements BaseModel
{
    /** @use SdkModel<MarketNumbersShape> */
    use SdkModel;

    #[Optional]
    public ?string $channel;

    /**
     * ISO 3166-1 alpha-2, uppercase.
     */
    #[Optional]
    public ?string $country;

    /**
     * Empty, never null, when the customer holds nothing there.
     *
     * @var list<MarketNumber>|null $numbers
     */
    #[Optional(list: MarketNumber::class)]
    public ?array $numbers;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<MarketNumber|MarketNumberShape>|null $numbers
     */
    public static function with(
        ?string $channel = null,
        ?string $country = null,
        ?array $numbers = null
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $country && $self['country'] = $country;
        null !== $numbers && $self['numbers'] = $numbers;

        return $self;
    }

    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * ISO 3166-1 alpha-2, uppercase.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Empty, never null, when the customer holds nothing there.
     *
     * @param list<MarketNumber|MarketNumberShape> $numbers
     */
    public function withNumbers(array $numbers): self
    {
        $self = clone $this;
        $self['numbers'] = $numbers;

        return $self;
    }
}
