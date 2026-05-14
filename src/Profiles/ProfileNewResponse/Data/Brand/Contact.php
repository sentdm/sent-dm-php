<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileNewResponse\Data\Brand;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Contact information for the brand.
 *
 * @phpstan-type ContactShape = array{
 *   businessName?: string|null,
 *   email?: string|null,
 *   name?: string|null,
 *   phone?: string|null,
 *   phoneCountryCode?: string|null,
 *   role?: string|null,
 * }
 */
final class Contact implements BaseModel
{
    /** @use SdkModel<ContactShape> */
    use SdkModel;

    /**
     * Business/brand name.
     */
    #[Optional('business_name', nullable: true)]
    public ?string $businessName;

    /**
     * Contact email address.
     */
    #[Optional(nullable: true)]
    public ?string $email;

    /**
     * Primary contact name.
     */
    #[Optional]
    public ?string $name;

    /**
     * Contact phone number in E.164 format.
     */
    #[Optional(nullable: true)]
    public ?string $phone;

    /**
     * Contact phone country code (e.g., "1" for US).
     */
    #[Optional('phone_country_code', nullable: true)]
    public ?string $phoneCountryCode;

    /**
     * Contact's role in the business.
     */
    #[Optional(nullable: true)]
    public ?string $role;

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
        ?string $email = null,
        ?string $name = null,
        ?string $phone = null,
        ?string $phoneCountryCode = null,
        ?string $role = null,
    ): self {
        $self = new self;

        null !== $businessName && $self['businessName'] = $businessName;
        null !== $email && $self['email'] = $email;
        null !== $name && $self['name'] = $name;
        null !== $phone && $self['phone'] = $phone;
        null !== $phoneCountryCode && $self['phoneCountryCode'] = $phoneCountryCode;
        null !== $role && $self['role'] = $role;

        return $self;
    }

    /**
     * Business/brand name.
     */
    public function withBusinessName(?string $businessName): self
    {
        $self = clone $this;
        $self['businessName'] = $businessName;

        return $self;
    }

    /**
     * Contact email address.
     */
    public function withEmail(?string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Primary contact name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Contact phone number in E.164 format.
     */
    public function withPhone(?string $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }

    /**
     * Contact phone country code (e.g., "1" for US).
     */
    public function withPhoneCountryCode(?string $phoneCountryCode): self
    {
        $self = clone $this;
        $self['phoneCountryCode'] = $phoneCountryCode;

        return $self;
    }

    /**
     * Contact's role in the business.
     */
    public function withRole(?string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
