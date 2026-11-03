<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Resends a message you already sent, on the same message id, without rebuilding the request. The typical use is recovering a BLOCKED message — for example one refused for insufficient balance — after the account has been topped up.
 *
 * **A resend bills again.** Each accepted resend is a new delivery attempt and records a new charge against the same message id; a client that resends on every failure is charged on every loop.
 *
 * **Every policy runs again.** The resend goes back through the full send pipeline — consent, balance, KYC and channel quota, template approval, quiet hours and channel health — so it can land on BLOCKED, FILTERED or SCHEDULED again rather than being sent, exactly as a fresh send would. Status webhooks (message.sent, message.blocked, message.filtered, message.failed) fire again for the same message id, so consumers keyed on the id will see repeated transitions.
 *
 * **What can be resent.** A message in a terminal state — DELIVERED, FAILED, READ or BLOCKED — or one stuck at SENT for more than 15 minutes. A FILTERED message can never be resent: the recipient opted out or a routing rule refused the send. A message still in flight (QUEUED, PROCESSED, ROUTED), held for quiet hours (SCHEDULED), or SENT less than 15 minutes ago returns 409. Two concurrent resends of one id are serialised: one is accepted, the other gets 409.
 *
 * The resend keeps the channel the message was originally requested on; the channel cannot be changed on a resend — send a new message instead. `Idempotency-Key` is honoured, so a retried request replays the first accepted response instead of resending twice.
 *
 * The response has the same shape as `POST /v3/messages`: `recipients` has a single entry whose `message_id` is the id you resent.
 *
 * @see SentDm\Services\MessagesService::resend()
 *
 * @phpstan-type MessageResendParamsShape = array{
 *   sandbox?: bool|null, idempotencyKey?: string|null, xProfileID?: string|null
 * }
 */
final class MessageResendParams implements BaseModel
{
    /** @use SdkModel<MessageResendParamsShape> */
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
