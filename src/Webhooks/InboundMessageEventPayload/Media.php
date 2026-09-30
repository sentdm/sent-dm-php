<?php

declare(strict_types=1);

namespace SentDm\Webhooks\InboundMessageEventPayload;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One attachment on an inbound message.
 *
 * @phpstan-type MediaShape = array{
 *   hashSha256?: string|null,
 *   mimeType?: string|null,
 *   sizeBytes?: int|null,
 *   url?: string|null,
 * }
 */
final class Media implements BaseModel
{
    /** @use SdkModel<MediaShape> */
    use SdkModel;

    /**
     * SHA-256 of the file as the carrier declared it, when it declares one. Verify what you download
     * against this — sent.dm never reads the bytes, so it is the only integrity signal available.
     */
    #[Optional('hash_sha256', nullable: true)]
    public ?string $hashSha256;

    /**
     * Content type as the carrier reported it, for example image/jpeg.
     */
    #[Optional('mime_type', nullable: true)]
    public ?string $mimeType;

    /**
     * Size in bytes as the carrier declared it. Absent when it declared none.
     */
    #[Optional('size_bytes', nullable: true)]
    public ?int $sizeBytes;

    /**
     * Where the carrier hosts the attachment.
     *
     * This link expires and is not authenticated. sent.dm relays it rather than copying
     * the file, so how long it stays fetchable is the carrier's decision and differs between them —
     * assume days, not months. Anyone holding the URL can fetch it until it lapses. Copy the file on
     * receipt if you need it to outlive that window; do not store this URL as a permanent reference.
     */
    #[Optional(nullable: true)]
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
        ?string $hashSha256 = null,
        ?string $mimeType = null,
        ?int $sizeBytes = null,
        ?string $url = null,
    ): self {
        $self = new self;

        null !== $hashSha256 && $self['hashSha256'] = $hashSha256;
        null !== $mimeType && $self['mimeType'] = $mimeType;
        null !== $sizeBytes && $self['sizeBytes'] = $sizeBytes;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * SHA-256 of the file as the carrier declared it, when it declares one. Verify what you download
     * against this — sent.dm never reads the bytes, so it is the only integrity signal available.
     */
    public function withHashSha256(?string $hashSha256): self
    {
        $self = clone $this;
        $self['hashSha256'] = $hashSha256;

        return $self;
    }

    /**
     * Content type as the carrier reported it, for example image/jpeg.
     */
    public function withMimeType(?string $mimeType): self
    {
        $self = clone $this;
        $self['mimeType'] = $mimeType;

        return $self;
    }

    /**
     * Size in bytes as the carrier declared it. Absent when it declared none.
     */
    public function withSizeBytes(?int $sizeBytes): self
    {
        $self = clone $this;
        $self['sizeBytes'] = $sizeBytes;

        return $self;
    }

    /**
     * Where the carrier hosts the attachment.
     *
     * This link expires and is not authenticated. sent.dm relays it rather than copying
     * the file, so how long it stays fetchable is the carrier's decision and differs between them —
     * assume days, not months. Anyone holding the URL can fetch it until it lapses. Copy the file on
     * receipt if you need it to outlive that window; do not store this URL as a permanent reference.
     */
    public function withURL(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
