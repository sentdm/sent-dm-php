<?php

declare(strict_types=1);

namespace SentDm\Channels\Markets;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Reads one market you send in — its sender, where that sender stands, and everything its compliance holds.
 *
 * ## What `compliance` carries
 *
 * A market that registers with a compliance regime reports `brand` — the identity the registration is filed against — and `campaign`, the programme filed against it. Each carries `inherit`, saying whether it is yours or your organization's.
 *
 * `compliance.brand.vetting` is the brand's external vetting at The Campaign Registry, read-only: `score` (0-100, the figure US carriers set 10DLC throughput by), `status` (`PENDING`, `UNSCORE`, `ACTIVE`, `FAILED` or `EXPIRED`; carriers read the score of an `ACTIVE` vet only), `vetted_at` and `expires_at`. It is `null` while no vetting record is held for the brand, and `score` is `null` for a vet that has none yet. A profile on your organization's brand reads your organization's vetting.
 *
 * A market that registers with nobody has neither, so **both keys are absent** rather than null: absent says this market does not ask, where null would say it asks and you supplied nothing. It reports `documents` instead.
 *
 * `GET /v3/compliance/requirements` says what a market demands of any new customer; this says what you gave it.
 *
 * ## Writing it back
 *
 * **`PATCH` this same path**, with the `compliance` object from this response:
 *
 * ```json
 * { "compliance": { "brand": { "tax_id": "12-3456789" } } }
 * ```
 *
 * Nothing else to learn — what comes back can be sent back, an omitted key is left alone. There is no sub-resource for either half: both are singletons of the market, so both are written here.
 *
 * `GET /v3/compliance/requirements` says what a market demands of anybody; this says what you gave it.
 *
 * Send `x-profile-id` with an organization key to read one of your profiles' markets.
 *
 * @see SentDm\Services\Channels\MarketsService::retrieve()
 *
 * @phpstan-type MarketRetrieveParamsShape = array{
 *   channel: string, country: string, xProfileID?: string|null
 * }
 */
final class MarketRetrieveParams implements BaseModel
{
    /** @use SdkModel<MarketRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $channel;

    #[Required]
    public string $country;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new MarketRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MarketRetrieveParams::with(channel: ..., country: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MarketRetrieveParams)->withChannel(...)->withCountry(...)
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
        ?string $xProfileID = null
    ): self {
        $self = new self;

        $self['channel'] = $channel;
        $self['country'] = $country;

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

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
