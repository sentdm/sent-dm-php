<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;
use SentDm\Webhooks\WebhookResponse\SenderProfile;

/**
 * @phpstan-import-type SenderProfileShape from \SentDm\Webhooks\WebhookResponse\SenderProfile
 *
 * @phpstan-type WebhookResponseShape = array{
 *   id?: string|null,
 *   consecutiveFailures?: int|null,
 *   createdAt?: \DateTimeInterface|null,
 *   customerID?: string|null,
 *   displayName?: string|null,
 *   endpointURL?: string|null,
 *   eventFilters?: array<string,list<string>>|null,
 *   eventTypes?: list<string>|null,
 *   isActive?: bool|null,
 *   isInheritable?: bool|null,
 *   lastDeliveryAttemptAt?: \DateTimeInterface|null,
 *   lastSuccessfulDeliveryAt?: \DateTimeInterface|null,
 *   retryCount?: int|null,
 *   senderProfile?: null|SenderProfile|SenderProfileShape,
 *   signingSecret?: string|null,
 *   timeoutSeconds?: int|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   webhookVersion?: int|null,
 * }
 */
final class WebhookResponse implements BaseModel
{
    /** @use SdkModel<WebhookResponseShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    /**
     * Failed attempts since the last success. Version 1 only: always 0 on a version 2 webhook, whose deliveries
     * are in its events (GET /v3/webhooks/{id}/events).
     */
    #[Optional('consecutive_failures')]
    public ?int $consecutiveFailures;

    #[Optional('created_at')]
    public ?\DateTimeInterface $createdAt;

    /**
     * Which customer owns this — the key's own, or the profile named in x-profile-id. Says whose
     * resource this is, which the resource's own id does not.
     */
    #[Optional('customer_id')]
    public ?string $customerID;

    #[Optional('display_name')]
    public ?string $displayName;

    #[Optional('endpoint_url')]
    public ?string $endpointURL;

    /** @var array<string,list<string>>|null $eventFilters */
    #[Optional('event_filters', map: new ListOf('string'), nullable: true)]
    public ?array $eventFilters;

    /** @var list<string>|null $eventTypes */
    #[Optional('event_types', list: 'string')]
    public ?array $eventTypes;

    #[Optional('is_active')]
    public ?bool $isActive;

    /**
     * Whether the webhook also receives its organization's sender profiles' events, and each profile sees it and
     * reads the events about itself. Always false on a version 1 webhook.
     */
    #[Optional('is_inheritable')]
    public ?bool $isInheritable;

    /**
     * When the webhook was last attempted. Version 1 only: always null on a version 2 webhook.
     */
    #[Optional('last_delivery_attempt_at', nullable: true)]
    public ?\DateTimeInterface $lastDeliveryAttemptAt;

    /**
     * When the webhook last received an event. Version 1 only: always null on a version 2 webhook.
     */
    #[Optional('last_successful_delivery_at', nullable: true)]
    public ?\DateTimeInterface $lastSuccessfulDeliveryAt;

    #[Optional('retry_count')]
    public ?int $retryCount;

    /**
     * The events a version 1 webhook's sender profile clones receive, as a response reports them.
     *
     * Its own type, field for field the same as the request's sender_profile. A response is not
     * a request, whatever it carries.
     */
    #[Optional('sender_profile', nullable: true)]
    public ?SenderProfile $senderProfile;

    #[Optional('signing_secret', nullable: true)]
    public ?string $signingSecret;

    #[Optional('timeout_seconds')]
    public ?int $timeoutSeconds;

