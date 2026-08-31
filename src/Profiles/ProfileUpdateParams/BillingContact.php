<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileUpdateParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Billing contact information for a profile.
 * Required when billing_model is "profile" or "profile_and_organization".
 *
 * @phpstan-type BillingContactShape = array{
 *   email: string, name: string, address?: string|null, phone?: string|null
 * }
 */
final class BillingContact implements BaseModel
{
    /** @use SdkModel<BillingContactShape> */
    use SdkModel;

    /**
     * Email address where invoices will be sent (required).
     */
    #[Required]
    public string $email;

    /**
     * Full name of the billing contact or company (required).
     */
    #[Required]
    public string $name;

    /**
     * Billing address (optional). Free-form text including street, city, state, postal code, and country.
     */
    #[Optional(nullable: true)]
    public ?string $address;

    /**
     * Phone number for the billing contact (optional).
     */
    #[Optional(nullable: true)]
    public ?string $phone;

    /**
     * `new BillingContact()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BillingContact::with(email: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BillingContact)->withEmail(...)->withName(...)
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
        string $email,
        string $name,
        ?string $address = null,
        ?string $phone = null
    ): self {
        $self = new self;

        $self['email'] = $email;
        $self['name'] = $name;

        null !== $address && $self['address'] = $address;
        null !== $phone && $self['phone'] = $phone;

        return $self;
    }

    /**
     * Email address where invoices will be sent (required).
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Full name of the billing contact or company (required).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Billing address (optional). Free-form text including street, city, state, postal code, and country.
     */
    public function withAddress(?string $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }

    /**
     * Phone number for the billing contact (optional).
     */
    public function withPhone(?string $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }
}
