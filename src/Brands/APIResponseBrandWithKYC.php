<?php

declare(strict_types=1);

namespace SentDm\Brands;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIError;
use SentDm\Webhooks\APIMeta;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type BrandWithKYCShape from \SentDm\Brands\BrandWithKYC
 * @phpstan-import-type APIErrorShape from \SentDm\Webhooks\APIError
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseBrandWithKYCShape = array{
 *   data?: null|BrandWithKYC|BrandWithKYCShape,
 *   error?: null|APIError|APIErrorShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseBrandWithKYC implements BaseModel
{
    /** @use SdkModel<APIResponseBrandWithKYCShape> */
    use SdkModel;

    /**
     * The response data (null if error).
     */
    #[Optional(nullable: true)]
    public ?BrandWithKYC $data;

    /**
     * Error details (null if successful).
     */
    #[Optional(nullable: true)]
    public ?APIError $error;

    /**
     * Metadata about the request and response.
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
     * @param BrandWithKYC|BrandWithKYCShape|null $data
     * @param APIError|APIErrorShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        BrandWithKYC|array|null $data = null,
        APIError|array|null $error = null,
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
     * The response data (null if error).
     *
     * @param BrandWithKYC|BrandWithKYCShape|null $data
     */
    public function withData(BrandWithKYC|array|null $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Error details (null if successful).
     *
     * @param APIError|APIErrorShape|null $error
     */
    public function withError(APIError|array|null $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * Metadata about the request and response.
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
