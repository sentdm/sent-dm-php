<?php

declare(strict_types=1);

namespace SentDm\Numbers;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves detailed information about a phone number including carrier, line type, porting status, and VoIP detection. Uses the customer's messaging provider for rich data, with fallback to the internal index.
 *
 * @see SentDm\Services\NumbersService::lookup()
 *
 * @phpstan-type NumberLookupParamsShape = array{xProfileID?: string|null}
 */
final class NumberLookupParams implements BaseModel
{
    /** @use SdkModel<NumberLookupParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $xProfileID = null): self
    {
        $self = new self;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
