<?php

declare(strict_types=1);

namespace SentDm\Channels\Markets;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Every number you hold in one market (country and sender type): `ACTIVE` once it can send, `PROVISIONING` while it is still to be assigned (it then has no `sender_value` yet), `INACTIVE` once it could send and no longer can. US `TEN_DLC` numbers name their `campaign_id`, and `?campaign_id=` keeps one campaign's.
 *
 * A market you do not hold is `404`. Add numbers with `POST` on the same path.
 *
 * @see SentDm\Services\Channels\MarketsService::listNumbers()
 *
 * @phpstan-type MarketListNumbersParamsShape = array{
 *   channel: string,
 *   country: string,
 *   campaignID?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class MarketListNumbersParams implements BaseModel
{
    /** @use SdkModel<MarketListNumbersParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $channel;

    #[Required]
    public string $country;

    /**
     * Only the numbers of this campaign (US TEN_DLC); all of the market's when absent.
     */
    #[Optional(nullable: true)]
    public ?string $campaignID;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new MarketListNumbersParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MarketListNumbersParams::with(channel: ..., country: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MarketListNumbersParams)->withChannel(...)->withCountry(...)
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
     */
    public static function with(
        string $channel,
        string $country,
        ?string $campaignID = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['channel'] = $channel;
        $self['country'] = $country;

        null !== $campaignID && $self['campaignID'] = $campaignID;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Only the numbers of this campaign (US TEN_DLC); all of the market's when absent.
     */
    public function withCampaignID(?string $campaignID): self
    {
        $self = clone $this;
        $self['campaignID'] = $campaignID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
