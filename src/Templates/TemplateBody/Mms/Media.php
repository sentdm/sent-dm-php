<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateBody\Mms;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One attachment on an MMS template body.
 *
 * @phpstan-type MediaShape = array{mediaType?: string|null, url?: string|null}
 */
final class Media implements BaseModel
{
    /** @use SdkModel<MediaShape> */
    use SdkModel;

    /**
     * One of MmsMediaTypes. Advisory: the carrier reads the Content-Type off the
     *             fetched object, not this field. It exists so an authoring UI can render the right preview and so a
     *             reviewer can see what was intended.
     */
    #[Optional(nullable: true)]
    public ?string $mediaType;

    /**
     * Publicly fetchable https URL. The carrier's MMSC fetches this at send time, so it has to
     *             stay reachable and unauthenticated for the life of the send — including retries and a DLQ
     *             replay — which is why a presigned URL is not a valid value here.
     */
    #[Optional]
    public ?string $url;

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
        ?string $mediaType = null,
        ?string $url = null
    ): self {
        $self = new self;

        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * One of MmsMediaTypes. Advisory: the carrier reads the Content-Type off the
     *             fetched object, not this field. It exists so an authoring UI can render the right preview and so a
     *             reviewer can see what was intended.
     */
    public function withMediaType(?string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Publicly fetchable https URL. The carrier's MMSC fetches this at send time, so it has to
     *             stay reachable and unauthenticated for the life of the send — including retries and a DLQ
     *             replay — which is why a presigned URL is not a valid value here.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
