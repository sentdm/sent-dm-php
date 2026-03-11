<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileDeleteParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Request to delete a profile.
 *
 * @phpstan-type BodyShape = array{sandbox?: bool|null}
 */
final class Body implements BaseModel
{
    /** @use SdkModel<BodyShape> */
    use SdkModel;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $sandbox = null): self
    {
        $self = new self;

        null !== $sandbox && $self['sandbox'] = $sandbox;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }
}
