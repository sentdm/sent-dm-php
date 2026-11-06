<?php

declare(strict_types=1);

namespace SentDm\Channels\Whatsapp;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Connects a WhatsApp Business Account shared with us through a Multi-Partner Solution to the calling sender profile. Send `x-profile-id` for the profile the account belongs to.
 *
 * **Two fields, because everything else is derived.** `waba_id` says which of your organization's shared accounts this is — you hold one per client, and nothing else can say which. `phone_number_id` names the account's number, which is what assigns it to the profile as the number it sends from.
 *
 * The solution the account arrived through, the client business portfolio that owns it, the access token and its expiry are all resolved from your organization. They are not accepted here: the first two are Meta's answer about provenance, and the token is minted per client business and rotates roughly every sixty days, so a value you sent would be stale before it was useful.
 *
 * `phone_number_id` is optional. Omit it to connect the account now and settle the number later — the channel reads as `ACTION_NEEDED` with `reason_code` `CHANNEL_007`, and the profile's WhatsApp messages fail until a number is named. They do not fall back to your organization's account. Call this endpoint again with `phone_number_id` to name one.
 *
 * The same resolution runs behind `channels.whatsapp` on `POST /v3/sender-profiles`, so connecting at create and connecting afterwards fill the same fields.
 *
 * Returns **the account**, not every channel you have — adding one cannot change a market or an RCS agent, and `GET /v3/channels` is the whole picture. Giving an account up is not self-service: ask support, because deregistering a number lands in your own Meta business.
 *
 * @see SentDm\Services\Channels\WhatsappService::create()
 *
 * @phpstan-type WhatsappCreateParamsShape = array{
 *   phoneNumberID?: string|null,
 *   sandbox?: bool|null,
 *   wabaID?: string|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class WhatsappCreateParams implements BaseModel
{
    /** @use SdkModel<WhatsappCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The Meta phone-number id of the number on WabaId, which assigns it to this profile as the
     * number it sends from. It is not checked against the account here, so name the account's number; it is
     * refused if another profile already uses it.
     *
     * Optional: omit it to connect the account and settle the number later. Nothing picks one on your
     * behalf.
     */
    #[Optional('phone_number_id', nullable: true)]
    public ?string $phoneNumberID;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * WhatsApp Business Account id — one of the accounts shared into your organization. Required: the
     * organization holds one per client, and nothing but the caller says which is meant here.
     */
    #[Optional('waba_id')]
    public ?string $wabaID;

    #[Optional]
    public ?string $idempotencyKey;

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
    public static function with(
        ?string $phoneNumberID = null,
        ?bool $sandbox = null,
        ?string $wabaID = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $phoneNumberID && $self['phoneNumberID'] = $phoneNumberID;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $wabaID && $self['wabaID'] = $wabaID;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * The Meta phone-number id of the number on WabaId, which assigns it to this profile as the
     * number it sends from. It is not checked against the account here, so name the account's number; it is
     * refused if another profile already uses it.
     *
     * Optional: omit it to connect the account and settle the number later. Nothing picks one on your
     * behalf.
     */
    public function withPhoneNumberID(?string $phoneNumberID): self
    {
        $self = clone $this;
        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    /**
     * WhatsApp Business Account id — one of the accounts shared into your organization. Required: the
     * organization holds one per client, and nothing but the caller says which is meant here.
     */
    public function withWabaID(string $wabaID): self
    {
        $self = clone $this;
        $self['wabaID'] = $wabaID;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
