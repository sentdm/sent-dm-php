<?php

declare(strict_types=1);

namespace SentDm\Webhooks\ChannelEventPayload\Compliance;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A document a market asked for and has been given.
 *
 * @phpstan-type DocumentShape = array{
 *   documentID?: string|null, fileName?: string|null, key?: string|null
 * }
 */
final class Document implements BaseModel
{
    /** @use SdkModel<DocumentShape> */
    use SdkModel;

    /**
     * Identifier of the upload, for fetching it back through the documents endpoints.
     */
    #[Optional('document_id', nullable: true)]
    public ?string $documentID;

    #[Optional('file_name', nullable: true)]
    public ?string $fileName;

    /**
     * The catalog's name for this document, matching the requirement it satisfies.
     */
    #[Optional]
    public ?string $key;

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
        ?string $documentID = null,
        ?string $fileName = null,
        ?string $key = null
    ): self {
        $self = new self;

        null !== $documentID && $self['documentID'] = $documentID;
        null !== $fileName && $self['fileName'] = $fileName;
        null !== $key && $self['key'] = $key;

        return $self;
    }

    /**
     * Identifier of the upload, for fetching it back through the documents endpoints.
     */
    public function withDocumentID(?string $documentID): self
    {
        $self = clone $this;
        $self['documentID'] = $documentID;

        return $self;
    }

    public function withFileName(?string $fileName): self
    {
        $self = clone $this;
        $self['fileName'] = $fileName;

        return $self;
    }

    /**
     * The catalog's name for this document, matching the requirement it satisfies.
     */
    public function withKey(string $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }
}
