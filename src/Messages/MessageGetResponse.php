<?php

declare(strict_types=1);

namespace SentDm\Messages;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageGetResponse\Event;
use SentDm\Messages\MessageGetResponse\MessageBody;

/**
 * Represents a sent message with comprehensive delivery and template information (v2).
 *
 * @phpstan-import-type EventShape from \SentDm\Messages\MessageGetResponse\Event
 * @phpstan-import-type MessageBodyShape from \SentDm\Messages\MessageGetResponse\MessageBody
 *
 * @phpstan-type MessageGetResponseShape = array{
 *   id?: string|null,
 *   channel?: string|null,
 *   contactID?: string|null,
 *   correctedPrice?: float|null,
 *   createdAt?: \DateTimeInterface|null,
 *   customerID?: string|null,
 *   events?: list<Event|EventShape>|null,
 *   messageBody?: null|MessageBody|MessageBodyShape,
 *   phoneNumber?: string|null,
 *   phoneNumberInternational?: string|null,
 *   regionCode?: string|null,
 *   status?: string|null,
 *   templateCategory?: string|null,
 *   templateID?: string|null,
 *   templateName?: string|null,
 * }
 */
final class MessageGetResponse implements BaseModel
{
    /** @use SdkModel<MessageGetResponseShape> */
    use SdkModel;

    /**
     * The unique identifier of the message.
     */
    #[Optional]
    public ?string $id;

    /**
     * The messaging channel used (e.g., SMS, WhatsApp).
     */
    #[Optional]
    public ?string $channel;

    /**
     * The unique identifier of the contact who received the message.
     */
    #[Optional('contactId')]
    public ?string $contactID;

    /**
     * The final price charged for sending this message.
     */
    #[Optional(nullable: true)]
    public ?float $correctedPrice;

    /**
     * The date and time when the message was created.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * The unique identifier of the customer who sent the message.
     */
    #[Optional('customerId')]
    public ?string $customerID;

    /**
     * A chronological list of status change events for this message.
     * Each event includes a status and timestamp, following industry standards (Twilio, SendGrid, Mailgun).
     * Events are ordered chronologically from oldest to newest.
     *
     * @var list<Event>|null $events
     */
    #[Optional(list: Event::class, nullable: true)]
    public ?array $events;

    /**
     * The message body content with variables substituted.
     */
    #[Optional(nullable: true)]
    public ?MessageBody $messageBody;

    /**
     * The phone number of the recipient (E.164 format).
     */
    #[Optional]
    public ?string $phoneNumber;

    /**
     * The phone number in international format.
     */
    #[Optional]
    public ?string $phoneNumberInternational;

    /**
     * The region code of the phone number (e.g., US, GB, DE).
     */
    #[Optional]
    public ?string $regionCode;

    /**
     * The delivery status of the message (e.g., sent, delivered, failed, read).
     */
    #[Optional]
    public ?string $status;

    /**
     * The category of the template (e.g., MARKETING, UTILITY, AUTHENTICATION).
     */
    #[Optional]
    public ?string $templateCategory;

    /**
     * The unique identifier of the template used for this message (null if no template was used).
     */
    #[Optional('templateId', nullable: true)]
    public ?string $templateID;

    /**
     * The display name of the template.
     */
    #[Optional]
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
     * @param list<Event|EventShape>|null $events
     * @param MessageBody|MessageBodyShape|null $messageBody
     */
    public static function with(
        ?string $id = null,
        ?string $channel = null,
        ?string $contactID = null,
        ?float $correctedPrice = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $customerID = null,
        ?array $events = null,
        MessageBody|array|null $messageBody = null,
        ?string $phoneNumber = null,
        ?string $phoneNumberInternational = null,
        ?string $regionCode = null,
        ?string $status = null,
        ?string $templateCategory = null,
        ?string $templateID = null,
        ?string $templateName = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $channel && $self['channel'] = $channel;
        null !== $contactID && $self['contactID'] = $contactID;
        null !== $correctedPrice && $self['correctedPrice'] = $correctedPrice;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $events && $self['events'] = $events;
        null !== $messageBody && $self['messageBody'] = $messageBody;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $phoneNumberInternational && $self['phoneNumberInternational'] = $phoneNumberInternational;
        null !== $regionCode && $self['regionCode'] = $regionCode;
        null !== $status && $self['status'] = $status;
        null !== $templateCategory && $self['templateCategory'] = $templateCategory;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateName && $self['templateName'] = $templateName;

        return $self;
    }

    /**
     * The unique identifier of the message.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The messaging channel used (e.g., SMS, WhatsApp).
     */
    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * The unique identifier of the contact who received the message.
     */
    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }

    /**
     * The final price charged for sending this message.
     */
    public function withCorrectedPrice(?float $correctedPrice): self
    {
        $self = clone $this;
        $self['correctedPrice'] = $correctedPrice;

        return $self;
    }

    /**
     * The date and time when the message was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The unique identifier of the customer who sent the message.
     */
    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    /**
     * A chronological list of status change events for this message.
     * Each event includes a status and timestamp, following industry standards (Twilio, SendGrid, Mailgun).
     * Events are ordered chronologically from oldest to newest.
     *
     * @param list<Event|EventShape>|null $events
     */
    public function withEvents(?array $events): self
    {
        $self = clone $this;
        $self['events'] = $events;

        return $self;
    }

    /**
     * The message body content with variables substituted.
     *
     * @param MessageBody|MessageBodyShape|null $messageBody
     */
    public function withMessageBody(MessageBody|array|null $messageBody): self
    {
        $self = clone $this;
        $self['messageBody'] = $messageBody;

        return $self;
    }

    /**
     * The phone number of the recipient (E.164 format).
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * The phone number in international format.
     */
    public function withPhoneNumberInternational(
        string $phoneNumberInternational
    ): self {
        $self = clone $this;
        $self['phoneNumberInternational'] = $phoneNumberInternational;

        return $self;
    }

    /**
     * The region code of the phone number (e.g., US, GB, DE).
     */
    public function withRegionCode(string $regionCode): self
    {
        $self = clone $this;
        $self['regionCode'] = $regionCode;

        return $self;
    }

    /**
     * The delivery status of the message (e.g., sent, delivered, failed, read).
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The category of the template (e.g., MARKETING, UTILITY, AUTHENTICATION).
     */
    public function withTemplateCategory(string $templateCategory): self
    {
        $self = clone $this;
        $self['templateCategory'] = $templateCategory;

        return $self;
    }

    /**
     * The unique identifier of the template used for this message (null if no template was used).
     */
    public function withTemplateID(?string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

        return $self;
    }

    /**
     * The display name of the template.
     */
    public function withTemplateName(string $templateName): self
    {
        $self = clone $this;
        $self['templateName'] = $templateName;

        return $self;
    }
}
