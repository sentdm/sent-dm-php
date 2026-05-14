<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Updates a contact's default channel and/or opt-out status. Inherited contacts cannot be updated.
 *
 * @see SentDm\Services\ContactsService::update()
 *
 * @phpstan-type ContactUpdateParamsShape = array{
 *   defaultChannel?: string|null,
 *   optOut?: bool|null,
 *   sandbox?: bool|null,
 *   idempotencyKey?: string|null,
 *   xProfileID?: string|null,
 * }
 */
final class ContactUpdateParams implements BaseModel
{
    /** @use SdkModel<ContactUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Default messaging channel: "sms" or "whatsapp".
     */
    #[Optional('default_channel', nullable: true)]
    public ?string $defaultChannel;

    /**
     * Whether the contact has opted out of messaging. Single source of truth — opt-out is
     * per-contact, not per-channel.
     */
    #[Optional('opt_out', nullable: true)]
    public ?bool $optOut;

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
        ?string $defaultChannel = null,
        ?bool $optOut = null,
        ?bool $sandbox = null,
        ?string $idempotencyKey = null,
        ?string $xProfileID = null,
    ): self {
        $self = new self;

        null !== $defaultChannel && $self['defaultChannel'] = $defaultChannel;
        null !== $optOut && $self['optOut'] = $optOut;
        null !== $sandbox && $self['sandbox'] = $sandbox;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    /**
     * Default messaging channel: "sms" or "whatsapp".
     */
    public function withDefaultChannel(?string $defaultChannel): self
    {
        $self = clone $this;
        $self['defaultChannel'] = $defaultChannel;

        return $self;
    }

    /**
     * Whether the contact has opted out of messaging. Single source of truth — opt-out is
     * per-contact, not per-channel.
     */
    public function withOptOut(?bool $optOut): self
    {
        $self = clone $this;
        $self['optOut'] = $optOut;

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
