<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Retrieves a specific message template by its unique identifier for the authenticated customer with comprehensive template definitions including headers, body, footer, and interactive buttons. The customer ID is extracted from the authentication token.
 *
 * @see SentDm\Services\TemplatesService::retrieve()
 *
 * @phpstan-type TemplateRetrieveParamsShape = array{
 *   xAPIKey: string, xSenderID: string
 * }
 */
final class TemplateRetrieveParams implements BaseModel
{
    /** @use SdkModel<TemplateRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $xAPIKey;

    #[Required]
    public string $xSenderID;

    /**
     * `new TemplateRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateRetrieveParams::with(xAPIKey: ..., xSenderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateRetrieveParams)->withXAPIKey(...)->withXSenderID(...)
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
