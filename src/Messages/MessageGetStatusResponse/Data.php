<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetStatusResponse;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Messages\MessageGetStatusResponse\Data\Event;
use SentDm\Messages\MessageGetStatusResponse\Data\MessageBody;

/**
 * Message response for v3 API — same shape as v2 with snake_case JSON conventions.
 *
 * @phpstan-import-type EventShape from \SentDm\Messages\MessageGetStatusResponse\Data\Event
 * @phpstan-import-type MessageBodyShape from \SentDm\Messages\MessageGetStatusResponse\Data\MessageBody
 *
 * @phpstan-type DataShape = array{
 *   id?: string|null,
 *   activeContactPrice?: float|null,
 *   channel?: string|null,
 *   contactID?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   customerID?: string|null,
 *   events?: list<Event|EventShape>|null,
 *   messageBody?: null|MessageBody|MessageBodyShape,
 *   phone?: string|null,
 *   phoneInternational?: string|null,
 *   price?: float|null,
 *   regionCode?: string|null,
 *   status?: string|null,
 *   templateCategory?: string|null,
 *   templateID?: string|null,
 *   templateName?: string|null,
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional('active_contact_price', nullable: true)]
    public ?float $activeContactPrice;

    #[Optional]
    public ?string $channel;

    #[Optional('contact_id')]
    public ?string $contactID;

    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    #[Optional('customer_id')]
    public ?string $customerID;

    /** @var list<Event>|null $events */
    #[Optional(list: Event::class, nullable: true)]
    public ?array $events;

    /**
     * Structured message body format for database storage.
     * Preserves channel-specific components (header, body, footer, buttons).
     */
    #[Optional('message_body', nullable: true)]
    public ?MessageBody $messageBody;

    #[Optional]
    public ?string $phone;

    #[Optional('phone_international')]
    public ?string $phoneInternational;

    #[Optional(nullable: true)]
    public ?float $price;

    #[Optional('region_code')]
    public ?string $regionCode;

    #[Optional]
    public ?string $status;

    #[Optional('template_category')]
    public ?string $templateCategory;

    #[Optional('template_id', nullable: true)]
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
     * @param list<Event|EventShape>|null $events
     * @param MessageBody|MessageBodyShape|null $messageBody
     */
    public static function with(
        ?string $id = null,
        ?float $activeContactPrice = null,
        ?string $channel = null,
        ?string $contactID = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $customerID = null,
        ?array $events = null,
        MessageBody|array|null $messageBody = null,
        ?string $phone = null,
        ?string $phoneInternational = null,
        ?float $price = null,
        ?string $regionCode = null,
        ?string $status = null,
        ?string $templateCategory = null,
        ?string $templateID = null,
        ?string $templateName = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $activeContactPrice && $self['activeContactPrice'] = $activeContactPrice;
        null !== $channel && $self['channel'] = $channel;
        null !== $contactID && $self['contactID'] = $contactID;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $events && $self['events'] = $events;
        null !== $messageBody && $self['messageBody'] = $messageBody;
        null !== $phone && $self['phone'] = $phone;
        null !== $phoneInternational && $self['phoneInternational'] = $phoneInternational;
        null !== $price && $self['price'] = $price;
        null !== $regionCode && $self['regionCode'] = $regionCode;
        null !== $status && $self['status'] = $status;
        null !== $templateCategory && $self['templateCategory'] = $templateCategory;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateName && $self['templateName'] = $templateName;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withActiveContactPrice(?float $activeContactPrice): self
    {
        $self = clone $this;
        $self['activeContactPrice'] = $activeContactPrice;

        return $self;
    }

    public function withChannel(string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    /**
     * @param list<Event|EventShape>|null $events
     */
    public function withEvents(?array $events): self
    {
        $self = clone $this;
        $self['events'] = $events;

        return $self;
    }

    /**
     * Structured message body format for database storage.
     * Preserves channel-specific components (header, body, footer, buttons).
     *
     * @param MessageBody|MessageBodyShape|null $messageBody
     */
    public function withMessageBody(MessageBody|array|null $messageBody): self
    {
        $self = clone $this;
        $self['messageBody'] = $messageBody;

        return $self;
    }

    public function withPhone(string $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }

    public function withPhoneInternational(string $phoneInternational): self
    {
        $self = clone $this;
        $self['phoneInternational'] = $phoneInternational;

        return $self;
    }

    public function withPrice(?float $price): self
    {
        $self = clone $this;
        $self['price'] = $price;

        return $self;
    }

    public function withRegionCode(string $regionCode): self
    {
        $self = clone $this;
        $self['regionCode'] = $regionCode;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withTemplateCategory(string $templateCategory): self
    {
        $self = clone $this;
        $self['templateCategory'] = $templateCategory;

        return $self;
    }

    public function withTemplateID(?string $templateID): self
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
