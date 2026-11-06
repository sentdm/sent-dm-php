<?php

declare(strict_types=1);

namespace SentDm\Profiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIMeta;
use SentDm\Webhooks\ErrorDetail;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type ProfileCompletionAcceptedShape from \SentDm\Profiles\ProfileCompletionAccepted
 * @phpstan-import-type ErrorDetailShape from \SentDm\Webhooks\ErrorDetail
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseOfProfileCompletionAcceptedShape = array{
 *   data?: null|ProfileCompletionAccepted|ProfileCompletionAcceptedShape,
 *   error?: null|ErrorDetail|ErrorDetailShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseOfProfileCompletionAccepted implements BaseModel
{
    /** @use SdkModel<APIResponseOfProfileCompletionAcceptedShape> */
    use SdkModel;

    /**
     * Response acknowledging that profile completion has been accepted and started in the background.
     * The provided webhook URL will be called when processing finishes.
     */
    #[Optional(nullable: true)]
    public ?ProfileCompletionAccepted $data;

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
     * @param ProfileCompletionAccepted|ProfileCompletionAcceptedShape|null $data
     * @param ErrorDetail|ErrorDetailShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        ProfileCompletionAccepted|array|null $data = null,
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
     * Response acknowledging that profile completion has been accepted and started in the background.
     * The provided webhook URL will be called when processing finishes.
     *
     * @param ProfileCompletionAccepted|ProfileCompletionAcceptedShape|null $data
     */
    public function withData(ProfileCompletionAccepted|array|null $data): self
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
