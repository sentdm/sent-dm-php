<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateUpdateParams\Definition\Button;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Properties specific to the button type.
 *
 * @phpstan-type PropsShape = array{
 *   activeFor: int,
 *   countryCode: string,
 *   offerCode: string,
 *   phoneNumber: string,
 *   quickReplyType: string,
 *   text: string,
 *   url: string,
 *   urlType: string,
 *   autofillText?: string|null,
 *   otpType?: string|null,
 *   packageName?: string|null,
 *   signatureHash?: string|null,
 * }
 */
final class Props implements BaseModel
{
    /** @use SdkModel<PropsShape> */
    use SdkModel;

    #[Required]
    public int $activeFor;

    #[Required]
    public string $countryCode;

    #[Required]
    public string $offerCode;

    #[Required]
    public string $phoneNumber;

    #[Required]
    public string $quickReplyType;

    #[Required]
    public string $text;

    #[Required]
    public string $url;

    #[Required]
    public string $urlType;

    #[Optional(nullable: true)]
    public ?string $autofillText;

    #[Optional(nullable: true)]
    public ?string $otpType;

    #[Optional(nullable: true)]
    public ?string $packageName;

    #[Optional(nullable: true)]
    public ?string $signatureHash;

    /**
     * `new Props()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Props::with(
     *   activeFor: ...,
     *   countryCode: ...,
     *   offerCode: ...,
     *   phoneNumber: ...,
     *   quickReplyType: ...,
     *   text: ...,
     *   url: ...,
     *   urlType: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Props)
     *   ->withActiveFor(...)
     *   ->withCountryCode(...)
     *   ->withOfferCode(...)
     *   ->withPhoneNumber(...)
     *   ->withQuickReplyType(...)
     *   ->withText(...)
     *   ->withURL(...)
     *   ->withURLType(...)
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
        int $activeFor,
        string $countryCode,
        string $offerCode,
        string $phoneNumber,
        string $quickReplyType,
        string $text,
        string $url,
        string $urlType,
        ?string $autofillText = null,
        ?string $otpType = null,
        ?string $packageName = null,
        ?string $signatureHash = null,
    ): self {
        $self = new self;

        $self['activeFor'] = $activeFor;
        $self['countryCode'] = $countryCode;
        $self['offerCode'] = $offerCode;
        $self['phoneNumber'] = $phoneNumber;
        $self['quickReplyType'] = $quickReplyType;
        $self['text'] = $text;
        $self['url'] = $url;
        $self['urlType'] = $urlType;

        null !== $autofillText && $self['autofillText'] = $autofillText;
        null !== $otpType && $self['otpType'] = $otpType;
        null !== $packageName && $self['packageName'] = $packageName;
        null !== $signatureHash && $self['signatureHash'] = $signatureHash;

        return $self;
    }

    public function withActiveFor(int $activeFor): self
    {
        $self = clone $this;
        $self['activeFor'] = $activeFor;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withOfferCode(string $offerCode): self
    {
        $self = clone $this;
        $self['offerCode'] = $offerCode;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withQuickReplyType(string $quickReplyType): self
    {
        $self = clone $this;
        $self['quickReplyType'] = $quickReplyType;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withURLType(string $urlType): self
    {
        $self = clone $this;
        $self['urlType'] = $urlType;

        return $self;
    }

    public function withAutofillText(?string $autofillText): self
    {
        $self = clone $this;
        $self['autofillText'] = $autofillText;

        return $self;
    }

    public function withOtpType(?string $otpType): self
    {
        $self = clone $this;
        $self['otpType'] = $otpType;

        return $self;
    }

    public function withPackageName(?string $packageName): self
    {
        $self = clone $this;
        $self['packageName'] = $packageName;

        return $self;
    }

    public function withSignatureHash(?string $signatureHash): self
    {
        $self = clone $this;
        $self['signatureHash'] = $signatureHash;

        return $self;
    }
}
