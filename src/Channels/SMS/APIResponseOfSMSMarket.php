<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIMeta;
use SentDm\Webhooks\ErrorDetail;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type SMSMarketShape from \SentDm\Channels\SMS\SMSMarket
 * @phpstan-import-type ErrorDetailShape from \SentDm\Webhooks\ErrorDetail
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseOfSMSMarketShape = array{
 *   data?: null|SMSMarket|SMSMarketShape,
 *   error?: null|ErrorDetail|ErrorDetailShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseOfSMSMarket implements BaseModel
{
    /** @use SdkModel<APIResponseOfSMSMarketShape> */
    use SdkModel;

    /**
     * One SMS market the profile sends in — its sender, where that sender stands, and what the market wants.
     *
     * A profile may send in several: it is a tenant, not a market. Each carries its own status, because
     * a profile can be live in one country and mid-registration in another — and each carries what it still owes,
     * rather than that being reported in a separate array a caller has to join on.
     */
    #[Optional(nullable: true)]
    public ?SMSMarket $data;

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
     * @param SMSMarket|SMSMarketShape|null $data
     * @param ErrorDetail|ErrorDetailShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        SMSMarket|array|null $data = null,
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
     * One SMS market the profile sends in — its sender, where that sender stands, and what the market wants.
     *
     * A profile may send in several: it is a tenant, not a market. Each carries its own status, because
     * a profile can be live in one country and mid-registration in another — and each carries what it still owes,
     * rather than that being reported in a separate array a caller has to join on.
     *
     * @param SMSMarket|SMSMarketShape|null $data
     */
    public function withData(SMSMarket|array|null $data): self
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
