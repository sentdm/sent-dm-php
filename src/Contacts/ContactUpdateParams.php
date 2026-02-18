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
 *   testMode?: bool|null,
 *   idempotencyKey?: string|null,
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
     * Whether the contact has opted out of messaging.
     */
    #[Optional('opt_out', nullable: true)]
    public ?bool $optOut;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

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
        ?string $defaultChannel = null,
        ?bool $optOut = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $defaultChannel && $self['defaultChannel'] = $defaultChannel;
        null !== $optOut && $self['optOut'] = $optOut;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

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
     * Whether the contact has opted out of messaging.
     */
    public function withOptOut(?bool $optOut): self
    {
        $self = clone $this;
        $self['optOut'] = $optOut;

        return $self;
    }

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withTestMode(bool $testMode): self
    {
        $self = clone $this;
        $self['testMode'] = $testMode;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
