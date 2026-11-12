<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc;

use SentDm\Channels\SMS\SuppliedCompliance;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIMeta;
use SentDm\Webhooks\ErrorDetail;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type SuppliedComplianceShape from \SentDm\Channels\SMS\SuppliedCompliance
 * @phpstan-import-type ErrorDetailShape from \SentDm\Webhooks\ErrorDetail
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseOfSuppliedComplianceShape = array{
 *   data?: null|SuppliedCompliance|SuppliedComplianceShape,
 *   error?: null|ErrorDetail|ErrorDetailShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseOfSuppliedCompliance implements BaseModel
{
    /** @use SdkModel<APIResponseOfSuppliedComplianceShape> */
    use SdkModel;

    /**
     * What a market has been given: the identity it registers under, its programme, and any documents attached.
     *
     * What it does not carry is what the market asks for. That is the subject of
     * GET /v3/compliance/requirements, and it is the same answer for every caller — a description of what
     * a compliance regime wants, not a record of one customer's progress through it. It was reported here as
     * well for a while, which put the same array in six response shapes and left a caller deciding which of two
     * sources to believe.
     *
     * Present on a list read for markets that register (carrying brand and campaign), but with
     * documents absent — documents are not fetched for a list, because a catalog lookup and a document
     * read per market would multiply across a page. Absent documents is distinct from an empty list:
     * absent says they were not fetched; empty says the market has been given none. The parent object is null
     * only when the market registers with nobody and compliance was not computed — nothing to show at all.
     */
    #[Optional(nullable: true)]
    public ?SuppliedCompliance $data;

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
     * @param SuppliedCompliance|SuppliedComplianceShape|null $data
     * @param ErrorDetail|ErrorDetailShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        SuppliedCompliance|array|null $data = null,
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
     * What a market has been given: the identity it registers under, its programme, and any documents attached.
     *
     * What it does not carry is what the market asks for. That is the subject of
     * GET /v3/compliance/requirements, and it is the same answer for every caller — a description of what
     * a compliance regime wants, not a record of one customer's progress through it. It was reported here as
     * well for a while, which put the same array in six response shapes and left a caller deciding which of two
     * sources to believe.
     *
     * Present on a list read for markets that register (carrying brand and campaign), but with
     * documents absent — documents are not fetched for a list, because a catalog lookup and a document
     * read per market would multiply across a page. Absent documents is distinct from an empty list:
     * absent says they were not fetched; empty says the market has been given none. The parent object is null
     * only when the market registers with nobody and compliance was not computed — nothing to show at all.
     *
     * @param SuppliedCompliance|SuppliedComplianceShape|null $data
     */
    public function withData(SuppliedCompliance|array|null $data): self
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
