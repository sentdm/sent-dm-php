<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileCreateParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Direct WhatsApp Business Account credentials for this profile.
 * When provided, the profile uses its own WhatsApp Business Account instead of inheriting from the organization.
 * When omitted, the profile inherits the organization's WhatsApp Business Account (requires the organization
 * to have completed WhatsApp Embedded Signup).
 *
 * @phpstan-type WhatsappBusinessAccountShape = array{
 *   accessToken: string, wabaID: string, phoneNumberID?: string|null
 * }
 */
final class WhatsappBusinessAccount implements BaseModel
{
    /** @use SdkModel<WhatsappBusinessAccountShape> */
    use SdkModel;

    /**
     * System User access token with whatsapp_business_messaging and
     * whatsapp_business_management permissions. This value is stored securely
     * and never returned in API responses.
     */
    #[Required('access_token')]
    public string $accessToken;

    /**
     * WhatsApp Business Account ID from Meta Business Manager.
     */
    #[Required('waba_id')]
    public string $wabaID;

    /**
     * Phone Number ID of an existing number already registered under this WABA in Meta Business Manager.
     * Optional — when omitted, a number will be provisioned from our pool and registered in the WABA
     * during the onboarding flow. When provided, the number must already exist in the WABA.
     */
    #[Optional('phone_number_id', nullable: true)]
    public ?string $phoneNumberID;

    /**
     * `new WhatsappBusinessAccount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WhatsappBusinessAccount::with(accessToken: ..., wabaID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WhatsappBusinessAccount)->withAccessToken(...)->withWabaID(...)
     * ```
     */
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
        string $accessToken,
        string $wabaID,
        ?string $phoneNumberID = null
    ): self {
        $self = new self;

        $self['accessToken'] = $accessToken;
        $self['wabaID'] = $wabaID;

        null !== $phoneNumberID && $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }

    /**
     * System User access token with whatsapp_business_messaging and
     * whatsapp_business_management permissions. This value is stored securely
     * and never returned in API responses.
     */
    public function withAccessToken(string $accessToken): self
    {
        $self = clone $this;
        $self['accessToken'] = $accessToken;

        return $self;
    }

    /**
     * WhatsApp Business Account ID from Meta Business Manager.
     */
    public function withWabaID(string $wabaID): self
    {
        $self = clone $this;
        $self['wabaID'] = $wabaID;

        return $self;
    }

    /**
     * Phone Number ID of an existing number already registered under this WABA in Meta Business Manager.
     * Optional — when omitted, a number will be provisioned from our pool and registered in the WABA
     * during the onboarding flow. When provided, the number must already exist in the WABA.
     */
    public function withPhoneNumberID(?string $phoneNumberID): self
    {
        $self = clone $this;
        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }
}
