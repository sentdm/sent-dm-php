<?php

declare(strict_types=1);

namespace SentDm\Me\MeGetResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Me\MeGetResponse\Data\Channels\Rcs;
use SentDm\Me\MeGetResponse\Data\Channels\SMS;
use SentDm\Me\MeGetResponse\Data\Channels\Whatsapp;

/**
 * Messaging channel configuration.
 *
 * @phpstan-import-type RcsShape from \SentDm\Me\MeGetResponse\Data\Channels\Rcs
 * @phpstan-import-type SMSShape from \SentDm\Me\MeGetResponse\Data\Channels\SMS
 * @phpstan-import-type WhatsappShape from \SentDm\Me\MeGetResponse\Data\Channels\Whatsapp
 *
 * @phpstan-type ChannelsShape = array{
 *   rcs?: null|Rcs|RcsShape,
 *   sms?: null|SMS|SMSShape,
 *   whatsapp?: null|Whatsapp|WhatsappShape,
 * }
 */
final class Channels implements BaseModel
{
    /** @use SdkModel<ChannelsShape> */
    use SdkModel;

    /**
     * RCS channel (provider: vibes).
     */
    #[Optional]
    public ?Rcs $rcs;

    /**
     * SMS channel (providers: telnyx, sinch).
     */
    #[Optional]
    public ?SMS $sms;

    /**
     * WhatsApp Business channel (provider: meta).
     */
    #[Optional]
    public ?Whatsapp $whatsapp;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Rcs|RcsShape|null $rcs
     * @param SMS|SMSShape|null $sms
     * @param Whatsapp|WhatsappShape|null $whatsapp
     */
    public static function with(
        Rcs|array|null $rcs = null,
        SMS|array|null $sms = null,
        Whatsapp|array|null $whatsapp = null,
    ): self {
        $self = new self;

        null !== $rcs && $self['rcs'] = $rcs;
        null !== $sms && $self['sms'] = $sms;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    /**
     * RCS channel (provider: vibes).
     *
     * @param Rcs|RcsShape $rcs
     */
    public function withRcs(Rcs|array $rcs): self
    {
        $self = clone $this;
        $self['rcs'] = $rcs;

        return $self;
    }

    /**
     * SMS channel (providers: telnyx, sinch).
     *
     * @param SMS|SMSShape $sms
     */
    public function withSMS(SMS|array $sms): self
    {
        $self = clone $this;
        $self['sms'] = $sms;

        return $self;
    }

    /**
     * WhatsApp Business channel (provider: meta).
     *
     * @param Whatsapp|WhatsappShape $whatsapp
     */
    public function withWhatsapp(Whatsapp|array $whatsapp): self
    {
        $self = clone $this;
        $self['whatsapp'] = $whatsapp;

        return $self;
    }
}
