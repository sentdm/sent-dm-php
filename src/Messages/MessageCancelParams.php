<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Calls off a message you scheduled with `scheduled_at`, before it is released for sending. The message moves to `CANCELLED`, which is terminal, and it is never sent.
 *
 * **Only a SCHEDULED message can be cancelled.** A message that has already been released — queued, in flight, or finished — returns 409. The release sweeper runs continuously, so a cancellation sent within about a minute of the scheduled instant can lose that race and be refused; cancel with time to spare.
 *
 * **One message per call.** A send to many recipients, or on several channels, becomes one message per recipient × channel, each with its own id; cancel the ones you want stopped. There is no bulk cancellation.
 *
 * **Cancelling is free**, and nothing was charged for the hold in the first place — a scheduled message is only priced and billed at release.
 *
 * **A cancellation fires `message.cancelled`** on your webhook, exactly once, carrying the `scheduled_at` that was called off so a consumer can un-record the send it was expecting. Cancelling the same message again returns this same response and fires no second event. `Idempotency-Key` is honoured.
 *
 * A cancelled message cannot be resent — send a new one.
 *
 * The response is the message itself, in the same shape `GET /v3/messages/{id}` returns, so the `status` you read back is the one now stored on the row, and `scheduled_at` is the time it would have gone out. `GET /v3/messages/{id}` keeps reporting both afterwards.
 *
 * `events` is the message lifecycle as it stood immediately before the cancellation: the CANCELLED entry is written asynchronously and lands a moment later, so read `status` for the outcome. If you need the entry itself, re-fetch the message after a few seconds — `GET /v3/messages/{id}` is cached briefly, so an immediate re-fetch can still show the pre-cancellation state.
 *
 * @see SentDm\Services\MessagesService::cancel()
 *
 * @phpstan-type MessageCancelParamsShape = array{
 *   sandbox?: bool|null, idempotencyKey?: string|null, xProfileID?: string|null
 * }
 */
final class MessageCancelParams implements BaseModel
{
    /** @use SdkModel<MessageCancelParamsShape> */
    use SdkModel;
    use SdkParams;

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
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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
