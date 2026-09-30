<?php

declare(strict_types=1);

namespace SentDm\Webhooks\WebhookListEventsResponse\EventData\SentDmServicesCommonServicesWebhooksContractsWebhookEventOfCallWebhookPayload;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Body of a call.initiated, call.answered, call.completed, call.failed
 * or call.recording_ready event. Which of them occurred is the envelope's event.
 *
 * Shaped like the message, inbound, template and channel payloads: account_id names the
 * account the event is about, channel names the channel, and updated_at is when the change
 * happened on the call, in the same yyyy-MM-ddTHH:mm:ssZ form. duration_seconds and
 * price are added on call.completed, reason on call.failed and
 * recording_id on call.recording_ready; each is omitted rather than sent as null when it
 * does not apply.
 *
 * Casing is snake_case because these ride the same webhook stream customers already parse
 * message_id from; the question/answer contract is a separate surface and stays camelCase.
 * Nothing here is provider-shaped: no provider call id, no namespaced identity.
 *
 * @phpstan-type PayloadShape = array{
 *   callID: string,
 *   accountID?: string|null,
 *   channel?: string|null,
 *   durationSeconds?: int|null,
 *   number?: string|null,
 *   price?: float|null,
 *   reason?: string|null,
 *   recordingID?: string|null,
 *   updatedAt?: string|null,
 * }
 */
final class Payload implements BaseModel
{
    /** @use SdkModel<PayloadShape> */
    use SdkModel;

    /**
     * Sent's call id, the same one the customer saw on the first question.
     */
    #[Required('call_id')]
    public string $callID;

    /**
     * The account the call belongs to: the key's own customer, or the sender profile it acted as.
     */
    #[Optional('account_id')]
    public ?string $accountID;

    /**
     * Always voice.
     */
    #[Optional]
    public ?string $channel;

    /**
     * How long the call lasted. Only on call.completed.
     */
    #[Optional('duration_seconds', nullable: true)]
    public ?int $durationSeconds;

    /**
     * The customer number that owns the call, in E.164 format.
     */
    #[Optional]
    public ?string $number;

    /**
     * What the call was charged. Only on call.completed, and omitted there until billing has
     * recorded the charge.
     */
    #[Optional(nullable: true)]
    public ?float $price;

    /**
     * The machine-readable reason the call did not complete. Only on call.failed, and omitted
     * when no reason was recorded.
     */
    #[Optional(nullable: true)]
    public ?string $reason;

    /**
     * The recording that became available, the same id GET /v3/calls/{id}/recordings lists it
     * under. Only on call.recording_ready, which is sent once per recording.
     */
    #[Optional('recording_id', nullable: true)]
    public ?string $recordingID;

    /**
     * When the change happened on the call, as opposed to when the event was emitted.
     */
    #[Optional('updated_at')]
    public ?string $updatedAt;

    /**
     * `new Payload()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Payload::with(callID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Payload)->withCallID(...)
     * ```
     */
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
        string $callID,
        ?string $accountID = null,
        ?string $channel = null,
        ?int $durationSeconds = null,
        ?string $number = null,
        ?float $price = null,
        ?string $reason = null,
        ?string $recordingID = null,
        ?string $updatedAt = null,
    ): self {
        $self = new self;

        $self['callID'] = $callID;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $channel && $self['channel'] = $channel;
        null !== $durationSeconds && $self['durationSeconds'] = $durationSeconds;
        null !== $number && $self['number'] = $number;
        null !== $price && $self['price'] = $price;
        null !== $reason && $self['reason'] = $reason;
        null !== $recordingID && $self['recordingID'] = $recordingID;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Sent's call id, the same one the customer saw on the first question.
     */
    public function withCallID(string $callID): self
    {
        $self = clone $this;
        $self['callID'] = $callID;

        return $self;
    }

    /**
     * The account the call belongs to: the key's own customer, or the sender profile it acted as.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * Always voice.
     */
    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * How long the call lasted. Only on call.completed.
     */
    public function withDurationSeconds(?int $durationSeconds): self
    {
        $self = clone $this;
        $self['durationSeconds'] = $durationSeconds;

        return $self;
    }

    /**
     * The customer number that owns the call, in E.164 format.
     */
    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * What the call was charged. Only on call.completed, and omitted there until billing has
     * recorded the charge.
     */
    public function withPrice(?float $price): self
    {
        $self = clone $this;
        $self['price'] = $price;

        return $self;
    }

    /**
     * The machine-readable reason the call did not complete. Only on call.failed, and omitted
     * when no reason was recorded.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * The recording that became available, the same id GET /v3/calls/{id}/recordings lists it
     * under. Only on call.recording_ready, which is sent once per recording.
     */
    public function withRecordingID(?string $recordingID): self
    {
        $self = clone $this;
        $self['recordingID'] = $recordingID;

        return $self;
    }

    /**
     * When the change happened on the call, as opposed to when the event was emitted.
     */
    public function withUpdatedAt(string $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
