<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetStatusResponse\Data\MessageBody;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One attachment on a message: a customer-supplied public URL handed to the carrier as-is.
 *
 *              A URL and nothing else. sent.dm never takes custody of MMS media — the customer hosts it and we
 *              pass the link through at send time — so there is no storage key, size or expiry to record. If we ever
 *              do host attachments, that belongs with the change that introduces the hosting, not here.
 *
 * @phpstan-type MediaShape = array{mediaType?: string|null, url?: string|null}
 */
final class Media implements BaseModel
{
    /** @use SdkModel<MediaShape> */
    use SdkModel;

    /**
     * One of Constants.MmsMediaTypes when known. Advisory — the carrier reads the
     *             fetched object's Content-Type, not this.
     */
    #[Optional(nullable: true)]
    public ?string $mediaType;

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
     * One of Constants.MmsMediaTypes when known. Advisory — the carrier reads the
     *             fetched object's Content-Type, not this.
     */
    public function withMediaType(?string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
