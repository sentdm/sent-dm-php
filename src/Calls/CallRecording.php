<?php

declare(strict_types=1);

namespace SentDm\Calls;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A short-lived link to a call recording.
 *
 * @phpstan-type CallRecordingShape = array{
 *   downloadURL?: string|null,
 *   recordingID?: string|null,
 *   urlExpiresAt?: \DateTimeInterface|null,
 * }
 */
final class CallRecording implements BaseModel
{
    /** @use SdkModel<CallRecordingShape> */
    use SdkModel;

    /**
     * A pre-signed link that downloads the recording as an MP3 file. Anyone holding it can download the recording until it expires.
     */
    #[Optional('download_url')]
    public ?string $downloadURL;

    /**
     * The recording's id, the one the call.recording_ready webhook announced it under.
     */
    #[Optional('recording_id')]
    public ?string $recordingID;

    /**
     * When the link stops working (UTC). Request the recordings again for a fresh link.
     */
    #[Optional('url_expires_at')]
    public ?\DateTimeInterface $urlExpiresAt;

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
        ?string $downloadURL = null,
        ?string $recordingID = null,
        ?\DateTimeInterface $urlExpiresAt = null,
    ): self {
        $self = new self;

        null !== $downloadURL && $self['downloadURL'] = $downloadURL;
        null !== $recordingID && $self['recordingID'] = $recordingID;
        null !== $urlExpiresAt && $self['urlExpiresAt'] = $urlExpiresAt;

        return $self;
    }

    /**
     * A pre-signed link that downloads the recording as an MP3 file. Anyone holding it can download the recording until it expires.
     */
    public function withDownloadURL(string $downloadURL): self
    {
        $self = clone $this;
        $self['downloadURL'] = $downloadURL;

        return $self;
    }

    /**
     * The recording's id, the one the call.recording_ready webhook announced it under.
     */
    public function withRecordingID(string $recordingID): self
    {
        $self = clone $this;
        $self['recordingID'] = $recordingID;

        return $self;
    }

    /**
     * When the link stops working (UTC). Request the recordings again for a fresh link.
     */
    public function withURLExpiresAt(\DateTimeInterface $urlExpiresAt): self
    {
        $self = clone $this;
        $self['urlExpiresAt'] = $urlExpiresAt;

        return $self;
    }
}
