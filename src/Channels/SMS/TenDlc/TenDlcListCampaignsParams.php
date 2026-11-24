<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Every campaign your US `TEN_DLC` market registers, oldest first, each with its `id`, where it stands and `inherit` (`true` for your organization's) beside its fields — the list `GET /v3/channels/sms/US/TEN_DLC` reports under `compliance.campaigns`. Add one with `POST` on this path, and change one of your own with `PATCH /v3/channels/sms/US/TEN_DLC/campaigns/{id}`.
 *
 * Each campaign has a `status` of its own, so a market on several says which is approved: `ACTIVE` once the carriers have elected it, `PENDING_REVIEW` until then, `ACTION_NEEDED` when it came back for correction, `DECLINED` when the carriers refused it, `INACTIVE` once it has ended. Why the market is held up is the market's own `reason`, which names the campaign concerned. `status` is read-only and ignored when the entry is sent back.
 *
 * A customer without a US `TEN_DLC` market is `404`.
 *
 * @see SentDm\Services\Channels\SMS\TenDlcService::listCampaigns()
 *
 * @phpstan-type TenDlcListCampaignsParamsShape = array{xProfileID?: string|null}
 */
final class TenDlcListCampaignsParams implements BaseModel
{
    /** @use SdkModel<TenDlcListCampaignsParamsShape> */
    use SdkModel;
    use SdkParams;

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
     */
    public static function with(?string $xProfileID = null): self
    {
        $self = new self;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
