<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Resends a message you already sent, as a new message, without rebuilding the request. The typical use is recovering a BLOCKED message — for example one refused for insufficient balance — after the account has been topped up.
 *
 * **A resend is a new message.** It gets its own message id, returned in `recipients[0].message_id`, with its own status, delivery attempts and charge. The message you resent is left exactly as it was. Each accepted resend is billed; a client that resends on every failure is charged on every loop.
 *
 * **Every policy runs again.** The resend goes back through the full send pipeline — consent, balance, KYC and channel quota, template approval, quiet hours and channel health — so it can land on BLOCKED, FILTERED or SCHEDULED again rather than being sent, exactly as a fresh send would. Status webhooks (message.queued, message.sent, message.delivered, message.blocked, message.filtered, message.failed) fire for the new message id.
 *
 * **What can be resent.** A message in a terminal state — DELIVERED, FAILED, READ or BLOCKED — or one stuck at SENT for more than 15 minutes. A FILTERED message can never be resent: the recipient opted out or a routing rule refused the send. A message still in flight (QUEUED, PROCESSED, ROUTED), held for quiet hours (SCHEDULED), or SENT less than 15 minutes ago returns 409. A message can be resent more than once, one resend at a time: while an earlier resend of it is still in flight, a new resend returns 409, so a double click or a retried request does not send it twice. Each accepted resend is another new message. A resend can itself be resent; the new message's parent is still the original.
 *
 * The resend keeps the channel the message was originally requested on; the channel cannot be changed on a resend — send a new message instead. `Idempotency-Key` is honoured, so a retried request replays the first accepted response instead of resending twice.
 *
 * The response has the same shape as `POST /v3/messages`: `recipients` has a single entry whose `message_id` is the new message's id.
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
