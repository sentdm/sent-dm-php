<?php

declare(strict_types=1);

namespace SentDm\Webhooks;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Core\Conversion\ListOf;
use SentDm\Webhooks\WebhookUpdateParams\SenderProfile;

/**
 * Updates an existing webhook for the authenticated customer. Its version does not change. sender_profile applies to a version 1 webhook and is_inheritable to a version 2 one; retry_count and timeout_seconds apply to version 1 only. A version 1 webhook's response returns its sender_profile selection as saved; a version 2 webhook's response leaves sender_profile out.
 *
 * @see SentDm\Services\WebhooksService::update()
 *
 * @phpstan-import-type SenderProfileShape from \SentDm\Webhooks\WebhookUpdateParams\SenderProfile
 *
 * @phpstan-type WebhookUpdateParamsShape = array{
 *   displayName?: string|null,
 *   endpointURL?: string|null,
 *   eventFilters?: array<string,list<string>>|null,
 *   eventTypes?: list<string>|null,
 *   isInheritable?: bool|null,
 *   retryCount?: int|null,
 *   sandbox?: bool|null,
 *   senderProfile?: null|SenderProfile|SenderProfileShape,
 *   timeoutSeconds?: int|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class WebhookUpdateParams implements BaseModel
{
    /** @use SdkModel<WebhookUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

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

    /**
     * Makes this webhook inheritable by the organization's sender profiles (see create), or stops it being
     * inheritable. Omit or pass null to keep it as it is. Only a version 2 webhook can be inheritable.
     */
    #[Optional('is_inheritable', nullable: true)]
    public ?bool $isInheritable;

    #[Optional('retry_count')]
    public ?int $retryCount;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    /**
     * Request-only: the events an organization webhook's sender profile clones receive, one clone per existing
     * and future profile. A version 1 webhook's responses report it as WebhookSenderProfileV3Response.
     */
    #[Optional('sender_profile', nullable: true)]
    public ?SenderProfile $senderProfile;

    #[Optional('timeout_seconds')]
    public ?int $timeoutSeconds;

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
     * @param array<string,list<string>>|null $eventFilters
     * @param list<string>|null $eventTypes
     * @param SenderProfile|SenderProfileShape|null $senderProfile
     */
    public static function with(
        ?string $displayName = null,
        ?string $endpointURL = null,
        ?array $eventFilters = null,
        ?array $eventTypes = null,
        ?bool $isInheritable = null,
        ?int $retryCount = null,
        ?bool $sandbox = null,
        SenderProfile|array|null $senderProfile = null,
        ?int $timeoutSeconds = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $endpointURL && $self['endpointURL'] = $endpointURL;
        null !== $eventFilters && $self['eventFilters'] = $eventFilters;
        null !== $eventTypes && $self['eventTypes'] = $eventTypes;
        null !== $isInheritable && $self['isInheritable'] = $isInheritable;
        null !== $retryCount && $self['retryCount'] = $retryCount;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $senderProfile && $self['senderProfile'] = $senderProfile;
        null !== $timeoutSeconds && $self['timeoutSeconds'] = $timeoutSeconds;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

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

    /**
     * Makes this webhook inheritable by the organization's sender profiles (see create), or stops it being
     * inheritable. Omit or pass null to keep it as it is. Only a version 2 webhook can be inheritable.
     */
    public function withIsInheritable(?bool $isInheritable): self
    {
        $self = clone $this;
        $self['isInheritable'] = $isInheritable;

        return $self;
    }

    public function withRetryCount(int $retryCount): self
    {
        $self = clone $this;
        $self['retryCount'] = $retryCount;

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
     * Request-only: the events an organization webhook's sender profile clones receive, one clone per existing
     * and future profile. A version 1 webhook's responses report it as WebhookSenderProfileV3Response.
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

    public function withTimeoutSeconds(int $timeoutSeconds): self
    {
        $self = clone $this;
        $self['timeoutSeconds'] = $timeoutSeconds;

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
