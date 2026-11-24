<?php

declare(strict_types=1);

namespace SentDm\Channels\Markets;

use SentDm\Channels\SMS\SMSNumberRequest;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;

/**
 * Replaces the numbers a market you hold asks for — their area codes and counts — with the list you send. To add to them instead, use `POST` on this path.
 *
 * ## Whose numbers
 *
 * - **SMS US `TEN_DLC`**: **one campaign of your own**, named by `campaign_id` — the `id` of an entry in the market's `compliance.campaigns`. Required. So a campaign sent back for correction can change its area codes without being recreated. One you inherit from your organization is `400`; one out of service is `409`. With everything it asks for, a campaign holds at most 49 numbers, counting one for each sender profile inheriting it.
 * - **`LOCAL`**: the market's own, claimed from inventory now; what inventory cannot cover stays pending. No `campaign_id`.
 * - **Any other sender type** takes no numbers: `400`.
 *
 * ## What to send
 *
 * `numbers` — the list `POST /v3/channels/sms` takes, one entry per area code, an entry without `area_code` meaning any — and, on US `TEN_DLC`, `campaign_id`.
 *
 * **Numbers already assigned are kept.** Nothing is released here, so a list that no longer covers a number already held is `400`, naming how many it leaves out. Lowering a count nothing has filled yet is fine.
 *
 * Until a number is assigned it reads as `PROVISIONING` in the market's `numbers`, with the area code it was asked for. Returns **the market**, in the shape `GET /v3/channels/sms/{country}/{type}` returns.
 *
 * @see SentDm\Services\Channels\MarketsService::replaceNumbers()
 *
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 *
 * @phpstan-type MarketReplaceNumbersParamsShape = array{
 *   channel: string,
 *   country: string,
 *   numbers: list<null|SMSNumberRequest|SMSNumberRequestShape>,
 *   campaignID?: string|null,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class MarketReplaceNumbersParams implements BaseModel
{
    /** @use SdkModel<MarketReplaceNumbersParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $channel;

    #[Required]
    public string $country;

    /**
     * The numbers, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * POST adds them to what the market or campaign already asks for; PATCH replaces that list
     * with them, and has to cover every number already held, since none is ever released.
     *
     * @var list<SMSNumberRequest|null> $numbers
     */
    #[Required(type: new ListOf(SMSNumberRequest::class, nullable: true))]
    public array $numbers;

    /**
     * The campaign to add the numbers to, as campaigns[].id reports it. Required on SMS US TEN_DLC,
     * where every number belongs to a campaign; refused on a market without campaigns.
     */
    #[Optional('campaign_id', nullable: true)]
    public ?string $campaignID;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    /**
     * `new MarketReplaceNumbersParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MarketReplaceNumbersParams::with(channel: ..., country: ..., numbers: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MarketReplaceNumbersParams)
     *   ->withChannel(...)
     *   ->withCountry(...)
     *   ->withNumbers(...)
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
     * @param list<SMSNumberRequest|SMSNumberRequestShape|null> $numbers
     */
    public static function with(
        string $channel,
        string $country,
        array $numbers,
        ?string $campaignID = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['channel'] = $channel;
        $self['country'] = $country;
        $self['numbers'] = $numbers;

        null !== $campaignID && $self['campaignID'] = $campaignID;
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
     * The numbers, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * POST adds them to what the market or campaign already asks for; PATCH replaces that list
     * with them, and has to cover every number already held, since none is ever released.
     *
     * @param list<SMSNumberRequest|SMSNumberRequestShape|null> $numbers
     */
    public function withNumbers(array $numbers): self
    {
        $self = clone $this;
        $self['numbers'] = $numbers;

        return $self;
    }

    /**
     * The campaign to add the numbers to, as campaigns[].id reports it. Required on SMS US TEN_DLC,
     * where every number belongs to a campaign; refused on a market without campaigns.
     */
    public function withCampaignID(?string $campaignID): self
    {
        $self = clone $this;
        $self['campaignID'] = $campaignID;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
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
