<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc;

use SentDm\Channels\SMS\MarketCompliance;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Registers **a new campaign** on the US `TEN_DLC` market you already hold — the one market that registers campaigns. Use it when you want numbers for a different use case than the market's existing campaign covers. The campaign is filed under the brand the market files under — your organization's when you inherit its identity.
 *
 * ## What to send
 *
 * The new campaign's fields, at the top level of the body: use cases, consent narrative, volume, sample messages and keywords, under the `compliance.campaign.*` keys `GET /v3/compliance/requirements?country=US&type=TEN_DLC` lists, without that prefix. It has to be complete. A rejected field is keyed by its name (`description`). `id` and `inherit` are ignored, so an entry of `compliance.campaigns` can be sent as read.
 *
 * The identity is the market's and is not sent here. A market whose identity has no registration yet, or one not yet submitted for review, is `400`.
 *
 * ## What happens
 *
 * The campaign is recorded and goes for review; it is not filed with The Campaign Registry by this call. **It comes without numbers**: send its `id` from `compliance.campaigns` to `POST /v3/channels/sms/numbers/US/TEN_DLC` to give it some. **The campaign you already have, and its numbers, are not touched** — including a campaign you run on from your organization.
 *
 * **Each call files a new campaign**, which is charged when it is submitted. Send an `Idempotency-Key` so a retried request does not file a second one.
 *
 * To change the campaign a market already has, use `PATCH /v3/channels/sms/US/TEN_DLC`. Once a market holds more than one campaign, that `PATCH` refuses a campaign or numbers change (`409`) rather than guess which campaign is meant; numbers are added to a named campaign with `POST /v3/channels/sms/numbers/US/TEN_DLC`.
 *
 * Returns **the market**, in the shape `GET /v3/channels/sms/US/TEN_DLC` returns, with `202`.
 *
 * @see SentDm\Services\Channels\SMS\TenDlcService::addCampaign()
 *
 * @phpstan-import-type MarketComplianceShape from \SentDm\Channels\SMS\MarketCompliance
 *
 * @phpstan-type TenDlcAddCampaignParamsShape = array{
 *   compliance?: null|MarketCompliance|MarketComplianceShape,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class TenDlcAddCampaignParams implements BaseModel
{
    /** @use SdkModel<TenDlcAddCampaignParamsShape> */
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
