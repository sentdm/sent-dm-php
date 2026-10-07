<?php

declare(strict_types=1);

namespace SentDm\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Starts or stops recording one of your live calls. Use start to begin recording mid-call, or stop to end a recording, whether it was started here or by a connect answer with record set. A call that has already ended answers 409, and so does a call with no phone leg, such as one between two app users, which can't be recorded.
 *
 * @see SentDm\Services\CallsService::record()
 *
 * @phpstan-type CallRecordParamsShape = array{
 *   action?: string|null,
 *   apiKey?: string|null,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class CallRecordParams implements BaseModel
{
    /** @use SdkModel<CallRecordParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * start to begin recording, stop to end it.
     */
    #[Optional]
    public ?string $action;

    /**
     * API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     */
    #[Optional]
    public ?string $apiKey;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional]
    public ?string $idempotencyKey;

    #[Optional]
    public ?string $xProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $action = null,
        ?string $apiKey = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $action && $self['action'] = $action;
        null !== $apiKey && $self['apiKey'] = $apiKey;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * start to begin recording, stop to end it.
     */
    public function withAction(string $action): self
    {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    /**
     * API key from the x-api-key header, or empty when the caller sent it as
     * Authorization: Bearer instead.
     *
     * Optional on purpose. CustomerV3AuthenticationHandler accepts the key in either header,
     * and [FromHeader] is required by default, so a Bearer-only request would authenticate and then be
     * refused with a 400 for a header it never needed. Endpoints read the customer from the CustomerId
     * claim, not from this value.
     */
    public function withAPIKey(string $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withSandbox(bool $sandbox): self
    {
        $self = clone $this;
        $self['sandbox'] = $sandbox;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
