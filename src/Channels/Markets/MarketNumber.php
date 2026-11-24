<?php

declare(strict_types=1);

namespace SentDm\Channels\Markets;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One number the customer holds, or is still owed.
 *
 * @phpstan-type MarketNumberShape = array{
 *   areaCode?: string|null,
 *   campaignID?: string|null,
 *   senderValue?: string|null,
 *   status?: string|null,
 *   type?: string|null,
 * }
 */
final class MarketNumber implements BaseModel
{
    /** @use SdkModel<MarketNumberShape> */
    use SdkModel;

    #[Optional('area_code', nullable: true)]
    public ?string $areaCode;

    /**
     * The campaign the number belongs to (US TEN_DLC); null otherwise.
     */
    #[Optional('campaign_id', nullable: true)]
    public ?string $campaignID;

    /**
     * The number, or the sender id; null until it is assigned.
     */
    #[Optional('sender_value', nullable: true)]
    public ?string $senderValue;

    /**
     * ACTIVE, PROVISIONING or INACTIVE.
     */
    #[Optional(nullable: true)]
    public ?string $status;

    /**
     * The market's sender type, e.g. TEN_DLC, LOCAL.
     */
    #[Optional]
    public ?string $type;

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
        ?string $campaignID = null,
        ?string $senderValue = null,
        ?string $status = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $areaCode && $self['areaCode'] = $areaCode;
        null !== $campaignID && $self['campaignID'] = $campaignID;
        null !== $senderValue && $self['senderValue'] = $senderValue;
        null !== $status && $self['status'] = $status;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    public function withAreaCode(?string $areaCode): self
    {
        $self = clone $this;
        $self['areaCode'] = $areaCode;

        return $self;
    }

    /**
     * The campaign the number belongs to (US TEN_DLC); null otherwise.
     */
    public function withCampaignID(?string $campaignID): self
    {
        $self = clone $this;
        $self['campaignID'] = $campaignID;

        return $self;
    }

    /**
     * The number, or the sender id; null until it is assigned.
     */
    public function withSenderValue(?string $senderValue): self
    {
        $self = clone $this;
        $self['senderValue'] = $senderValue;

        return $self;
    }

    /**
     * ACTIVE, PROVISIONING or INACTIVE.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The market's sender type, e.g. TEN_DLC, LOCAL.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
