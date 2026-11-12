<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc;

use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Changes **one campaign of your own** on the US `TEN_DLC` market, named by its `id` in the market's `compliance.campaigns`.
 *
 * ## What to send
 *
 * The fields to change, at the top level of the body, under the `compliance.campaign.*` keys `GET /v3/compliance/requirements?country=US&type=TEN_DLC` lists, without that prefix. A field you leave out keeps its value, and a rejected one is keyed by its name. `id` and `"inherit": false` are ignored, so an entry of `compliance.campaigns` can be sent as read; `"inherit": true` is `400`, because this call changes a campaign's fields, not whose campaign you run on. The campaign only: add numbers with `POST /v3/channels/sms/numbers/US/TEN_DLC`, and change the brand or documents with `PATCH /v3/channels/sms/US/TEN_DLC`.
 *
 * ## When it can be changed
 *
 * Until it is filed with The Campaign Registry, and again when we ask you to correct it. That correction sends it back for review. A filed campaign is otherwise `409`, and so is a change between low and high volume once it is registered. A campaign you run on from your organization is `409` too: it is the organization's to change. So is one out of service: expired, deactivated or released.
 *
 * Returns **the market**, in the shape `GET /v3/channels/sms/US/TEN_DLC` returns.
 *
 * @see SentDm\Services\Channels\SMS\TenDlcService::updateCampaign()
 *
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 *
 * @phpstan-type TenDlcUpdateCampaignParamsShape = array{
 *   compliance?: null|MarketCompliance|MarketComplianceShape,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class TenDlcUpdateCampaignParams implements BaseModel
{
    /** @use SdkModel<TenDlcUpdateCampaignParamsShape> */
    use SdkModel;
    use SdkParams;

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
        MarketCompliance|array|null $compliance = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $compliance && $self['compliance'] = $compliance;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
