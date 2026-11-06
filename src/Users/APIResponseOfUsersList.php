<?php

declare(strict_types=1);

namespace SentDm\Users;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIMeta;
use SentDm\Webhooks\ErrorDetail;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type UsersListShape from \SentDm\Users\UsersList
 * @phpstan-import-type ErrorDetailShape from \SentDm\Webhooks\ErrorDetail
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseOfUsersListShape = array{
 *   data?: null|UsersList|UsersListShape,
 *   error?: null|ErrorDetail|ErrorDetailShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseOfUsersList implements BaseModel
{
    /** @use SdkModel<APIResponseOfUsersListShape> */
    use SdkModel;

    /**
     * The users in the organization.
     */
    #[Optional(nullable: true)]
    public ?UsersList $data;

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
     * @param UsersList|UsersListShape|null $data
     * @param ErrorDetail|ErrorDetailShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        UsersList|array|null $data = null,
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
     * The users in the organization.
     *
     * @param UsersList|UsersListShape|null $data
     */
    public function withData(UsersList|array|null $data): self
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
