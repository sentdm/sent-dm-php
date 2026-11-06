<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Who pays for a sender profile's traffic, as a read reports it.
 *
 * Its own type, field for field the same as
 * BillingRequest. Same reason as the brand: a response is not
 * a request, whatever it carries.
 *
 * @phpstan-type SenderProfileBillingShape = array{inherit?: bool|null}
 */
final class SenderProfileBilling implements BaseModel
{
    /** @use SdkModel<SenderProfileBillingShape> */
    use SdkModel;

    /**
     * Whether the organization pays, rather than the profile.
     */
    #[Optional]
    public ?bool $inherit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $inherit = null): self
    {
        $self = new self;

        null !== $inherit && $self['inherit'] = $inherit;

        return $self;
    }

    /**
     * Whether the organization pays, rather than the profile.
     */
    public function withInherit(bool $inherit): self
    {
        $self = clone $this;
        $self['inherit'] = $inherit;

        return $self;
    }
}
