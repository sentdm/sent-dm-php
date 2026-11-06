<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Who pays for what a sender profile sends.
 *
 * Ownership reads the same way as BrandRequest and CampaignRequest:
 * inherit: true is the organization paying; inherit: false (or an empty block) is the
 * profile paying for itself.
 *
 * An absent block is the one place billing differs from brand and campaign: a profile still has to be
 * paid for, so omitting billing stores ProfileAndOrganizationBilling — the profile pays first
 * and its organization covers what the profile's balance cannot (see
 * ResolveStored). { "name": "..." } stays a complete request.
 *
 * Billing carries no fields of its own yet, so a profile paying for itself is
 * { "inherit": false } — or an empty block, which means the same. That is thinner than brand and
 * campaign, where supplying data is the act of owning; it becomes ordinary the moment billing gains a
 * contact or a payment method to carry.
 *
 * @phpstan-type SenderProfileBillingRequestShape = array{inherit?: bool|null}
 */
final class SenderProfileBillingRequest implements BaseModel
{
    /** @use SdkModel<SenderProfileBillingRequestShape> */
    use SdkModel;

    /**
     * Whether the parent organization pays. false is the profile paying for itself.
     */
    #[Optional]
    public ?bool $inherit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $inherit = null): self
    {
        $self = new self;

        null !== $inherit && $self['inherit'] = $inherit;

        return $self;
    }

    /**
     * Whether the parent organization pays. false is the profile paying for itself.
     */
    public function withInherit(bool $inherit): self
    {
        $self = clone $this;
        $self['inherit'] = $inherit;

        return $self;
    }
}
