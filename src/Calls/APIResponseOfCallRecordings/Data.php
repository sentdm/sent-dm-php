<?php

declare(strict_types=1);

namespace SentDm\Calls\APIResponseOfCallRecordings;

use SentDm\Calls\APIResponseOfCallRecordings\Data\Recording;
use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The recordings of a call, each as a short-lived download link.
 *
 * @phpstan-import-type RecordingShape from \SentDm\Calls\APIResponseOfCallRecordings\Data\Recording
 *
 * @phpstan-type DataShape = array{
 *   recordings?: list<Recording|RecordingShape>|null
 * }
 */
final class Data implements BaseModel
{
    /** @use SdkModel<DataShape> */
    use SdkModel;

    /**
     * Every recording of the call, oldest first. Empty until the first call.recording_ready webhook has been sent, and for a call that was never recorded.
     *
     * @var list<Recording>|null $recordings
     */
    #[Optional(list: Recording::class)]
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
     * @param list<Recording|RecordingShape>|null $recordings
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
     * @param list<Recording|RecordingShape> $recordings
     */
    public function withRecordings(array $recordings): self
    {
        $self = clone $this;
        $self['recordings'] = $recordings;

        return $self;
    }
}
