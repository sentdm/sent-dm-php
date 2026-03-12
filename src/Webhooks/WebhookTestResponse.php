<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\WebhookTestResponse\Data;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type DataShape from \SentDm\Webhooks\WebhookTestResponse\Data
 * @phpstan-import-type APIErrorShape from \SentDm\Webhooks\APIError
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type WebhookTestResponseShape = array{
 *   data?: null|Data|DataShape,
 *   error?: null|APIError|APIErrorShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class WebhookTestResponse implements BaseModel
{
    /** @use SdkModel<WebhookTestResponseShape> */
    use SdkModel;

    /**
     * The response data (null if error).
     */
    #[Optional(nullable: true)]
    public ?Data $data;

    /**
     * Error information.
     */
    #[Optional(nullable: true)]
    public ?APIError $error;

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
     * @param Data|DataShape|null $data
     * @param APIError|APIErrorShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        Data|array|null $data = null,
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
     * @param APIError|APIErrorShape|null $error
     */
    public function withError(APIError|array|null $error): self
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
