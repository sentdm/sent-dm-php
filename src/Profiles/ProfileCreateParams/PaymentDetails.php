<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileCreateParams;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Payment card details for this profile (optional).
 * Accepted when billing_model is "profile" or "profile_and_organization".
 * Not persisted on our servers — forwarded to the payment processor.
 *
 * @phpstan-type PaymentDetailsShape = array{
 *   cardNumber: string, cvc: string, expiry: string, zipCode: string
 * }
 */
final class PaymentDetails implements BaseModel
{
    /** @use SdkModel<PaymentDetailsShape> */
    use SdkModel;

    /**
     * Card number (digits only, 13–19 characters).
     */
    #[Required('card_number')]
    public string $cardNumber;

    /**
     * Card security code (3–4 digits).
     */
    #[Required]
    public string $cvc;

    /**
     * Card expiry date in MM/YY format (e.g. "09/27").
     */
    #[Required]
    public string $expiry;

    /**
     * Billing ZIP / postal code associated with the card.
     */
    #[Required('zip_code')]
    public string $zipCode;

    /**
     * `new PaymentDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaymentDetails::with(cardNumber: ..., cvc: ..., expiry: ..., zipCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaymentDetails)
     *   ->withCardNumber(...)
     *   ->withCvc(...)
     *   ->withExpiry(...)
     *   ->withZipCode(...)
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
        string $cardNumber,
        string $cvc,
        string $expiry,
        string $zipCode
    ): self {
        $self = new self;

        $self['cardNumber'] = $cardNumber;
        $self['cvc'] = $cvc;
        $self['expiry'] = $expiry;
        $self['zipCode'] = $zipCode;

        return $self;
    }

    /**
     * Card number (digits only, 13–19 characters).
     */
    public function withCardNumber(string $cardNumber): self
    {
        $self = clone $this;
        $self['cardNumber'] = $cardNumber;

        return $self;
    }

    /**
     * Card security code (3–4 digits).
     */
    public function withCvc(string $cvc): self
    {
        $self = clone $this;
        $self['cvc'] = $cvc;

        return $self;
    }

    /**
     * Card expiry date in MM/YY format (e.g. "09/27").
     */
    public function withExpiry(string $expiry): self
    {
        $self = clone $this;
        $self['expiry'] = $expiry;

        return $self;
    }

    /**
     * Billing ZIP / postal code associated with the card.
     */
    public function withZipCode(string $zipCode): self
    {
        $self = clone $this;
        $self['zipCode'] = $zipCode;

        return $self;
    }
}
