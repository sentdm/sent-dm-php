<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageSendResponse\Data;
use SentDm\Messages\MessageSendResponse\Error;
use SentDm\Messages\MessageSendResponse\Meta;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type DataShape from \SentDm\Messages\MessageSendResponse\Data
 * @phpstan-import-type ErrorShape from \SentDm\Messages\MessageSendResponse\Error
 * @phpstan-import-type MetaShape from \SentDm\Messages\MessageSendResponse\Meta
 *
 * @phpstan-type MessageSendResponseShape = array{
 *   data?: null|Data|DataShape,
 *   error?: null|Error|ErrorShape,
 *   meta?: null|Meta|MetaShape,
 *   success?: bool|null,
 * }
 */
final class MessageSendResponse implements BaseModel
{
    /** @use SdkModel<MessageSendResponseShape> */
    use SdkModel;

    /**
     * The result of a multi-recipient send.
     *
     * Declared here rather than in the service layer. POST /v3/messages used to publish
     * MessageSendResult — a type in Common.Services.Messaging.Contracts — so the public contract was
     * whatever the send service happened to return, and changing that service for an internal reason changed the
     * API. The service keeps its result; this is what a caller sees, and the mapping between them is a decision the
     * endpoint makes.
     *
     * The wire is unchanged by the move: same names, same values.
     */
    #[Optional(nullable: true)]
    public ?Data $data;

    /**
     * Error information.
     */
    #[Optional(nullable: true)]
    public ?Error $error;

    /**
     * Request and response metadata.
     */
    #[Optional]
    public ?Meta $meta;

    /**
     * Indicates whether the request was successful.
     */
    #[Optional]
    public ?bool $success;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Data|DataShape|null $data
     * @param Error|ErrorShape|null $error
     * @param Meta|MetaShape|null $meta
     */
    public static function with(
        Data|array|null $data = null,
        Error|array|null $error = null,
        Meta|array|null $meta = null,
        ?bool $success = null,
    ): self {
        $self = new self;

        null !== $data && $self['data'] = $data;
        null !== $error && $self['error'] = $error;
        null !== $meta && $self['meta'] = $meta;
        null !== $success && $self['success'] = $success;

        return $self;
    }

    /**
     * The result of a multi-recipient send.
     *
     * Declared here rather than in the service layer. POST /v3/messages used to publish
     * MessageSendResult — a type in Common.Services.Messaging.Contracts — so the public contract was
     * whatever the send service happened to return, and changing that service for an internal reason changed the
     * API. The service keeps its result; this is what a caller sees, and the mapping between them is a decision the
     * endpoint makes.
     *
     * The wire is unchanged by the move: same names, same values.
     *
     * @param Data|DataShape|null $data
     */
    public function withData(Data|array|null $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Error information.
     *
     * @param Error|ErrorShape|null $error
     */
    public function withError(Error|array|null $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * Request and response metadata.
     *
     * @param Meta|MetaShape $meta
     */
    public function withMeta(Meta|array $meta): self
    {
        $self = clone $this;
        $self['meta'] = $meta;

        return $self;
    }

    /**
     * Indicates whether the request was successful.
     */
    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
