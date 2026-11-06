<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Supplies whatever this market is waiting on, and answers with the market as stored — the same shape `GET` on this path returns, so **what comes back can be sent back**.
 *
 * **A market reporting `ACTION_NEEDED` is fixed here**, whatever it is waiting on:
 *
 * | Outstanding | Send |
 * | --- | --- |
 * | a `brand` or `campaign` value (US `TEN_DLC`) | `compliance`, as below |
 * | a document, in any market | a multipart file named after the document's key |
 * | a registration sent back for correction | `compliance.brand` and/or `compliance.campaign` — the identity is accepted even once filed, and the registration goes back for review |
 * | different numbers | `numbers`, the list the market asks for from now on |
 *
 * ## Partial, at every level
 *
 * **An omitted key is left alone. An explicit `null` clears it.** Those are different requests, so `{}` changes nothing and is refused rather than silently accepted, and correcting one field does not blank the others.
 *
 * ```json
 * { "compliance": { "brand": { "contact_phone": "+12125550123" } } }
 * ```
 *
 * That leaves the campaign untouched, along with every other field of the identity.
 *
 * ## What a US `TEN_DLC` market holds
 *
 * Two halves, both singular: `brand`, the identity the registration is filed against, and `campaign`, the programme filed against it. Each carries `inherit`.
 *
 * | Body | Effect |
 * | --- | --- |
 * | `"brand": { … }` | supplies or corrects the identity, and takes one of your own |
 * | `"brand": { "inherit": true }` | runs on your organization's, giving up your own |
 * | `"brand": null` | the same thing, said the short way |
 * | `"campaign": { … }` | supplies or corrects the programme, and takes one of your own |
 * | `"campaign": { "inherit": true }` | runs on your organization's |
 * | key omitted | left exactly as it is |
 *
 * **Nothing here creates a second anything.** One identity and one campaign per market, so a write is an upsert and a replayed request lands on the row it already wrote. Sending the campaign twice does not file two registrations.
 *
 * ## Every other market
 *
 * Markets that register with no regime have neither half, so `compliance` is `400` there. Their compliance is documents, sent here as multipart.
 *
 * ## Documents
 *
 * Send `multipart/form-data` with **each file named after the compliance key it satisfies** — the key the market's `requirements` names. A file that matches no document the market asks for is `400` naming the keys that would, and a file the upload rules refuse (empty, too large, an unsupported type) is `422`. `compliance` and `numbers` may ride in the same form as text parts holding their JSON.
 *
 * ## Numbers
 *
 * `numbers` takes the list `POST /v3/channels/sms` takes, for a `LOCAL` or `TEN_DLC` market, and **replaces** what the market asks for — send the list you want, not a difference. Numbers already assigned stay; a list that leaves one of them out is `400`, because nothing here releases a number.
 *
 * ```json
 * { "numbers": [ { "area_code": "415", "quantity": 2 }, { "quantity": 1 } ] }
 * ```
 *
 * A `LOCAL` market is claimed from inventory at once, and whatever inventory cannot cover stays pending. A `TEN_DLC` market's numbers are recorded on its campaign and assigned once the carriers elect it — on the next acquisition cycle when it already has been. They need a campaign of the profile's own: one inherited from the organization is `400`.
 *
 * ## What it will refuse
 *
 * **A filed identity is `409`.** Once the registration has gone to The Campaign Registry they hold a copy, and a local change would diverge from it silently. The campaign is not frozen — omit `brand` and the same body is accepted. The exception is a registration sent back for correction: the identity is accepted, and a correction to either half sends the registration back for review. Refiling it with The Campaign Registry stays with Sent.
 *
 * **More than one campaign is `409`.** The schema permits several and an account built on the admin side may hold them; this surface writes one, and editing whichever sorted first would leave the others unmentioned and unedited.
 *
 * Nothing is submitted to a regime here. These are the rows a submission is later assembled from, which is what lets them be corrected without waiting on something externally rejectable.
 *
 * Send `x-profile-id` with an organization key to write one of your profiles' markets.
 *
 * @see SentDm\Services\Channels\SMSService::update()
 *
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 *
 * @phpstan-type SMSUpdateParamsShape = array{
 *   country: string,
 *   compliance?: null|MarketCompliance|MarketComplianceShape,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class SMSUpdateParams implements BaseModel
{
    /** @use SdkModel<SMSUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

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
     * `new SMSUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SMSUpdateParams::with(country: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SMSUpdateParams)->withCountry(...)
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
        string $country,
        MarketCompliance|array|null $compliance = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['country'] = $country;

        null !== $compliance && $self['compliance'] = $compliance;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
