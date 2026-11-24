<?php

declare(strict_types=1);

namespace SentDm\Channels\Markets;

use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Supplies the market's identity and documents, and answers with the market as stored — the same shape `GET` on this path returns.
 *
 * | To change | Send |
 * | --- | --- |
 * | a `brand` value (US `TEN_DLC`) | `compliance.brand`, as below |
 * | a registration sent back for correction | `compliance.brand` — the identity is accepted even once filed, and the registration goes back for review |
 * | a document, in any market | a multipart file named after the document's key |
 * | a campaign | `PATCH /v3/channels/sms/US/TEN_DLC/campaigns/{id}` — `compliance.campaign` here is `400` |
 * | the numbers | `POST /v3/channels/{channel}/{country}/{type}/numbers` — `numbers` here is `400` |
 *
 * ## Partial, at every level
 *
 * **An omitted key is left alone. An explicit `null` clears it.** Those are different requests, so `{}` changes nothing and is refused rather than silently accepted, and correcting one field does not blank the others.
 *
 * ```json
 * { "compliance": { "brand": { "contact_phone": "+12125550123" } } }
 * ```
 *
 * | Body | Effect |
 * | --- | --- |
 * | `"brand": { … }` | supplies or corrects the identity, and takes one of your own |
 * | `"brand": { "inherit": true }` | runs on your organization's, giving up your own |
 * | `"brand": null` | the same thing, said the short way |
 * | key omitted | left exactly as it is |
 *
 * The brand read on this path, its `id` and `vetting` included, can be sent back unchanged: both are read-only and ignored.
 *
 * ## Every other market
 *
 * Markets that register with no regime have no brand, so `compliance` is `400` there. Their compliance is documents, sent here as multipart.
 *
 * ## Documents
 *
 * Send `multipart/form-data` with **each file named after the compliance key it satisfies** — the key `GET /v3/channels/{channel}/{country}/compliance` lists. A file that matches no document the market asks for is `400` naming the keys that would, and a file the upload rules refuse (empty, too large, an unsupported type) is `422`. `compliance` may ride in the same form as a text part holding its JSON.
 *
 * ## What it will refuse
 *
 * **A filed identity is `409`.** Once the registration has gone to The Campaign Registry they hold a copy, and a local change would diverge from it silently. The exception is a registration sent back for correction: the identity is accepted, and the registration goes back for review. Refiling it with The Campaign Registry stays with Sent.
 *
 * Nothing is submitted to a regime here. Send `x-profile-id` with an organization key to write one of your profiles' markets.
 *
 * @see SentDm\Services\Channels\MarketsService::update()
 *
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 *
 * @phpstan-type MarketUpdateParamsShape = array{
 *   channel: string,
 *   country: string,
 *   compliance?: null|MarketCompliance|MarketComplianceShape,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class MarketUpdateParams implements BaseModel
{
    /** @use SdkModel<MarketUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $channel;

    #[Required]
    public string $country;

    /**
     * The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     */
    #[Optional]
    public ?MarketCompliance $compliance;

    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new MarketUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MarketUpdateParams::with(channel: ..., country: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MarketUpdateParams)->withChannel(...)->withCountry(...)
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
     * @param MarketCompliance|MarketComplianceShape|null $compliance
     */
    public static function with(
        string $channel,
        string $country,
        MarketCompliance|array|null $compliance = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['channel'] = $channel;
        $self['country'] = $country;

        null !== $compliance && $self['compliance'] = $compliance;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
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
     * The compliance values a market registers with. `brand` and `campaign` apply to US `TEN_DLC`; other markets fill this map with the document keys their own requirements name.
     *
     * @param MarketCompliance|MarketComplianceShape $compliance
     */
    public function withCompliance(MarketCompliance|array $compliance): self
    {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
