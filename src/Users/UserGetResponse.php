<?php

declare(strict_types=1);

namespace SentDm\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Users\UserGetResponse\Data;
use SentDm\Users\UserGetResponse\Error;
use SentDm\Users\UserGetResponse\Meta;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type DataShape from \SentDm\Users\UserGetResponse\Data
 * @phpstan-import-type ErrorShape from \SentDm\Users\UserGetResponse\Error
 * @phpstan-import-type MetaShape from \SentDm\Users\UserGetResponse\Meta
 *
 * @phpstan-type UserGetResponseShape = array{
 *   data?: null|Data|DataShape,
 *   error?: null|Error|ErrorShape,
 *   meta?: null|Meta|MetaShape,
 *   success?: bool|null,
 * }
 */
final class UserGetResponse implements BaseModel
{
    /** @use SdkModel<UserGetResponseShape> */
    use SdkModel;

    /**
     * User response for v3 API.
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
     * User response for v3 API.
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