    #[Optional('updated_at', nullable: true)]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Who delivers the webhook: 1 the older delivery, which will be retired, or 2 Svix. A webhook is
     * created as version 2 unless the request asks for 1.
     */
    #[Optional('webhook_version')]
    public ?int $webhookVersion;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,list<string>>|null $eventFilters
     * @param list<string>|null $eventTypes
     * @param SenderProfile|SenderProfileShape|null $senderProfile
     */
    public static function with(
        ?string $id = null,
        ?int $consecutiveFailures = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $customerID = null,
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventFilters = null,
        ?array $eventTypes = null,
        ?bool $isActive = null,
        ?bool $isInheritable = null,
        ?\DateTimeInterface $lastDeliveryAttemptAt = null,
        ?\DateTimeInterface $lastSuccessfulDeliveryAt = null,
        ?int $retryCount = null,
        SenderProfile|array|null $senderProfile = null,
        ?string $signingSecret = null,
        ?int $timeoutSeconds = null,
        ?\DateTimeInterface $updatedAt = null,
        ?int $webhookVersion = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $consecutiveFailures && $self['consecutiveFailures'] = $consecutiveFailures;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $customerID && $self['customerID'] = $customerID;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $endpointURL && $self['endpointURL'] = $endpointURL;
        null !== $eventFilters && $self['eventFilters'] = $eventFilters;
        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $isActive && $self['isActive'] = $isActive;
        null !== $isInheritable && $self['isInheritable'] = $isInheritable;
        null !== $lastDeliveryAttemptAt && $self['lastDeliveryAttemptAt'] = $lastDeliveryAttemptAt;
        null !== $lastSuccessfulDeliveryAt && $self['lastSuccessfulDeliveryAt'] = $lastSuccessfulDeliveryAt;
        null !== $retryCount && $self['retryCount'] = $retryCount;
        null !== $senderProfile && $self['senderProfile'] = $senderProfile;
        null !== $signingSecret && $self['signingSecret'] = $signingSecret;
        null !== $timeoutSeconds && $self['timeoutSeconds'] = $timeoutSeconds;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $webhookVersion && $self['webhookVersion'] = $webhookVersion;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Failed attempts since the last success. Version 1 only: always 0 on a version 2 webhook, whose deliveries
     * are in its events (GET /v3/webhooks/{id}/events).
     */
    public function withConsecutiveFailures(int $consecutiveFailures): self
    {
        $self = clone $this;
        $self['consecutiveFailures'] = $consecutiveFailures;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Which customer owns this — the key's own, or the profile named in x-profile-id. Says whose
     * resource this is, which the resource's own id does not.
     */
    public function withCustomerID(string $customerID): self
    {
        $self = clone $this;
        $self['customerID'] = $customerID;

        return $self;
    }

    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    public function withEndpointURL(string $endpointURL): self
    {
        $self = clone $this;
        $self['endpointURL'] = $endpointURL;

        return $self;
    }

    /**
     * @param array<string,list<string>>|null $eventFilters
     */
    public function withEventFilters(?array $eventFilters): self
    {
        $self = clone $this;
        $self['eventFilters'] = $eventFilters;

        return $self;
    }

    /**
     * @param list<string> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    public function withIsActive(bool $isActive): self
    {
        $self = clone $this;
        $self['isActive'] = $isActive;

        return $self;
    }

    /**
     * Whether the webhook also receives its organization's sender profiles' events, and each profile sees it and
     * reads the events about itself. Always false on a version 1 webhook.
     */
    public function withIsInheritable(bool $isInheritable): self
    {
        $self = clone $this;
        $self['isInheritable'] = $isInheritable;

        return $self;
    }

    /**
     * When the webhook was last attempted. Version 1 only: always null on a version 2 webhook.
     */
    public function withLastDeliveryAttemptAt(
        ?\DateTimeInterface $lastDeliveryAttemptAt
    ): self {
        $self = clone $this;
        $self['lastDeliveryAttemptAt'] = $lastDeliveryAttemptAt;

        return $self;
    }

    /**
     * When the webhook last received an event. Version 1 only: always null on a version 2 webhook.
     */
    public function withLastSuccessfulDeliveryAt(
        ?\DateTimeInterface $lastSuccessfulDeliveryAt
    ): self {
        $self = clone $this;
        $self['lastSuccessfulDeliveryAt'] = $lastSuccessfulDeliveryAt;

        return $self;
    }

    public function withRetryCount(int $retryCount): self
    {
        $self = clone $this;
        $self['retryCount'] = $retryCount;

        return $self;
    }

    /**
     * The events a version 1 webhook's sender profile clones receive, as a response reports them.
     *
     * Its own type, field for field the same as the request's sender_profile. A response is not
     * a request, whatever it carries.
     *
     * @param SenderProfile|SenderProfileShape|null $senderProfile
     */
    public function withSenderProfile(
        SenderProfile|array|null $senderProfile
    ): self {
        $self = clone $this;
        $self['senderProfile'] = $senderProfile;

        return $self;
    }

    public function withSigningSecret(?string $signingSecret): self
    {
        $self = clone $this;
        $self['signingSecret'] = $signingSecret;

        return $self;
    }

    public function withTimeoutSeconds(int $timeoutSeconds): self
    {
        $self = clone $this;
        $self['timeoutSeconds'] = $timeoutSeconds;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Who delivers the webhook: 1 the older delivery, which will be retired, or 2 Svix. A webhook is
     * created as version 2 unless the request asks for 1.
     */
    public function withWebhookVersion(int $webhookVersion): self
    {
        $self = clone $this;
        $self['webhookVersion'] = $webhookVersion;

        return $self;
    }
}
