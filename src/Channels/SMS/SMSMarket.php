<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Channels\SMS\SMSMarket\Status;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One SMS market the profile sends in — its sender, where that sender stands, and what the market wants.
 *
 * A profile may send in several: it is a tenant, not a market. Each carries its own status, because
 * a profile can be live in one country and mid-registration in another — and each carries what it still owes,
 * rather than that being reported in a separate array a caller has to join on.
 *
 * @phpstan-import-type SuppliedComplianceShape from \SentDm\Channels\SMS\SuppliedCompliance
 * @phpstan-import-type SMSNumberShape from \SentDm\Channels\SMS\SMSNumber
 *
 * @phpstan-type SMSMarketShape = array{
 *   compliance?: null|SuppliedCompliance|SuppliedComplianceShape,
 *   country?: string|null,
 *   numberType?: string|null,
 *   numbers?: list<SMSNumber|SMSNumberShape>|null,
 *   reason?: string|null,
 *   reasonCode?: string|null,
 *   status?: null|Status|value-of<Status>,
 * }
 */
final class SMSMarket implements BaseModel
{
    /** @use SdkModel<SMSMarketShape> */
    use SdkModel;

    /**
     * What a market has been given: the identity it registers under, its programme, and any documents attached.
     *
     * What it does not carry is what the market asks for. That is the subject of
     * GET /v3/compliance/requirements, and it is the same answer for every caller — a description of what
     * a compliance regime wants, not a record of one customer's progress through it. It was reported here as
     * well for a while, which put the same array in six response shapes and left a caller deciding which of two
     * sources to believe.
     *
     * Present on a list read for markets that register (carrying brand and campaign), but with
     * documents absent — documents are not fetched for a list, because a catalog lookup and a document
     * read per market would multiply across a page. Absent documents is distinct from an empty list:
     * absent says they were not fetched; empty says the market has been given none. The parent object is null
     * only when the market registers with nobody and compliance was not computed — nothing to show at all.
     */
    #[Optional(nullable: true)]
    public ?SuppliedCompliance $compliance;

    #[Optional(nullable: true)]
    public ?string $country;

    #[Optional('number_type', nullable: true)]
    public ?string $numberType;

    /**
     * Every number this market holds or is still owed, each with its area code and its own status
     * (ACTIVE once it can send, PROVISIONING while it is still to be assigned, INACTIVE once
     * it could send and no longer can). One entry for a
     * market holding one number. US 10DLC numbers are assigned when the campaign is approved, so they read as
     * owed until then. Read-only.
     *
     * @var list<SMSNumber>|null $numbers
     */
    #[Optional(list: SMSNumber::class)]
    public ?array $numbers;

    /**
     * A sentence for reason_code: this market's own explanation, naming what is outstanding where that
     * is you. Omitted while ACTIVE.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * Why the market is not ACTIVE, as a stable code: an ErrorCodes CHANNEL_xxx value such
     * as CHANNEL_001 (something you owe) or CHANNEL_009 (under review). Switch on this rather than
     * on reason. Omitted while ACTIVE. Read-only; when nothing more specific is known it is the
     * generic reason for the status.
     */
    #[Optional('reason_code', nullable: true)]
    public ?string $reasonCode;

