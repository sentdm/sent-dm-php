<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Reads one of your voice numbers, active or inactive: its status, whether it is the default line for calls placed from your app, and its callback URL. The signing secret is not on this read.
 *
 * The same shape `GET /v3/channels/voice` lists, and the same shape `PATCH` on this path accepts and returns, so what comes back can be sent back.
 *
 * The number is the E.164 value in the path with the plus sign URL-encoded (`%2B`).
 *
 * @see SentDm\Services\Channels\VoiceService::retrieve()
 *
 * @phpstan-type VoiceRetrieveParamsShape = array{xProfileID?: string|null}
 */
final class VoiceRetrieveParams implements BaseModel
{
    /** @use SdkModel<VoiceRetrieveParamsShape> */
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
