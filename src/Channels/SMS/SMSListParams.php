<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Every market you send SMS in, each with its sender, where that sender stands, and what its compliance holds.
 *
 * The same entries `GET /v3/channels` reports under `sms`, and the same shape `GET /v3/channels/sms/{country}/{type}` returns for one of them — so a list, a member read and the all-channels read cannot describe a market differently.
 *
 * Send `x-profile-id` with an organization key to list one of your profiles' markets.
 *
 * @see SentDm\Services\Channels\SMSService::list()
 *
 * @phpstan-type SMSListParamsShape = array{xProfileID?: string|null}
 */
final class SMSListParams implements BaseModel
{
    /** @use SdkModel<SMSListParamsShape> */
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
