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
 * @phpstan-type NumberLookupRetrieveParamsShape = array{phoneNumber: string}
 */
final class NumberLookupRetrieveParams implements BaseModel
{
    /** @use SdkModel<NumberLookupRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $phoneNumber;

    /**
     * `new NumberLookupRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * NumberLookupRetrieveParams::with(phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new NumberLookupRetrieveParams)->withPhoneNumber(...)
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
    public static function with(string $phoneNumber): self
    {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }
}
