<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Deletes a specific message template by its unique identifier for the authenticated customer with smart deletion strategy. Deletion behavior: - If template has NO messages: Permanently deleted from database (hard delete). - If template has messages: Marked as deleted but preserved for message history (soft delete with snapshot). The template must exist and belong to the authenticated customer to be deleted successfully. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\TemplatesService::delete()
 *
 * @phpstan-type TemplateDeleteParamsShape = array{
 *   xAPIKey: string, xSenderID: string
 * }
 */
final class TemplateDeleteParams implements BaseModel
{
    /** @use SdkModel<TemplateDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * `new TemplateDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateDeleteParams::with(xAPIKey: ..., xSenderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateDeleteParams)->withXAPIKey(...)->withXSenderID(...)
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
    public static function with(string $xAPIKey, string $xSenderID): self
    {
        $self = new self;

        $self['xAPIKey'] = $xAPIKey;
        $self['xSenderID'] = $xSenderID;

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
