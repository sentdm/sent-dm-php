<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageSendResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageSendResponse\Data\Recipient;

/**
 * Response for the multi-recipient send message endpoint.
 *
 * @phpstan-import-type RecipientShape from \SentDm\Messages\MessageSendResponse\Data\Recipient
 *
 * @phpstan-type DataShape = array{
 *   body?: string|null,
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

    /**
     * Resolved template body text.
     */
    #[Optional(nullable: true)]
    public ?string $body;

    /**
     * Per-recipient message results.
     *
     * @var list<Recipient>|null $recipients
     */
    #[Optional(list: Recipient::class)]
    public ?array $recipients;

    /**
     * Overall request status (e.g. "accepted").
     */
    #[Optional]
    public ?string $status;

    /**
     * Template ID that was used.
     */
    #[Optional('template_id')]
    public ?string $templateID;

    /**
     * Template display name.
     */
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
        ?string $body = null,
        ?array $recipients = null,
        ?string $status = null,
        ?string $templateID = null,
        ?string $templateName = null,
    ): self {
        $self = new self;

        null !== $body && $self['body'] = $body;
        null !== $recipients && $self['recipients'] = $recipients;
        null !== $status && $self['status'] = $status;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateName && $self['templateName'] = $templateName;

        return $self;
    }

    /**
     * Resolved template body text.
     */
    public function withBody(?string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Per-recipient message results.
     *
     * @param list<Recipient|RecipientShape> $recipients
     */
    public function withRecipients(array $recipients): self
    {
        $self = clone $this;
        $self['recipients'] = $recipients;

        return $self;
    }

    /**
     * Overall request status (e.g. "accepted").
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Template ID that was used.
     */
    public function withTemplateID(string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

        return $self;
    }

    /**
     * Template display name.
     */
    public function withTemplateName(string $templateName): self
    {
        $self = clone $this;
        $self['templateName'] = $templateName;

        return $self;
    }
}
