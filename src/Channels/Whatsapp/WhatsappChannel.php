<?php

declare(strict_types=1);

namespace SentDm\Channels\Whatsapp;

use SentDm\Channels\Whatsapp\WhatsappChannel\Status;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The profile's WhatsApp account. Its status is Meta's verification state.
 *
 * @phpstan-type WhatsappChannelShape = array{
 *   ownerBusinessID?: string|null,
 *   phoneNumberID?: string|null,
 *   reason?: string|null,
 *   reasonCode?: string|null,
 *   solutionID?: string|null,
 *   status?: null|Status|value-of<Status>,
 *   wabaID?: string|null,
 * }
 */
final class WhatsappChannel implements BaseModel
{
    /** @use SdkModel<WhatsappChannelShape> */
    use SdkModel;

    /**
     * Derived from the organization's shared-account listing, like SolutionId.
     */
    #[Optional('owner_business_id', nullable: true)]
    public ?string $ownerBusinessID;

    /**
     * The Meta phone-number id the profile sends from, or null when the account is connected but no number
     * has been named yet — which is what a provisioning status means here.
     */
    #[Optional('phone_number_id', nullable: true)]
    public ?string $phoneNumberID;

    /**
     * A sentence for reason_code, saying what to do where it is yours. Omitted while ACTIVE.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * Why the account is not ACTIVE, as a stable code: an ErrorCodes CHANNEL_xxx value such
     * as CHANNEL_001 (something you owe) or CHANNEL_009 (under review). Switch on this rather than
     * on reason. Omitted while ACTIVE. Read-only; when nothing more specific is known it is the
     * generic reason for the status.
     */
    #[Optional('reason_code', nullable: true)]
    public ?string $reasonCode;

    /**
     * Derived, not echoed. The request no longer accepts this — it is read off the organization's
     * shared-account listing at connect time and reported back so a caller can see which partnership the
     * account actually arrived through.
     */
    #[Optional('solution_id', nullable: true)]
    public ?string $solutionID;

    /**
     * Read-only. Never carries a token — the row holds that and it is not returned. ACTION_NEEDED when
     * no account is connected or the account has no phone number: both are yours to do.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    #[Optional('waba_id', nullable: true)]
    public ?string $wabaID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?string $ownerBusinessID = null,
        ?string $phoneNumberID = null,
        ?string $reason = null,
        ?string $reasonCode = null,
        ?string $solutionID = null,
        Status|string|null $status = null,
        ?string $wabaID = null,
    ): self {
        $self = new self;

        null !== $ownerBusinessID && $self['ownerBusinessID'] = $ownerBusinessID;
        null !== $phoneNumberID && $self['phoneNumberID'] = $phoneNumberID;
        null !== $reason && $self['reason'] = $reason;
        null !== $reasonCode && $self['reasonCode'] = $reasonCode;
        null !== $solutionID && $self['solutionID'] = $solutionID;
        null !== $status && $self['status'] = $status;
        null !== $wabaID && $self['wabaID'] = $wabaID;

        return $self;
    }

    /**
     * Derived from the organization's shared-account listing, like SolutionId.
     */
    public function withOwnerBusinessID(?string $ownerBusinessID): self
    {
        $self = clone $this;
        $self['ownerBusinessID'] = $ownerBusinessID;

        return $self;
    }

    /**
     * The Meta phone-number id the profile sends from, or null when the account is connected but no number
     * has been named yet — which is what a provisioning status means here.
     */
    public function withPhoneNumberID(?string $phoneNumberID): self
    {
        $self = clone $this;
        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }

    /**
     * A sentence for reason_code, saying what to do where it is yours. Omitted while ACTIVE.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the account is not ACTIVE, as a stable code: an ErrorCodes CHANNEL_xxx value such
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
     * Derived, not echoed. The request no longer accepts this — it is read off the organization's
     * shared-account listing at connect time and reported back so a caller can see which partnership the
     * account actually arrived through.
     */
    public function withSolutionID(?string $solutionID): self
    {
        $self = clone $this;
        $self['solutionID'] = $solutionID;

        return $self;
    }

    /**
     * Read-only. Never carries a token — the row holds that and it is not returned. ACTION_NEEDED when
     * no account is connected or the account has no phone number: both are yours to do.
     *
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withWabaID(?string $wabaID): self
    {
        $self = clone $this;
        $self['wabaID'] = $wabaID;

        return $self;
    }
}
