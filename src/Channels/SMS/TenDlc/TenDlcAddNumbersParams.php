<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc;

use SentDm\Channels\SMS\SMSNumberRequest;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;

/**
 * Adds numbers to **one campaign of your own** on the US `TEN_DLC` market you hold, named by `campaign_id` — the `id` of an entry in the market's `compliance.campaigns`.
 *
 * ## What to send
 *
 * - `campaign_id` — the campaign. One you inherit from your organization is `400`: its numbers are the organization's. One out of service — expired, deactivated or released — is `409`.
 * - `numbers` — the list `POST /v3/channels/sms` takes, one entry per area code.
 *
 * ## What happens
 *
 * The entries are **added** to what the campaign already asks for. With everything it asks for, a campaign holds at most 49 numbers, counting one for each sender profile inheriting it. A campaign the carriers have not approved yet gets its numbers when they do; an approved one gets them now. Until a number is assigned it reads as `PROVISIONING` in the market's `numbers`, with the area code it was asked for.
 *
 * Returns **the market**, in the shape `GET /v3/channels/sms/US/TEN_DLC` returns, with `202`.
 *
 * @see SentDm\Services\Channels\SMS\TenDlcService::addNumbers()
 *
 * @phpstan-import-type SMSNumberRequestShape from \SentDm\Channels\SMS\SMSNumberRequest
 *
 * @phpstan-type TenDlcAddNumbersParamsShape = array{
 *   campaignID: string,
 *   numbers: list<null|SMSNumberRequest|SMSNumberRequestShape>,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class TenDlcAddNumbersParams implements BaseModel
{
    /** @use SdkModel<TenDlcAddNumbersParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The campaign to add the numbers to, as compliance.campaigns[].id reports it. Required.
     */
    #[Required('campaign_id')]
    public string $campaignID;

    /**
     * The numbers to add, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * Added to what the campaign already asks for, never replacing it.
     *
     * @var list<SMSNumberRequest|null> $numbers
     */
    #[Required(type: new ListOf(SMSNumberRequest::class, nullable: true))]
    public array $numbers;

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
     * `new TenDlcAddNumbersParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TenDlcAddNumbersParams::with(campaignID: ..., numbers: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TenDlcAddNumbersParams)->withCampaignID(...)->withNumbers(...)
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
        string $campaignID,
        array $numbers,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        $self['campaignID'] = $campaignID;
        $self['numbers'] = $numbers;

        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * The campaign to add the numbers to, as compliance.campaigns[].id reports it. Required.
     */
    public function withCampaignID(string $campaignID): self
    {
        $self = clone $this;
        $self['campaignID'] = $campaignID;

        return $self;
    }

    /**
     * The numbers to add, one entry per area code, e.g. [{"area_code": "415", "quantity": 2}, {"quantity": 1}].
     * quantity defaults to 1, and an entry without area_code means any area code. Required.
     *
     * Added to what the campaign already asks for, never replacing it.
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
