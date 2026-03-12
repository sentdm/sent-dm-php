<?php

declare(strict_types=1);

namespace SentDm\Me\MeGetResponse\Data\Channels;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * SMS channel configuration. When configured, includes the sending phone number.
 *
 * @phpstan-type SMSShape = array{
 *   configured?: bool|null, phoneNumber?: string|null
 * }
 */
final class SMS implements BaseModel
{
    /** @use SdkModel<SMSShape> */
    use SdkModel;

    /**
     * Whether SMS is configured for this account.
     */
    #[Optional]
    public ?bool $configured;

    /**
     * Sending phone number in E.164 format.
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
        ?bool $configured = null,
        ?string $phoneNumber = null
    ): self {
        $self = new self;

        null !== $configured && $self['configured'] = $configured;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * Whether SMS is configured for this account.
     */
    public function withConfigured(bool $configured): self
    {
        $self = clone $this;
        $self['configured'] = $configured;

        return $self;
    }

    /**
     * Sending phone number in E.164 format.
     */
    public function withPhoneNumber(?string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }
}
