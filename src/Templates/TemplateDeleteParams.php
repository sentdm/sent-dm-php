<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Deletes a template by ID. Optionally, you can also delete the template from WhatsApp/Meta by setting delete_from_meta=true.
 *
 * @see SentDm\Services\TemplatesService::delete()
 *
 * @phpstan-type TemplateDeleteParamsShape = array{
 *   deleteFromMeta?: bool|null, sandbox?: bool|null, xProfileID?: string|null
 * }
 */
final class TemplateDeleteParams implements BaseModel
{
    /** @use SdkModel<TemplateDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Whether to also delete the template from WhatsApp/Meta (optional, defaults to false).
     */
    #[Optional('delete_from_meta', nullable: true)]
    public ?bool $deleteFromMeta;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

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
    public static function with(
        ?bool $deleteFromMeta = null,
        ?bool $sandbox = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $deleteFromMeta && $self['deleteFromMeta'] = $deleteFromMeta;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Whether to also delete the template from WhatsApp/Meta (optional, defaults to false).
     */
    public function withDeleteFromMeta(?bool $deleteFromMeta): self
    {
        $self = clone $this;
        $self['deleteFromMeta'] = $deleteFromMeta;

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

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
