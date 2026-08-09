<?php

declare(strict_types=1);

namespace SentDm\Contacts;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Returns aggregate message counts, time bounds, channels used, and per-channel success/fail scores (each as a percentage 0-100 of messages on that channel) for one of your contacts. Successful terminal states: SENT/DELIVERED/READ for outbound, RECEIVED for inbound. Fail: FAILED.
 *
 * @see SentDm\Services\ContactsService::retrieveMessageSummary()
 *
 * @phpstan-type ContactRetrieveMessageSummaryParamsShape = array{
 *   xProfileID?: string|null
 * }
 */
final class ContactRetrieveMessageSummaryParams implements BaseModel
{
    /** @use SdkModel<ContactRetrieveMessageSummaryParamsShape> */
    use SdkModel;
    use SdkParams;

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
    public static function with(?string $xProfileID = null): self
    {
        $self = new self;

        null !== $xProfileID && $self['xProfileID'] = $xProfileID;

        return $self;
    }

    public function withXProfileID(string $xProfileID): self
    {
        $self = clone $this;
        $self['xProfileID'] = $xProfileID;

        return $self;
    }
}
