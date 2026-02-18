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
 *   deleteFromMeta?: bool|null, testMode?: bool|null
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
    public static function with(
        ?bool $deleteFromMeta = null,
        ?bool $testMode = null
    ): self {
        $self = new self;

        null !== $deleteFromMeta && $self['deleteFromMeta'] = $deleteFromMeta;
        null !== $testMode && $self['testMode'] = $testMode;

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
