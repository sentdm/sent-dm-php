<?php

declare(strict_types=1);

namespace SentDm\NumberLookup;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves detailed information about a phone number including validation, formatting, country information, and available messaging channels. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\NumberLookupService::retrieve()
 *
 * @phpstan-type NumberLookupRetrieveParamsShape = array{
 *   phoneNumber: string, xAPIKey: string, xSenderID: string
 * }
 */
final class NumberLookupRetrieveParams implements BaseModel
{
    /** @use SdkModel<NumberLookupRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $phoneNumber;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * `new NumberLookupRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * NumberLookupRetrieveParams::with(phoneNumber: ..., xAPIKey: ..., xSenderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new NumberLookupRetrieveParams)
     *   ->withPhoneNumber(...)
     *   ->withXAPIKey(...)
     *   ->withXSenderID(...)
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
        string $phoneNumber,
        string $xAPIKey,
        string $xSenderID
    ): self {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;
        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withXAPIKey(string $xAPIKey): self
    {
        $self = clone $this;
        $self['xAPIKey'] = $xAPIKey;

        return $self;
    }

    public function withXSenderID(string $xSenderID): self
    {
        $self = clone $this;
        $self['xSenderID'] = $xSenderID;

        return $self;
    }
}
