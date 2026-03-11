<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateDefinition\Button;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Properties specific to the button type.
 *
 * @phpstan-type PropsShape = array{
 *   activeFor?: int|null,
 *   autofillText?: string|null,
 *   countryCode?: string|null,
 *   offerCode?: string|null,
 *   otpType?: string|null,
 *   packageName?: string|null,
 *   phoneNumber?: string|null,
 *   quickReplyType?: string|null,
 *   signatureHash?: string|null,
 *   text?: string|null,
 *   url?: string|null,
 *   urlType?: string|null,
 * }
 */
final class Props implements BaseModel
{
    /** @use SdkModel<PropsShape> */
    use SdkModel;

    #[Optional(nullable: true)]
    public ?int $activeFor;

    #[Optional(nullable: true)]
    public ?string $autofillText;

    #[Optional(nullable: true)]
    public ?string $countryCode;

    #[Optional(nullable: true)]
    public ?string $offerCode;

    #[Optional(nullable: true)]
    public ?string $otpType;

    #[Optional(nullable: true)]
    public ?string $packageName;

    #[Optional(nullable: true)]
    public ?string $phoneNumber;

    #[Optional(nullable: true)]
    public ?string $quickReplyType;

    #[Optional(nullable: true)]
    public ?string $signatureHash;

    #[Optional(nullable: true)]
    public ?string $text;

    #[Optional(nullable: true)]
    public ?string $url;

    #[Optional(nullable: true)]
    public ?string $urlType;

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
        ?int $activeFor = null,
        ?string $autofillText = null,
        ?string $countryCode = null,
        ?string $offerCode = null,
        ?string $otpType = null,
        ?string $packageName = null,
        ?string $phoneNumber = null,
        ?string $quickReplyType = null,
        ?string $signatureHash = null,
        ?string $text = null,
        ?string $url = null,
        ?string $urlType = null,
    ): self {
        $self = new self;

        null !== $activeFor && $self['activeFor'] = $activeFor;
        null !== $autofillText && $self['autofillText'] = $autofillText;
        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $offerCode && $self['offerCode'] = $offerCode;
        null !== $otpType && $self['otpType'] = $otpType;
        null !== $packageName && $self['packageName'] = $packageName;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $quickReplyType && $self['quickReplyType'] = $quickReplyType;
        null !== $signatureHash && $self['signatureHash'] = $signatureHash;
        null !== $text && $self['text'] = $text;
        null !== $url && $self['url'] = $url;
        null !== $urlType && $self['urlType'] = $urlType;

        return $self;
    }

    public function withActiveFor(?int $activeFor): self
    {
        $self = clone $this;
        $self['activeFor'] = $activeFor;

        return $self;
    }

    public function withAutofillText(?string $autofillText): self
    {
        $self = clone $this;
        $self['autofillText'] = $autofillText;

        return $self;
    }

    public function withCountryCode(?string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withOfferCode(?string $offerCode): self
    {
        $self = clone $this;
        $self['offerCode'] = $offerCode;

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

    public function withPhoneNumber(?string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withQuickReplyType(?string $quickReplyType): self
    {
        $self = clone $this;
        $self['quickReplyType'] = $quickReplyType;

        return $self;
    }

    public function withSignatureHash(?string $signatureHash): self
    {
        $self = clone $this;
        $self['signatureHash'] = $signatureHash;

        return $self;
    }

    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withURL(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withURLType(?string $urlType): self
    {
        $self = clone $this;
        $self['urlType'] = $urlType;

        return $self;
    }
}
