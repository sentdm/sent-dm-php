<?php

declare(strict_types=1);

namespace SentDm\Conversations\ConversationMessagesList\Message\MessageBody;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One attachment on a message, in either direction — and in both, a URL somebody else hosts.
 *
 * Outbound: the customer supplied a public URL and we handed it to the carrier.
 * Inbound: the carrier hosts the file and we record where. sent.dm never holds the bytes, so
 * there is no key, no expiry bookkeeping and nothing minted per read — what is stored is what is
 * served.
 *
 * An inbound link expires on the carrier's own schedule and is unauthenticated. That is the
 * customer's to manage, and it is documented where they will see it rather than only here — a
 * recipient who needs an attachment to outlive that window copies it on receipt.
 *
 * Storing a presigned URL is the specific mistake this shape still avoids:
 * M260826130000 and M260826140000 exist because RCS assets were stored as signed URLs
 * and went stale. Nothing here is signed.
 *
 * @phpstan-type MediaShape = array{
 *   mediaType?: string|null,
 *   mimeType?: string|null,
 *   sizeBytes?: int|null,
 *   sourceHashSha256?: string|null,
 *   url?: string|null,
 * }
 */
final class Media implements BaseModel
{
    /** @use SdkModel<MediaShape> */
    use SdkModel;

    /**
     * One of MmsMediaTypes when the content type is known. Advisory — a reader should
     *             trust the fetched object's own Content-Type.
     */
    #[Optional(nullable: true)]
    public ?string $mediaType;

    /**
     * Content type as the provider declared it. Null when it declared none.
     */
    #[Optional(nullable: true)]
    public ?string $mimeType;

    /**
     * Size as the provider declared it. Never measured here — nothing downloads the file.
     */
    #[Optional(nullable: true)]
    public ?int $sizeBytes;

    /**
     * Inbound only: the SHA-256 the provider declared alongside the attachment, when it declared one.
     * Relayed to the customer so they can verify what they fetch matches what the carrier said it sent.
     * It is the only integrity signal available on an attachment nobody here has read.
     */
    #[Optional(nullable: true)]
    public ?string $sourceHashSha256;

    /**
     * Where the file lives. Outbound: the URL the customer gave us and the carrier fetched. Inbound:
     * the URL the carrier hosts it at, relayed unchanged.
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
        ?string $mediaType = null,
        ?string $mimeType = null,
        ?int $sizeBytes = null,
        ?string $sourceHashSha256 = null,
        ?string $url = null,
    ): self {
        $self = new self;

        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $mimeType && $self['mimeType'] = $mimeType;
        null !== $sizeBytes && $self['sizeBytes'] = $sizeBytes;
        null !== $sourceHashSha256 && $self['sourceHashSha256'] = $sourceHashSha256;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * One of MmsMediaTypes when the content type is known. Advisory — a reader should
     *             trust the fetched object's own Content-Type.
     */
    public function withMediaType(?string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Content type as the provider declared it. Null when it declared none.
     */
    public function withMimeType(?string $mimeType): self
    {
        $self = clone $this;
        $self['mimeType'] = $mimeType;

        return $self;
    }

    /**
     * Size as the provider declared it. Never measured here — nothing downloads the file.
     */
    public function withSizeBytes(?int $sizeBytes): self
    {
        $self = clone $this;
        $self['sizeBytes'] = $sizeBytes;

        return $self;
    }

    /**
     * Inbound only: the SHA-256 the provider declared alongside the attachment, when it declared one.
     * Relayed to the customer so they can verify what they fetch matches what the carrier said it sent.
     * It is the only integrity signal available on an attachment nobody here has read.
     */
    public function withSourceHashSha256(?string $sourceHashSha256): self
    {
        $self = clone $this;
        $self['sourceHashSha256'] = $sourceHashSha256;

        return $self;
    }

    /**
     * Where the file lives. Outbound: the URL the customer gave us and the carrier fetched. Inbound:
     * the URL the carrier hosts it at, relayed unchanged.
     */
    public function withURL(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
