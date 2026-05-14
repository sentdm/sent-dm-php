<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateUpdateParams\Definition;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateUpdateParams\Definition\Body\MultiChannel;
use SentDm\Templates\TemplateUpdateParams\Definition\Body\Rcs;
use SentDm\Templates\TemplateUpdateParams\Definition\Body\SMS;
use SentDm\Templates\TemplateUpdateParams\Definition\Body\Whatsapp;

/**
 * Body section of a message template with channel-specific content.
 *
 * @phpstan-import-type MultiChannelShape from \SentDm\Templates\TemplateUpdateParams\Definition\Body\MultiChannel
 * @phpstan-import-type RcsShape from \SentDm\Templates\TemplateUpdateParams\Definition\Body\Rcs
 * @phpstan-import-type SMSShape from \SentDm\Templates\TemplateUpdateParams\Definition\Body\SMS
 * @phpstan-import-type WhatsappShape from \SentDm\Templates\TemplateUpdateParams\Definition\Body\Whatsapp
 *
 * @phpstan-type BodyShape = array{
 *   multiChannel?: null|MultiChannel|MultiChannelShape,
 *   rcs?: null|Rcs|RcsShape,
 *   sms?: null|SMS|SMSShape,
 *   whatsapp?: null|Whatsapp|WhatsappShape,
 * }
 */
final class Body implements BaseModel
{
    /** @use SdkModel<BodyShape> */
    use SdkModel;

    /**
     * Content that will be used for all channels (SMS and WhatsApp) unless channel-specific content is provided.
     */
    #[Optional(nullable: true)]
    public ?MultiChannel $multiChannel;

    /**
     * RCS-specific content that overrides multi-channel content for RCS messages.
     */
    #[Optional(nullable: true)]
    public ?Rcs $rcs;

    /**
     * SMS-specific content that overrides multi-channel content for SMS messages.
     */
    #[Optional(nullable: true)]
    public ?SMS $sms;

    /**
     * WhatsApp-specific content that overrides multi-channel content for WhatsApp messages.
     */
    #[Optional(nullable: true)]
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
     * @param MultiChannel|MultiChannelShape|null $multiChannel
     * @param Rcs|RcsShape|null $rcs
     * @param SMS|SMSShape|null $sms
     * @param Whatsapp|WhatsappShape|null $whatsapp
     */
    public static function with(
        MultiChannel|array|null $multiChannel = null,
        Rcs|array|null $rcs = null,
        SMS|array|null $sms = null,
        Whatsapp|array|null $whatsapp = null,
    ): self {
        $self = new self;

        null !== $multiChannel && $self['multiChannel'] = $multiChannel;
        null !== $rcs && $self['rcs'] = $rcs;
        null !== $sms && $self['sms'] = $sms;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    /**
     * Content that will be used for all channels (SMS and WhatsApp) unless channel-specific content is provided.
     *
     * @param MultiChannel|MultiChannelShape|null $multiChannel
     */
    public function withMultiChannel(
        MultiChannel|array|null $multiChannel
    ): self {
        $self = clone $this;
        $self['multiChannel'] = $multiChannel;

        return $self;
    }

    /**
     * RCS-specific content that overrides multi-channel content for RCS messages.
     *
     * @param Rcs|RcsShape|null $rcs
     */
    public function withRcs(Rcs|array|null $rcs): self
    {
        $self = clone $this;
        $self['rcs'] = $rcs;

        return $self;
    }

    /**
     * SMS-specific content that overrides multi-channel content for SMS messages.
     *
     * @param SMS|SMSShape|null $sms
     */
    public function withSMS(SMS|array|null $sms): self
    {
        $self = clone $this;
        $self['sms'] = $sms;

        return $self;
    }

    /**
     * WhatsApp-specific content that overrides multi-channel content for WhatsApp messages.
     *
     * @param Whatsapp|WhatsappShape|null $whatsapp
     */
    public function withWhatsapp(Whatsapp|array|null $whatsapp): self
    {
        $self = clone $this;
        $self['whatsapp'] = $whatsapp;

        return $self;
    }
}
