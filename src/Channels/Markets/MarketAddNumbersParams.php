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
 * Adds numbers to a market you hold. They are **added** to what it already asks for, never replacing it — with one exception: a US `TEN_DLC` campaign opened without `numbers` asks for one number in any area code by default, and while it holds no number yet, the first numbers added replace that default. Once it holds one, they are added beside it.
 *
 * ## Where they go
 *
 * - **SMS US `TEN_DLC`**: to **one campaign of your own**, named by `campaign_id` — the `id` of an entry in the market's `compliance.campaigns` (`GET /v3/channels/sms/US/TEN_DLC`). Required: left out it is `400` naming your campaigns in service. One you inherit from your organization is `400`: its numbers are the organization's. One out of service — expired, deactivated or released — is `409`. A campaign the carriers have not approved yet gets its numbers when they do; an approved one gets them now. With everything it asks for, a campaign holds at most 49 numbers, counting one for each sender profile inheriting it.
 * - **`LOCAL`**: to the market, claimed from inventory now; what inventory cannot cover stays pending. No `campaign_id`. A market holds at most 49 numbers.
 * - **Any other sender type** takes no numbers: `400`.
 *
 * ## What to send
 *
 * `numbers` — the list `POST /v3/channels/sms` takes, one entry per area code — and, on US `TEN_DLC`, `campaign_id`, required.
 *
 * Until a number is assigned it reads as `PROVISIONING` in the market's `numbers`, with the area code it was asked for. Returns **the market**, in the shape `GET /v3/channels/sms/{country}/{type}` returns, with `202`.
 *
 * @see SentDm\Services\Channels\MarketsService::addNumbers()
 *
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 *
 * @phpstan-type MarketAddNumbersParamsShape = array{
 *   channel: string,
 *   country: string,
 *   numbers: list<null|SMSNumberRequest|SMSNumberRequestShape>,
 *   idempotencyKey: string,
 *   campaignID?: string|null,
 *   sandbox?: bool|null,
 *   xProfileID?: string|null,
 * }
 */
final class MarketAddNumbersParams implements BaseModel
{
    /** @use SdkModel<MarketAddNumbersParamsShape> */
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

    #[Required]
    public string $idempotencyKey;

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
    public ?string $xProfileID;

    /**
     * `new MarketAddNumbersParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MarketAddNumbersParams::with(
     *   channel: ..., country: ..., numbers: ..., idempotencyKey: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MarketAddNumbersParams)
     *   ->withChannel(...)
     *   ->withCountry(...)
     *   ->withNumbers(...)
     *   ->withIdempotencyKey(...)
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
        string $idempotencyKey,
        ?string $campaignID = null,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['channel'] = $channel;
        $self['country'] = $country;
        $self['numbers'] = $numbers;
        $self['idempotencyKey'] = $idempotencyKey;

        null !== $campaignID && $self['campaignID'] = $campaignID;
        null !== $sandbox && $self['sandbox'] = $sandbox;
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

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

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

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
