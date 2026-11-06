<?php

declare(strict_types=1);

namespace SentDm\Channels\Rcs;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The registered address of the company behind the agent.
 *
 * @phpstan-type RcsAddressShape = array{
 *   city?: string|null,
 *   country?: string|null,
 *   postalCode?: string|null,
 *   state?: string|null,
 *   street?: string|null,
 * }
 */
final class RcsAddress implements BaseModel
{
    /** @use SdkModel<RcsAddressShape> */
    use SdkModel;

    #[Optional(nullable: true)]
    public ?string $city;

    #[Optional(nullable: true)]
    public ?string $country;

    #[Optional('postal_code', nullable: true)]
    public ?string $postalCode;

    #[Optional(nullable: true)]
    public ?string $state;

    #[Optional(nullable: true)]
    public ?string $street;

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
        ?string $city = null,
        ?string $country = null,
        ?string $postalCode = null,
        ?string $state = null,
        ?string $street = null,
    ): self {
        $self = new self;

        null !== $city && $self['city'] = $city;
        null !== $country && $self['country'] = $country;
        null !== $postalCode && $self['postalCode'] = $postalCode;
        null !== $state && $self['state'] = $state;
        null !== $street && $self['street'] = $street;

        return $self;
    }

    public function withCity(?string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    public function withCountry(?string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    public function withPostalCode(?string $postalCode): self
    {
        $self = clone $this;
        $self['postalCode'] = $postalCode;

        return $self;
    }

    public function withState(?string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    public function withStreet(?string $street): self
    {
        $self = clone $this;
        $self['street'] = $street;

        return $self;
    }
}
