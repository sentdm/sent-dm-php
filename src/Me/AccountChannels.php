<?php

declare(strict_types=1);

namespace SentDm\Me;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Messaging channel configuration. All three channels are always present.
 * Each channel has a "configured" flag; configured channels expose additional details.
 *
 * @phpstan-import-type AccountRcsChannelShape from \SentDm\Me\AccountRcsChannel
 * @phpstan-import-type AccountSMSChannelShape from \SentDm\Me\AccountSMSChannel
 * @phpstan-import-type AccountWhatsappChannelShape from \SentDm\Me\AccountWhatsappChannel
 *
 * @phpstan-type AccountChannelsShape = array{
 *   rcs?: null|AccountRcsChannel|AccountRcsChannelShape,
 *   sms?: null|AccountSMSChannel|AccountSMSChannelShape,
 *   whatsapp?: null|AccountWhatsappChannel|AccountWhatsappChannelShape,
 * }
 */
final class AccountChannels implements BaseModel
{
    /** @use SdkModel<AccountChannelsShape> */
    use SdkModel;

    /**
     * RCS channel configuration. When configured, includes the RCS phone number.
     */
    #[Optional]
    public ?AccountRcsChannel $rcs;

    /**
     * SMS channel configuration. When configured, includes the sending phone number.
     */
    #[Optional]
    public ?AccountSMSChannel $sms;

    /**
     * WhatsApp Business channel configuration. When configured, includes the WhatsApp phone number
     * and business name.
     */
    #[Optional]
    public ?AccountWhatsappChannel $whatsapp;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AccountRcsChannel|AccountRcsChannelShape|null $rcs
     * @param AccountSMSChannel|AccountSMSChannelShape|null $sms
     * @param AccountWhatsappChannel|AccountWhatsappChannelShape|null $whatsapp
     */
    public static function with(
        AccountRcsChannel|array|null $rcs = null,
        AccountSMSChannel|array|null $sms = null,
        AccountWhatsappChannel|array|null $whatsapp = null,
    ): self {
        $self = new self;

        null !== $rcs && $self['rcs'] = $rcs;
        null !== $sms && $self['sms'] = $sms;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    /**
     * RCS channel configuration. When configured, includes the RCS phone number.
     *
     * @param AccountRcsChannel|AccountRcsChannelShape $rcs
     */
    public function withRcs(AccountRcsChannel|array $rcs): self
    {
        $self = clone $this;
        $self['rcs'] = $rcs;

        return $self;
    }

    /**
     * SMS channel configuration. When configured, includes the sending phone number.
     *
     * @param AccountSMSChannel|AccountSMSChannelShape $sms
     */
    public function withSMS(AccountSMSChannel|array $sms): self
    {
        $self = clone $this;
        $self['sms'] = $sms;

        return $self;
    }

    /**
     * WhatsApp Business channel configuration. When configured, includes the WhatsApp phone number
     * and business name.
     *
     * @param AccountWhatsappChannel|AccountWhatsappChannelShape $whatsapp
     */
    public function withWhatsapp(AccountWhatsappChannel|array $whatsapp): self
    {
        $self = clone $this;
        $self['whatsapp'] = $whatsapp;

        return $self;
    }
}
