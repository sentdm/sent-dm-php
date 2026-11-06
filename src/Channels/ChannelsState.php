<?php

declare(strict_types=1);

namespace SentDm\Channels;

use SentDm\Channels\Rcs\RcsAgent;
use SentDm\Channels\SMS\SMSMarket;
use SentDm\Channels\Voice\VoiceNumber;
use SentDm\Channels\Whatsapp\WhatsappChannel;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The channels a profile sends on. SMS is a list because a profile can send in several markets; WhatsApp
 * and RCS are single, because a profile has one business account and one agent.
 *
 * @phpstan-import-type MmsMarketShape from \SentDm\Channels\MmsMarket
 * @phpstan-import-type RcsAgentShape from \SentDm\Channels\Rcs\RcsAgent
 * @phpstan-import-type SMSMarketShape from \SentDm\Channels\SMS\SMSMarket
 * @phpstan-import-type VoiceNumberShape from \SentDm\Channels\Voice\VoiceNumber
 * @phpstan-import-type WhatsappChannelShape from \SentDm\Channels\Whatsapp\WhatsappChannel
 *
 * @phpstan-type ChannelsStateShape = array{
 *   customerID?: string|null,
 *   mms?: list<MmsMarket|MmsMarketShape>|null,
 *   rcs?: null|RcsAgent|RcsAgentShape,
 *   sms?: list<SMSMarket|SMSMarketShape>|null,
 *   voice?: list<VoiceNumber|VoiceNumberShape>|null,
 *   whatsapp?: null|WhatsappChannel|WhatsappChannelShape,
 * }
 */
final class ChannelsState implements BaseModel
{
    /** @use SdkModel<ChannelsStateShape> */
    use SdkModel;

    /**
     * Which customer these channels belong to — the key's own, or the profile named in x-profile-id.
     *
     * Same reason the brand carries one: as the response to /v3/channels there is no other id in
     * the document, and under x-profile-id this is the profile the call resolved to rather than the
     * caller. Absent when nested inside a sender profile, whose own id already says whose they are.
     */
    #[Optional('customer_id', nullable: true)]
    public ?string $customerID;

    /**
     * The markets this profile can send MMS in, one entry per country, or empty when none.
     *
     * Appears alongside sms rather than replacing an entry in it: the two are separate senders
     * on the same number and a caller needs to see both — a market can be live for SMS while its MMS row is
     * still provisioning, or MMS-incapable entirely because the market's sender-type SKU does not carry
     * it.
     *
     * @var list<MmsMarket>|null $mms
     */
    #[Optional(list: MmsMarket::class)]
    public ?array $mms;

    /**
     * An RCS agent as its owner sees it: the order form back, plus where the submission stands.
     *
     * Not RcsSenderResponse. That one is the admin projection and carries the pipeline we
     * track about a customer's request — internalStatus, statusReason,
     * isLaunched — and the S3 keys behind the assets. None of that is the customer's to read: an internal
     * status is a note to ourselves, and an S3 key is a storage detail that would become a contract the moment
     * it was published.
     *
     * What is here is what the caller sent, in the names it sent them under, plus the three things only we
     * can answer: the record's id, its status, and the number it sends from. So a read after a
     * write shows the form as stored rather than as echoed.
     */
    #[Optional(nullable: true)]
    public ?RcsAgent $rcs;

    /** @var list<SMSMarket>|null $sms */
    #[Optional(list: SMSMarket::class)]
    public ?array $sms;

    /**
     * The numbers this profile carries phone calls on, one entry per number, or empty when none. Voice is
     * per number like an SMS market is per country: each number is its own channel row, turned on and off
     * on its own, and one of them is the line app-originated calls fall back to.
     *
     * @var list<VoiceNumber>|null $voice
     */
    #[Optional(list: VoiceNumber::class)]
    public ?array $voice;

    /**
     * The profile's WhatsApp account. Its status is Meta's verification state.
     */
    #[Optional(nullable: true)]
    public ?WhatsappChannel $whatsapp;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<MmsMarket|MmsMarketShape>|null $mms
     * @param RcsAgent|RcsAgentShape|null $rcs
     * @param list<SMSMarket|SMSMarketShape>|null $sms
     * @param list<VoiceNumber|VoiceNumberShape>|null $voice
     * @param WhatsappChannel|WhatsappChannelShape|null $whatsapp
     */
    public static function with(
        ?string $customerID = null,
        ?array $mms = null,
        RcsAgent|array|null $rcs = null,
        ?array $sms = null,
        ?array $voice = null,
        WhatsappChannel|array|null $whatsapp = null,
    ): self {
        $self = new self;

        null !== $customerID && $self['customerID'] = $customerID;
        null !== $mms && $self['mms'] = $mms;
        null !== $rcs && $self['rcs'] = $rcs;
        null !== $sms && $self['sms'] = $sms;
        null !== $voice && $self['voice'] = $voice;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    /**
     * Which customer these channels belong to — the key's own, or the profile named in x-profile-id.
     *
     * Same reason the brand carries one: as the response to /v3/channels there is no other id in
     * the document, and under x-profile-id this is the profile the call resolved to rather than the
     * caller. Absent when nested inside a sender profile, whose own id already says whose they are.
     */
    public function withCustomerID(?string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    /**
     * The markets this profile can send MMS in, one entry per country, or empty when none.
     *
     * Appears alongside sms rather than replacing an entry in it: the two are separate senders
     * on the same number and a caller needs to see both — a market can be live for SMS while its MMS row is
     * still provisioning, or MMS-incapable entirely because the market's sender-type SKU does not carry
     * it.
     *
     * @param list<MmsMarket|MmsMarketShape> $mms
     */
    public function withMms(array $mms): self
    {
        $self = clone $this;
        $self['mms'] = $mms;

        return $self;
    }

    /**
     * An RCS agent as its owner sees it: the order form back, plus where the submission stands.
     *
     * Not RcsSenderResponse. That one is the admin projection and carries the pipeline we
     * track about a customer's request — internalStatus, statusReason,
     * isLaunched — and the S3 keys behind the assets. None of that is the customer's to read: an internal
     * status is a note to ourselves, and an S3 key is a storage detail that would become a contract the moment
     * it was published.
     *
     * What is here is what the caller sent, in the names it sent them under, plus the three things only we
     * can answer: the record's id, its status, and the number it sends from. So a read after a
     * write shows the form as stored rather than as echoed.
     *
     * @param RcsAgent|RcsAgentShape|null $rcs
     */
    public function withRcs(RcsAgent|array|null $rcs): self
    {
        $self = clone $this;
        $self['rcs'] = $rcs;

        return $self;
    }

    /**
     * @param list<SMSMarket|SMSMarketShape> $sms
     */
    public function withSMS(array $sms): self
    {
        $self = clone $this;
        $self['sms'] = $sms;

        return $self;
    }

    /**
     * The numbers this profile carries phone calls on, one entry per number, or empty when none. Voice is
     * per number like an SMS market is per country: each number is its own channel row, turned on and off
     * on its own, and one of them is the line app-originated calls fall back to.
     *
     * @param list<VoiceNumber|VoiceNumberShape> $voice
     */
    public function withVoice(array $voice): self
    {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }

    /**
     * The profile's WhatsApp account. Its status is Meta's verification state.
     *
     * @param WhatsappChannel|WhatsappChannelShape|null $whatsapp
     */
    public function withWhatsapp(WhatsappChannel|array|null $whatsapp): self
    {
        $self = clone $this;
        $self['whatsapp'] = $whatsapp;

        return $self;
    }
}
