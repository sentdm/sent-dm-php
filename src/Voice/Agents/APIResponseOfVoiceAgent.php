<?php

declare(strict_types=1);

namespace SentDm\Voice\Agents;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Webhooks\APIMeta;
use SentDm\Webhooks\ErrorDetail;

/**
 * Standard API response envelope for all v3 endpoints.
 *
 * @phpstan-import-type VoiceAgentShape from \SentDm\Voice\Agents\VoiceAgent
 * @phpstan-import-type ErrorDetailShape from \SentDm\Webhooks\ErrorDetail
 * @phpstan-import-type APIMetaShape from \SentDm\Webhooks\APIMeta
 *
 * @phpstan-type APIResponseOfVoiceAgentShape = array{
 *   data?: null|VoiceAgent|VoiceAgentShape,
 *   error?: null|ErrorDetail|ErrorDetailShape,
 *   meta?: null|APIMeta|APIMetaShape,
 *   success?: bool|null,
 * }
 */
final class APIResponseOfVoiceAgent implements BaseModel
{
    /** @use SdkModel<APIResponseOfVoiceAgentShape> */
    use SdkModel;

    /**
     * A voice agent as stored: what was written with every default filled in, plus the signing secret the one
     * time it is shown (on create, and on rotate). The one shape every read of an agent answers with, on
     * /v3/voice/agents and on the admin API the dashboard uses, so the two cannot drift.
     */
    #[Optional(nullable: true)]
    public ?VoiceAgent $data;

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
     * @param VoiceAgent|VoiceAgentShape|null $data
     * @param ErrorDetail|ErrorDetailShape|null $error
     * @param APIMeta|APIMetaShape|null $meta
     */
    public static function with(
        VoiceAgent|array|null $data = null,
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
     * A voice agent as stored: what was written with every default filled in, plus the signing secret the one
     * time it is shown (on create, and on rotate). The one shape every read of an agent answers with, on
     * /v3/voice/agents and on the admin API the dashboard uses, so the two cannot drift.
     *
     * @param VoiceAgent|VoiceAgentShape|null $data
     */
    public function withData(VoiceAgent|array|null $data): self
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
