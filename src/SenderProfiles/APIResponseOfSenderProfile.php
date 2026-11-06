<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIMeta;
use SentDm\Webhooks\ErrorDetail;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type SenderProfileShape from \SentDm\SenderProfiles\SenderProfile
 * @phpstan-import-type ErrorDetailShape from \SentDm\Webhooks\ErrorDetail
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseOfSenderProfileShape = array{
 *   data?: null|SenderProfile|SenderProfileShape,
 *   error?: null|ErrorDetail|ErrorDetailShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseOfSenderProfile implements BaseModel
{
    /** @use SdkModel<APIResponseOfSenderProfileShape> */
    use SdkModel;

    /**
     * A sender profile as the API reports it — the same document the create call accepts, plus the read-only
     * facts it cannot: each market's status and what it still owes.
     *
     * No status at the profile, brand or campaign level. Brand and campaign are identity, and
     * identity has no lifecycle. What has one is the registration of a sender in a market, and the approval of
     * a channel — so status lives there, where it says which specific thing is blocked rather than flattening
     * several answers into one.
     */
    #[Optional(nullable: true)]
    public ?SenderProfile $data;

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
     * @param SenderProfile|SenderProfileShape|null $data
     * @param ErrorDetail|ErrorDetailShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        SenderProfile|array|null $data = null,
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
     * A sender profile as the API reports it — the same document the create call accepts, plus the read-only
     * facts it cannot: each market's status and what it still owes.
     *
     * No status at the profile, brand or campaign level. Brand and campaign are identity, and
     * identity has no lifecycle. What has one is the registration of a sender in a market, and the approval of
     * a channel — so status lives there, where it says which specific thing is blocked rather than flattening
     * several answers into one.
     *
     * @param SenderProfile|SenderProfileShape|null $data
     */
    public function withData(SenderProfile|array|null $data): self
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
