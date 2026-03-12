<?php

declare(strict_types=1);

namespace SentDm\Me\MeGetResponse\Data\Channels;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * WhatsApp Business channel configuration. When configured, includes the WhatsApp phone number
 * and business name.
 *
 * @phpstan-type WhatsappShape = array{
 *   businessName?: string|null, configured?: bool|null, phoneNumber?: string|null
 * }
 */
final class Whatsapp implements BaseModel
{
    /** @use SdkModel<WhatsappShape> */
    use SdkModel;

    /**
     * WhatsApp Business display name.
     */
    #[Optional('business_name', nullable: true)]
    public ?string $businessName;

    /**
     * Whether WhatsApp is configured for this account.
     */
    #[Optional]
    public ?bool $configured;

    /**
     * WhatsApp phone number in E.164 format.
     */
    #[Optional('phone_number', nullable: true)]
    public ?string $phoneNumber;

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
        ?string $businessName = null,
        ?bool $configured = null,
        ?string $phoneNumber = null,
    ): self {
        $self = new self;

        null !== $businessName && $self['businessName'] = $businessName;
        null !== $configured && $self['configured'] = $configured;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * WhatsApp Business display name.
     */
    public function withBusinessName(?string $businessName): self
    {
        $self = clone $this;
        $self['businessName'] = $businessName;

        return $self;
    }

    /**
     * Whether WhatsApp is configured for this account.
     */
    public function withConfigured(bool $configured): self
    {
        $self = clone $this;
        $self['configured'] = $configured;

        return $self;
    }

    /**
     * WhatsApp phone number in E.164 format.
     */
    public function withPhoneNumber(?string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }
}
