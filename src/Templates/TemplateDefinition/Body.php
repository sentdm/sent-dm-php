<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateDefinition;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Templates\TemplateBodyContent;

/**
 * Required template body with content for different channels (multi-channel, SMS-specific, or WhatsApp-specific).
 *
 * @phpstan-import-type TemplateBodyContentShape from \SentDm\Templates\TemplateBodyContent
 *
 * @phpstan-type BodyShape = array{
 *   multiChannel?: null|TemplateBodyContent|TemplateBodyContentShape,
 *   sms?: null|TemplateBodyContent|TemplateBodyContentShape,
 *   whatsapp?: null|TemplateBodyContent|TemplateBodyContentShape,
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
    public ?TemplateBodyContent $multiChannel;

    /**
     * SMS-specific content that overrides multi-channel content for SMS messages.
     */
    #[Optional(nullable: true)]
    public ?TemplateBodyContent $sms;

    /**
     * WhatsApp-specific content that overrides multi-channel content for WhatsApp messages.
     */
    #[Optional(nullable: true)]
    public ?TemplateBodyContent $whatsapp;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TemplateBodyContent|TemplateBodyContentShape|null $multiChannel
     * @param TemplateBodyContent|TemplateBodyContentShape|null $sms
     * @param TemplateBodyContent|TemplateBodyContentShape|null $whatsapp
     */
    public static function with(
        TemplateBodyContent|array|null $multiChannel = null,
        TemplateBodyContent|array|null $sms = null,
        TemplateBodyContent|array|null $whatsapp = null,
    ): self {
        $self = new self;

        null !== $multiChannel && $self['multiChannel'] = $multiChannel;
        null !== $sms && $self['sms'] = $sms;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    /**
     * Content that will be used for all channels (SMS and WhatsApp) unless channel-specific content is provided.
     *
     * @param TemplateBodyContent|TemplateBodyContentShape|null $multiChannel
     */
    public function withMultiChannel(
        TemplateBodyContent|array|null $multiChannel
    ): self {
        $self = clone $this;
        $self['multiChannel'] = $multiChannel;

        return $self;
    }

    /**
     * SMS-specific content that overrides multi-channel content for SMS messages.
     *
     * @param TemplateBodyContent|TemplateBodyContentShape|null $sms
     */
    public function withSMS(TemplateBodyContent|array|null $sms): self
    {
        $self = clone $this;
        $self['sms'] = $sms;

        return $self;
    }

    /**
     * WhatsApp-specific content that overrides multi-channel content for WhatsApp messages.
     *
     * @param TemplateBodyContent|TemplateBodyContentShape|null $whatsapp
     */
    public function withWhatsapp(TemplateBodyContent|array|null $whatsapp): self
    {
        $self = clone $this;
        $self['whatsapp'] = $whatsapp;

        return $self;
    }
}