    /**
     * Where this market's sender stands, in terms of who is holding it up — PROVISIONING,
     * ACTION_NEEDED, PENDING_REVIEW or ACTIVE. Read-only.
     *
     * Resolved rather than reported raw: a live sender reads ACTIVE whatever it still owes, a
     * market with outstanding requirements or an open resubmission request reads ACTION_NEEDED, and a
     * market that registers with a regime reads PENDING_REVIEW once its brand exists — filing to The
     * Campaign Registry is ours to do and need not have happened yet, so a dedicated brand created through
     * this API reads PENDING_REVIEW from the moment it is stored.
     *
     * Describes whether the market can send, not each number: a market holding several numbers reads
     * ACTIVE as soon as one of them is, whatever the others are doing. Each number's own status is in
     * numbers.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param SuppliedCompliance|SuppliedComplianceShape|null $compliance
     * @param list<SMSNumber|SMSNumberShape>|null $numbers
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        SuppliedCompliance|array|null $compliance = null,
        ?string $country = null,
        ?string $numberType = null,
        ?array $numbers = null,
        ?string $reason = null,
        ?string $reasonCode = null,
        Status|string|null $status = null,
    ): self {
        $self = new self;

        null !== $compliance && $self['compliance'] = $compliance;
        null !== $country && $self['country'] = $country;
        null !== $numberType && $self['numberType'] = $numberType;
        null !== $numbers && $self['numbers'] = $numbers;
        null !== $reason && $self['reason'] = $reason;
        null !== $reasonCode && $self['reasonCode'] = $reasonCode;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * What a market has been given: the identity it registers under, its programme, and any documents attached.
     *
     * What it does not carry is what the market asks for. That is the subject of
     * GET /v3/compliance/requirements, and it is the same answer for every caller — a description of what
     * a compliance regime wants, not a record of one customer's progress through it. It was reported here as
     * well for a while, which put the same array in six response shapes and left a caller deciding which of two
     * sources to believe.
     *
     * Present on a list read for markets that register (carrying brand and campaign), but with
     * documents absent — documents are not fetched for a list, because a catalog lookup and a document
     * read per market would multiply across a page. Absent documents is distinct from an empty list:
     * absent says they were not fetched; empty says the market has been given none. The parent object is null
     * only when the market registers with nobody and compliance was not computed — nothing to show at all.
     *
     * @param SuppliedCompliance|SuppliedComplianceShape|null $compliance
     */
    public function withCompliance(
        SuppliedCompliance|array|null $compliance
    ): self {
        $self = clone $this;
        $self['compliance'] = $compliance;

        return $self;
    }

    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    public function withNumberType(?string $numberType): self
    {
        $self = clone $this;
        $self['numberType'] = $numberType;

        return $self;
    }

    /**
     * Every number this market holds or is still owed, each with its area code and its own status
     * (ACTIVE once it can send, PROVISIONING while it is still to be assigned, INACTIVE once
     * it could send and no longer can). One entry for a
     * market holding one number. US 10DLC numbers are assigned when the campaign is approved, so they read as
     * owed until then. Read-only.
     *
     * @param list<SMSNumber|SMSNumberShape> $numbers
     */
    public function withNumbers(array $numbers): self
    {
        $self = clone $this;
        $self['numbers'] = $numbers;

        return $self;
    }

    /**
     * A sentence for reason_code: this market's own explanation, naming what is outstanding where that
     * is you. Omitted while ACTIVE.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the market is not ACTIVE, as a stable code: an ErrorCodes CHANNEL_xxx value such
     * as CHANNEL_001 (something you owe) or CHANNEL_009 (under review). Switch on this rather than
     * on reason. Omitted while ACTIVE. Read-only; when nothing more specific is known it is the
     * generic reason for the status.
     */
    public function withReasonCode(?string $reasonCode): self
    {
        $self = clone $this;
        $self['reasonCode'] = $reasonCode;

        return $self;
    }

    /**
     * Where this market's sender stands, in terms of who is holding it up — PROVISIONING,
     * ACTION_NEEDED, PENDING_REVIEW or ACTIVE. Read-only.
     *
     * Resolved rather than reported raw: a live sender reads ACTIVE whatever it still owes, a
     * market with outstanding requirements or an open resubmission request reads ACTION_NEEDED, and a
     * market that registers with a regime reads PENDING_REVIEW once its brand exists — filing to The
     * Campaign Registry is ours to do and need not have happened yet, so a dedicated brand created through
     * this API reads PENDING_REVIEW from the moment it is stored.
     *
     * Describes whether the market can send, not each number: a market holding several numbers reads
     * ACTIVE as soon as one of them is, whatever the others are doing. Each number's own status is in
     * numbers.
     *
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
