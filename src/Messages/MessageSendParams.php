<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageSendParams\Template;

/**
 * Sends a message to one or more recipients using a template. Supports multi-channel broadcast — when multiple channels are specified (e.g. ["sms", "whatsapp"]), a separate message is created for each (recipient, channel) pair. Returns immediately with per-recipient message IDs for async tracking via webhooks or the GET /messages/{id} endpoint.
 *
 * @see SentDm\Services\MessagesService::send()
 *
 * @phpstan-import-type TemplateShape from \SentDm\Messages\MessageSendParams\Template
 *
 * @phpstan-type MessageSendParamsShape = array{
 *   channel?: list<string>|null,
 *   sandbox?: bool|null,
 *   template?: null|Template|TemplateShape,
 *   to?: list<string>|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class MessageSendParams implements BaseModel
{
    /** @use SdkModel<MessageSendParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Channels to broadcast on, e.g. ["whatsapp", "sms"].
     * Each channel produces a separate message per recipient.
     * "sent" = auto-detect.
     * Defaults to ["sent"] (auto-detect) if omitted.
     *
     * @var list<string>|null $channel
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $channel;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * SDK-style template reference: resolve by ID or by name, with optional parameters.
     */
    #[Optional]
    public ?Template $template;

    /**
     * List of recipient phone numbers in E.164 format (multi-recipient fan-out).
     *
     * @var list<string>|null $to
     */
    #[Optional(list: 'string')]
    public ?array $to;

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
     *
     * @param list<string>|null $channel
     * @param Template|TemplateShape|null $template
     * @param list<string>|null $to
     */
    public static function with(
        ?array $channel = null,
        ?bool $sandbox = null,
        Template|array|null $template = null,
        ?array $to = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $template && $self['template'] = $template;
        null !== $to && $self['to'] = $to;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Channels to broadcast on, e.g. ["whatsapp", "sms"].
     * Each channel produces a separate message per recipient.
     * "sent" = auto-detect.
     * Defaults to ["sent"] (auto-detect) if omitted.
     *
     * @param list<string>|null $channel
     */
    public function withChannel(?array $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

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

    /**
     * SDK-style template reference: resolve by ID or by name, with optional parameters.
     *
     * @param Template|TemplateShape $template
     */
    public function withTemplate(Template|array $template): self
    {
        $self = clone $this;
        $self['template'] = $template;

        return $self;
    }

    /**
     * List of recipient phone numbers in E.164 format (multi-recipient fan-out).
     *
     * @param list<string> $to
     */
    public function withTo(array $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

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
