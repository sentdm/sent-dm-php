<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Reads what the US `TEN_DLC` market you hold has registered: the `brand` it files under, **every campaign** under `campaigns` (each with its `id` and `inherit`), and its `documents`. It is the `compliance` object `GET /v3/channels/sms/US/TEN_DLC` returns, without the sender and numbers.
 *
 * Use a campaign's `id` to change it with `PATCH /v3/channels/sms/compliances/US/TEN_DLC/campaigns/{campaignId}`, or to add numbers to it with `POST /v3/channels/sms/numbers/US/TEN_DLC`.
 *
 * Send `x-profile-id` with an organization key to read one of your profiles' markets.
 *
 * @see SentDm\Services\Channels\SMS\TenDlcService::retrieveCompliance()
 *
 * @phpstan-type TenDlcRetrieveComplianceParamsShape = array{
 *   xProfileID?: string|null
 * }
 */
final class TenDlcRetrieveComplianceParams implements BaseModel
{
    /** @use SdkModel<TenDlcRetrieveComplianceParamsShape> */
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
