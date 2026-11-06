<?php

declare(strict_types=1);

namespace SentDm\Channels;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Every market you send SMS in, your WhatsApp account, your RCS agent and the numbers you carry phone calls on — with each one's status, and what each market has supplied.
 *
 * **Status lives on the channel, never on you or your brand.** An identity has no lifecycle; what has one is the registration of a sender in a market and the approval of a channel. So a customer live in one country and mid-registration in another reports exactly that, rather than one flattened answer.
 *
 * `sms[n].compliance` carries what each market holds: `brand` and `campaign` for markets that register with a compliance regime such as US TEN_DLC, and `documents` for markets that pre-register an alphanumeric or similar sender. Absent means the market registers with nobody and nothing has been supplied. `GET /v3/compliance/requirements` says what a market demands of any new customer; this says what you gave it.
 *
 * Send `x-profile-id` with an organization key to read one of your profiles' channels.
 *
 * @see SentDm\Services\ChannelsService::list()
 *
 * @phpstan-type ChannelListParamsShape = array{xProfileID?: string|null}
 */
final class ChannelListParams implements BaseModel
{
    /** @use SdkModel<ChannelListParamsShape> */
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
