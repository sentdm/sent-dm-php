<?php

declare(strict_types=1);

namespace SentDm\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Returns pre-signed links to the recordings of one of your calls, each valid until its url_expires_at. A recording appears once the call was recorded, by a connect answer with record set, a startRecording instruction or the recordings command, and the call.recording_ready webhook has been sent; until then, and for a call that was never recorded, the list is empty. A call recorded more than once lists every recording, oldest first, each under the recording_id its call.recording_ready webhook carried.
 *
 * @see SentDm\Services\CallsService::listRecordings()
 *
 * @phpstan-type CallListRecordingsParamsShape = array{xProfileID?: string|null}
 */
final class CallListRecordingsParams implements BaseModel
{
    /** @use SdkModel<CallListRecordingsParamsShape> */
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
