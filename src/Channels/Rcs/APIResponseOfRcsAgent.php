<?php

declare(strict_types=1);

namespace SentDm\Channels\Rcs;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIMeta;
use SentDm\Webhooks\ErrorDetail;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type RcsAgentShape from \SentDm\Channels\Rcs\RcsAgent
 * @phpstan-import-type ErrorDetailShape from \SentDm\Webhooks\ErrorDetail
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseOfRcsAgentShape = array{
 *   data?: null|RcsAgent|RcsAgentShape,
 *   error?: null|ErrorDetail|ErrorDetailShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseOfRcsAgent implements BaseModel
{
    /** @use SdkModel<APIResponseOfRcsAgentShape> */
    use SdkModel;

    /**
     * An RCS agent as its owner sees it: the order form back, plus where the submission stands.
     *
     * Not RcsSenderResponse. That one is the admin projection and carries the pipeline we
     * track about a customer's request — internalStatus, statusReason,
     * isLaunched — and the S3 keys behind the assets. None of that is the customer's to read: an internal
     * status is a note to ourselves, and an S3 key is a storage detail that would become a contract the moment
     * it was published.
     *
     * What is here is what the caller sent, in the names it sent them under, plus the three things only we
     * can answer: the record's id, its status, and the number it sends from. So a read after a
     * write shows the form as stored rather than as echoed.
     */
    #[Optional(nullable: true)]
    public ?RcsAgent $data;

    /**
     * Error information.
     */
    #[Optional(nullable: true)]
    public ?ErrorDetail $error;

    /**
     * Request and response metadata.
     */
    #[Optional]
    public ?APIMeta $meta;

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
     * @param RcsAgent|RcsAgentShape|null $data
     * @param ErrorDetail|ErrorDetailShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        RcsAgent|array|null $data = null,
        ErrorDetail|array|null $error = null,
        APIMeta|array|null $meta = null,
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
     * An RCS agent as its owner sees it: the order form back, plus where the submission stands.
     *
     * Not RcsSenderResponse. That one is the admin projection and carries the pipeline we
     * track about a customer's request — internalStatus, statusReason,
     * isLaunched — and the S3 keys behind the assets. None of that is the customer's to read: an internal
     * status is a note to ourselves, and an S3 key is a storage detail that would become a contract the moment
     * it was published.
     *
     * What is here is what the caller sent, in the names it sent them under, plus the three things only we
     * can answer: the record's id, its status, and the number it sends from. So a read after a
     * write shows the form as stored rather than as echoed.
     *
     * @param RcsAgent|RcsAgentShape|null $data
     */
    public function withData(RcsAgent|array|null $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Error information.
     *
     * @param ErrorDetail|ErrorDetailShape|null $error
     */
    public function withError(ErrorDetail|array|null $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * Request and response metadata.
     *
     * @param APIMeta|APIMetaShape $meta
     */
    public function withMeta(APIMeta|array $meta): self
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
