<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileNewResponse\Data;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Billing contact info returned in profile responses.
 *
 * @phpstan-type BillingContactShape = array{
 *   address?: string|null,
 *   email?: string|null,
 *   name?: string|null,
 *   phone?: string|null,
 * }
 */
final class BillingContact implements BaseModel
{
    /** @use SdkModel<BillingContactShape> */
    use SdkModel;

    #[Optional(nullable: true)]
    public ?string $address;

    #[Optional(nullable: true)]
    public ?string $email;

    #[Optional(nullable: true)]
    public ?string $name;

    #[Optional(nullable: true)]
    public ?string $phone;

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
        ?string $address = null,
        ?string $email = null,
        ?string $name = null,
        ?string $phone = null,
    ): self {
        $self = new self;

        null !== $address && $self['address'] = $address;
        null !== $email && $self['email'] = $email;
        null !== $name && $self['name'] = $name;
        null !== $phone && $self['phone'] = $phone;

        return $self;
    }

    public function withAddress(?string $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }

    public function withEmail(?string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withPhone(?string $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }
}
