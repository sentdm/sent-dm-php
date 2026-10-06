<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Every number you turned phone calls on for, active or inactive, oldest first. Each entry carries the number's status, whether it is the default line for calls placed from your app, and its callback URL. The signing secret is never on a read; it is shown when voice is turned on and by `POST /v3/channels/voice/{number}/rotate-secret`.
 *
 * The same entries `GET /v3/channels` reports under `voice`, and the same shape `GET /v3/channels/voice/{number}` returns for one of them. Change a number with `PATCH /v3/channels/voice/{number}`.
 *
 * @see SentDm\Services\Channels\VoiceService::list()
 *
 * @phpstan-type VoiceListParamsShape = array{xProfileID?: string|null}
 */
final class VoiceListParams implements BaseModel
{
    /** @use SdkModel<VoiceListParamsShape> */
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
