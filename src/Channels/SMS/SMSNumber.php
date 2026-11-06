<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One number of an SMS market.
 *
 * @phpstan-type SMSNumberShape = array{
 *   areaCode?: string|null, senderValue?: string|null, status?: string|null
 * }
 */
final class SMSNumber implements BaseModel
{
    /** @use SdkModel<SMSNumberShape> */
    use SdkModel;

    /**
     * The number's area code, e.g. 212. While the number is still to be assigned, the area code it was
     * asked for, or null when it was asked for in any area code.
     */
    #[Optional('area_code', nullable: true)]
    public ?string $areaCode;

    /**
     * The number, or null while it is still to be assigned.
     */
    #[Optional('sender_value', nullable: true)]
    public ?string $senderValue;

    /**
     * ACTIVE once the number can send; PROVISIONING while it is still to be assigned; INACTIVE
     * once it could send and no longer can.
     */
    #[Optional(nullable: true)]
    public ?string $status;

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
        ?string $areaCode = null,
        ?string $senderValue = null,
        ?string $status = null,
    ): self {
        $self = new self;

        null !== $areaCode && $self['areaCode'] = $areaCode;
        null !== $senderValue && $self['senderValue'] = $senderValue;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * The number's area code, e.g. 212. While the number is still to be assigned, the area code it was
     * asked for, or null when it was asked for in any area code.
     */
    public function withAreaCode(?string $areaCode): self
    {
        $self = clone $this;
        $self['areaCode'] = $areaCode;

        return $self;
    }

    /**
     * The number, or null while it is still to be assigned.
     */
    public function withSenderValue(?string $senderValue): self
    {
        $self = clone $this;
        $self['senderValue'] = $senderValue;

        return $self;
    }

    /**
     * ACTIVE once the number can send; PROVISIONING while it is still to be assigned; INACTIVE
     * once it could send and no longer can.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
