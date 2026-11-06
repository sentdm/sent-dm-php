<?php

declare(strict_types=1);

namespace SentDm\Channels;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One market the profile can send MMS in.
 *
 * Deliberately not SmsMarketState: an MMS market carries no compliance of its own. It
 * is the same number, carrier and registration as the SMS market on it in that country — MMS files nothing
 * separately — so a compliance block here would always be null and would invite the question of
 * what an MMS market owes. It owes what the SMS market owes, reported there.
 *
 * @phpstan-type MmsMarketShape = array{
 *   country?: string|null,
 *   numberType?: string|null,
 *   senderValue?: string|null,
 *   status?: string|null,
 * }
 */
final class MmsMarket implements BaseModel
{
    /** @use SdkModel<MmsMarketShape> */
    use SdkModel;

    /**
     * ISO-3166 alpha-2 of the market.
     */
    #[Optional(nullable: true)]
    public ?string $country;

    /**
     * The sender type the market sends from, mirroring the SMS sender.
     */
    #[Optional('number_type', nullable: true)]
    public ?string $numberType;

    /**
     * The sending number. Null while the market is still being provisioned.
     */
    #[Optional('sender_value', nullable: true)]
    public ?string $senderValue;

    /**
     * Where this market's MMS sender stands. Read-only.
     */
    #[Optional(nullable: true)]
    public ?string $status;

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
        ?string $country = null,
        ?string $numberType = null,
        ?string $senderValue = null,
        ?string $status = null,
    ): self {
        $self = new self;

        null !== $country && $self['country'] = $country;
        null !== $numberType && $self['numberType'] = $numberType;
        null !== $senderValue && $self['senderValue'] = $senderValue;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * ISO-3166 alpha-2 of the market.
     */
    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * The sender type the market sends from, mirroring the SMS sender.
     */
    public function withNumberType(?string $numberType): self
    {
        $self = clone $this;
        $self['numberType'] = $numberType;

        return $self;
    }

    /**
     * The sending number. Null while the market is still being provisioned.
     */
    public function withSenderValue(?string $senderValue): self
    {
        $self = clone $this;
        $self['senderValue'] = $senderValue;

        return $self;
    }

    /**
     * Where this market's MMS sender stands. Read-only.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
