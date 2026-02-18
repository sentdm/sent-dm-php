<?php

declare(strict_types=1);

namespace SentDm\Contacts\ContactDeleteParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Request to delete/dissociate a contact.
 *
 * @phpstan-type BodyShape = array{testMode?: bool|null}
 */
final class Body implements BaseModel
{
    /** @use SdkModel<BodyShape> */
    use SdkModel;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $testMode = null): self
    {
        $self = new self;

        null !== $testMode && $self['testMode'] = $testMode;

        return $self;
    }

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withTestMode(bool $testMode): self
    {
        $self = clone $this;
        $self['testMode'] = $testMode;

        return $self;
    }
}
