<?php

declare(strict_types=1);

namespace SentDm\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIError;
use SentDm\Webhooks\APIMeta;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type UserResponseShape from \SentDm\Users\UserResponse
 * @phpstan-import-type APIErrorShape from \SentDm\Webhooks\APIError
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseOfUserShape = array{
 *   data?: null|UserResponse|UserResponseShape,
 *   error?: null|APIError|APIErrorShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseOfUser implements BaseModel
{
    /** @use SdkModel<APIResponseOfUserShape> */
    use SdkModel;

    /**
     * User response for v3 API.
     */
    #[Optional(nullable: true)]
    public ?UserResponse $data;

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
     * @param UserResponse|UserResponseShape|null $data
     * @param APIError|APIErrorShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        UserResponse|array|null $data = null,
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
     * User response for v3 API.
     *
     * @param UserResponse|UserResponseShape|null $data
     */
    public function withData(UserResponse|array|null $data): self
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
