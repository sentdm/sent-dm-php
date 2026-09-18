<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageSendParams;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * SDK-style template reference: resolve by ID or by name, with optional parameters.
 *
 * @phpstan-type TemplateShape = array{
 *   id?: string|null, name?: string|null, parameters?: array<string,string>|null
 * }
 */
final class Template implements BaseModel
{
    /** @use SdkModel<TemplateShape> */
    use SdkModel;

    /**
     * Template ID (mutually exclusive with name).
     */
    #[Optional(nullable: true)]
    public ?string $id;

    /**
     * Template name (mutually exclusive with id).
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Template variable parameters for personalization, keyed by variable name.
     *
     * Every variable the template declares is required; GET /v3/templates/{id} lists them.
     * Supplying a key the template does not declare is ignored.
     *
     * Media headers. A template whose header is an image (designed in WhatsApp Manager and
     * imported into Sent) declares a reserved header_image key. Its value is a publicly
     * reachable https URL that Meta fetches at send time — Sent does not host the asset, and the
     * sample approved with the template is not reused. The key is derived from the header's media type,
     * so header_video and header_document follow the same shape when those formats ship.
     *
     * "parameters": {
     *   "header_image": "https://cdn.example.com/banner.jpg",
     *   "name": "John Doe"
     * }
     *
     * @var array<string,string>|null $parameters
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $parameters;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string>|null $parameters
     */
    public static function with(
        ?string $id = null,
        ?string $name = null,
        ?array $parameters = null
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $name && $self['name'] = $name;
        null !== $parameters && $self['parameters'] = $parameters;

        return $self;
    }

    /**
     * Template ID (mutually exclusive with name).
     */
    public function withID(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Template name (mutually exclusive with id).
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Template variable parameters for personalization, keyed by variable name.
     *
     * Every variable the template declares is required; GET /v3/templates/{id} lists them.
     * Supplying a key the template does not declare is ignored.
     *
     * Media headers. A template whose header is an image (designed in WhatsApp Manager and
     * imported into Sent) declares a reserved header_image key. Its value is a publicly
     * reachable https URL that Meta fetches at send time — Sent does not host the asset, and the
     * sample approved with the template is not reused. The key is derived from the header's media type,
     * so header_video and header_document follow the same shape when those formats ship.
     *
     * "parameters": {
     *   "header_image": "https://cdn.example.com/banner.jpg",
     *   "name": "John Doe"
     * }
     *
     * @param array<string,string>|null $parameters
     */
    public function withParameters(?array $parameters): self
    {
        $self = clone $this;
        $self['parameters'] = $parameters;

        return $self;
    }
}
