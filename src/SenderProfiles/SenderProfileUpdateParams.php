<?php

declare(strict_types=1);

namespace SentDm\SenderProfiles;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Changes a profile's own attributes: `name`, `short_name`, `description` and `notifications` (who is emailed about the profile's events — `ORGANIZATION`, `SENDER_PROFILE`, or `ORGANIZATION_AND_SENDER_PROFILE`).
 *
 * **Only those.** A profile's identity, its markets and its compliance each have a sub-resource of their own, because each has its own validation and its own external consequences — a brand change may need re-registering, a market change provisions a sender. Folding them in here would give those fields two writers and no way to say which one wins.
 *
 * Omitting a field leaves it alone; sending `null` clears it. Those are different requests, so `{}` changes nothing and is refused rather than silently accepted — a caller who misspelt every field would otherwise get a `200` and an unchanged profile.
 *
 * `name` and `short_name` cannot be cleared: `short_name` is the SMS sender id, so a supplied value must be 3–11 characters of letters, numbers and spaces with at least one letter.
 *
 * Returns the profile as `GET /v3/sender-profiles/{id}` would, so the result of the change needs no second call to see.
 *
 * @see SentDm\Services\SenderProfilesService::update()
 *
 * @phpstan-type SenderProfileUpdateParamsShape = array{
 *   description?: string|null,
 *   name?: string|null,
 *   notifications?: string|null,
 *   sandbox?: bool|null,
 *   shortName?: string|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class SenderProfileUpdateParams implements BaseModel
{
    /** @use SdkModel<SenderProfileUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional(nullable: true)]
    public ?string $description;

    #[Optional]
    public ?string $name;

    /**
     * Who is notified about this profile's events: ORGANIZATION, SENDER_PROFILE, or
     * ORGANIZATION_AND_SENDER_PROFILE. Cannot be cleared — a supplied value must be one of those.
     */
    #[Optional(nullable: true)]
    public ?string $notifications;

    /**
     * Sandbox flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional]
    public ?bool $sandbox;

    #[Optional('short_name', nullable: true)]
    public ?string $shortName;

    #[Optional]
    public ?string $idempotencyKey;

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
        ?string $description = null,
        ?string $name = null,
        ?string $notifications = null,
        ?bool $sandbox = null,
        ?string $shortName = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $name && $self['name'] = $name;
        null !== $notifications && $self['notifications'] = $notifications;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $shortName && $self['shortName'] = $shortName;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Who is notified about this profile's events: ORGANIZATION, SENDER_PROFILE, or
     * ORGANIZATION_AND_SENDER_PROFILE. Cannot be cleared — a supplied value must be one of those.
     */
    public function withNotifications(?string $notifications): self
    {
        $self = clone $this;
        $self['notifications'] = $notifications;

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

    public function withShortName(?string $shortName): self
    {
        $self = clone $this;
        $self['shortName'] = $shortName;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
