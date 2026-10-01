<?php

declare(strict_types=1);

namespace SentDm\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The recordings of a call, each as a short-lived download link.
 *
 * @phpstan-import-type CallRecordingShape from \SentDm\Calls\CallRecording
 *
 * @phpstan-type CallRecordingsShape = array{
 *   recordings?: list<CallRecording|CallRecordingShape>|null
 * }
 */
final class CallRecordings implements BaseModel
{
    /** @use SdkModel<CallRecordingsShape> */
    use SdkModel;

    /**
     * Every recording of the call, oldest first. Empty until the first call.recording_ready webhook has been sent, and for a call that was never recorded.
     *
     * @var list<CallRecording>|null $recordings
     */
    #[Optional(list: CallRecording::class)]
    public ?array $recordings;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<CallRecording|CallRecordingShape>|null $recordings
     */
    public static function with(?array $recordings = null): self
    {
        $self = new self;

        null !== $recordings && $self['recordings'] = $recordings;

        return $self;
    }

    /**
     * Every recording of the call, oldest first. Empty until the first call.recording_ready webhook has been sent, and for a call that was never recorded.
     *
     * @param list<CallRecording|CallRecordingShape> $recordings
     */
    public function withRecordings(array $recordings): self
    {
        $self = clone $this;
        $self['recordings'] = $recordings;

        return $self;
    }
}
