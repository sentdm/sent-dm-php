<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new contact by phone number and associates it with the authenticated customer.
 *
 * @see SentDm\Services\ContactsService::create()
 *
 * @phpstan-type ContactCreateParamsShape = array{
 *   phoneNumber?: string|null, testMode?: bool|null, idempotencyKey?: string|null
 * }
 */
final class ContactCreateParams implements BaseModel
{
    /** @use SdkModel<ContactCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Phone number of the contact to create.
     */
    #[Optional('phone_number')]
    public ?string $phoneNumber;

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
        ?string $phoneNumber = null,
        ?bool $testMode = null,
        ?string $idempotencyKey = null,
    ): self {
        $self = new self;

        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Phone number of the contact to create.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

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
