<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageSendResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageSendResponse\Data\Recipient;

/**
 * The result of a multi-recipient send.
 *
 * Declared here rather than in the service layer. POST /v3/messages used to publish
 * MessageSendResult — a type in Common.Services.Messaging.Contracts — so the public contract was
 * whatever the send service happened to return, and changing that service for an internal reason changed the
 * API. The service keeps its result; this is what a caller sees, and the mapping between them is a decision the
 * endpoint makes.
 *
 * The wire is unchanged by the move: same names, same values.
 *
 * @phpstan-import-type RecipientShape from \SentDm\Messages\MessageSendResponse\Data\Recipient
 *
 * @phpstan-type DataShape = array{
 *   recipients?: list<Recipient|RecipientShape>|null,
 *   status?: string|null,
 *   templateID?: string|null,
 *   templateName?: string|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /** @var list<Recipient>|null $recipients */
    #[Optional(list: Recipient::class)]
    public ?array $recipients;

    /**
     * Overall status — QUEUED once the batch is accepted for delivery.
     */
    #[Optional]
    public ?string $status;

    #[Optional('template_id')]
    public ?string $templateID;

    #[Optional('template_name')]
    public ?string $templateName;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Recipient|RecipientShape>|null $recipients
     */
    public static function with(
        ?array $recipients = null,
        ?string $status = null,
        ?string $templateID = null,
        ?string $templateName = null,
    ): self {
        $self = new self;

        null !== $recipients && $self['recipients'] = $recipients;
        null !== $status && $self['status'] = $status;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateName && $self['templateName'] = $templateName;

        return $self;
    }

    /**
     * @param list<Recipient|RecipientShape> $recipients
     */
    public function withRecipients(array $recipients): self
    {
        $self = clone $this;
        $self['recipients'] = $recipients;

        return $self;
    }

    /**
     * Overall status — QUEUED once the batch is accepted for delivery.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withTemplateID(string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

        return $self;
    }

    public function withTemplateName(string $templateName): self
    {
        $self = clone $this;
        $self['templateName'] = $templateName;

        return $self;
    }
}
