<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body section of a message template.
 *
 * A body picks one of two authoring strategies, and mixing them is refused
 * (TemplateDefinitionValidator.HaveValidChannelConfiguration):
 * a shared multiChannel body on its own, or
 * an explicit sms + whatsapp pair, both present.
 *
 * multiChannel together with sms or whatsapp is rejected, and so is
 * sms or whatsapp on its own — every template is expected to be deliverable on every
 * channel. rcs is the one true override: it may accompany either strategy to vary the copy,
 * but cannot stand alone.
 *
 * @phpstan-import-type TemplateBodyContentShape from \SentDm\Templates\TemplateBodyContent
 *
 * @phpstan-type TemplateBodyShape = array{
 *   multiChannel?: null|TemplateBodyContent|TemplateBodyContentShape,
 *   rcs?: null|TemplateBodyContent|TemplateBodyContentShape,
 *   sms?: null|TemplateBodyContent|TemplateBodyContentShape,
 *   whatsapp?: null|TemplateBodyContent|TemplateBodyContentShape,
 * }
 */
final class TemplateBody implements BaseModel
{
    /** @use SdkModel<TemplateBodyShape> */
    use SdkModel;

    /**
     * The shared body, used for every channel. One half of the choice described above.
     */
    #[Optional(nullable: true)]
    public ?TemplateBodyContent $multiChannel;

    /**
     * RCS-specific copy that overrides the chosen strategy for RCS only. The one true override:
     * optional on top of either strategy, but it cannot be the only body present. Its length cap is
     * the higher one described on Template.
     */
    #[Optional(nullable: true)]
    public ?TemplateBodyContent $rcs;

    /**
     * The SMS body. It does not override multiChannel, it replaces it.
     */
    #[Optional(nullable: true)]
    public ?TemplateBodyContent $sms;

    /**
     * The WhatsApp body. It does not override multiChannel, it replaces it.
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
     * @param TemplateBodyContent|TemplateBodyContentShape|null $rcs
     * @param TemplateBodyContent|TemplateBodyContentShape|null $sms
     * @param TemplateBodyContent|TemplateBodyContentShape|null $whatsapp
     */
    public static function with(
        TemplateBodyContent|array|null $multiChannel = null,
        TemplateBodyContent|array|null $rcs = null,
        TemplateBodyContent|array|null $sms = null,
        TemplateBodyContent|array|null $whatsapp = null,
    ): self {
        $self = new self;

        null !== $multiChannel && $self['multiChannel'] = $multiChannel;
        null !== $rcs && $self['rcs'] = $rcs;
        null !== $sms && $self['sms'] = $sms;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    /**
     * The shared body, used for every channel. One half of the choice described above.
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
     * RCS-specific copy that overrides the chosen strategy for RCS only. The one true override:
     * optional on top of either strategy, but it cannot be the only body present. Its length cap is
     * the higher one described on Template.
     *
     * @param TemplateBodyContent|TemplateBodyContentShape|null $rcs
     */
    public function withRcs(TemplateBodyContent|array|null $rcs): self
    {
        $self = clone $this;
        $self['rcs'] = $rcs;

        return $self;
    }

    /**
     * The SMS body. It does not override multiChannel, it replaces it.
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
     * The WhatsApp body. It does not override multiChannel, it replaces it.
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
