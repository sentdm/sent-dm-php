<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The verdict of a test question sent to your callback URL.
 *
 * @phpstan-import-type VoiceCallbackTestErrorInfoShape from \SentDm\Channels\Voice\VoiceCallbackTestErrorInfo
 * @phpstan-import-type VoiceCallbackTestRequestInfoShape from \SentDm\Channels\Voice\VoiceCallbackTestRequestInfo
 * @phpstan-import-type VoiceCallbackTestResponseInfoShape from \SentDm\Channels\Voice\VoiceCallbackTestResponseInfo
 *
 * @phpstan-type VoiceCallbackTestShape = array{
 *   answer?: mixed,
 *   callID?: string|null,
 *   error?: null|VoiceCallbackTestErrorInfo|VoiceCallbackTestErrorInfoShape,
 *   outcome?: string|null,
 *   request?: null|VoiceCallbackTestRequestInfo|VoiceCallbackTestRequestInfoShape,
 *   response?: null|VoiceCallbackTestResponseInfo|VoiceCallbackTestResponseInfoShape,
 * }
 */
final class VoiceCallbackTest implements BaseModel
{
    /** @use SdkModel<VoiceCallbackTestShape> */
    use SdkModel;

    /**
     * Your answer as Sent read it, with numbers in E.164 and a missing caller id filled in. Set only when the outcome is ok.
     */
    #[Optional(nullable: true)]
    public mixed $answer;

    /**
     * The call id the test question carried. It does not exist anywhere else and cannot be looked up.
     */
    #[Optional('call_id')]
    public ?string $callID;

    /**
     * Why the test did not end with ok.
     */
    #[Optional(nullable: true)]
    public ?VoiceCallbackTestErrorInfo $error;

    /**
     * What happened: ok, timeout, connection_failed, http_error or invalid_answer.
     */
    #[Optional]
    public ?string $outcome;

    /**
     * The test question exactly as it was sent.
     */
    #[Optional(nullable: true)]
    public ?VoiceCallbackTestRequestInfo $request;

    /**
     * What your endpoint answered.
     */
    #[Optional(nullable: true)]
    public ?VoiceCallbackTestResponseInfo $response;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param VoiceCallbackTestErrorInfo|VoiceCallbackTestErrorInfoShape|null $error
     * @param VoiceCallbackTestRequestInfo|VoiceCallbackTestRequestInfoShape|null $request
     * @param VoiceCallbackTestResponseInfo|VoiceCallbackTestResponseInfoShape|null $response
     */
    public static function with(
        mixed $answer = null,
        ?string $callID = null,
        VoiceCallbackTestErrorInfo|array|null $error = null,
        ?string $outcome = null,
        VoiceCallbackTestRequestInfo|array|null $request = null,
        VoiceCallbackTestResponseInfo|array|null $response = null,
    ): self {
        $self = new self;

        null !== $answer && $self['answer'] = $answer;
        null !== $callID && $self['callID'] = $callID;
        null !== $error && $self['error'] = $error;
        null !== $outcome && $self['outcome'] = $outcome;
        null !== $request && $self['request'] = $request;
        null !== $response && $self['response'] = $response;

        return $self;
    }

    /**
     * Your answer as Sent read it, with numbers in E.164 and a missing caller id filled in. Set only when the outcome is ok.
     */
    public function withAnswer(mixed $answer): self
    {
        $self = clone $this;
        $self['answer'] = $answer;

        return $self;
    }

    /**
     * The call id the test question carried. It does not exist anywhere else and cannot be looked up.
     */
    public function withCallID(string $callID): self
    {
        $self = clone $this;
        $self['callID'] = $callID;

        return $self;
    }

    /**
     * Why the test did not end with ok.
     *
     * @param VoiceCallbackTestErrorInfo|VoiceCallbackTestErrorInfoShape|null $error
     */
    public function withError(
        VoiceCallbackTestErrorInfo|array|null $error
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * What happened: ok, timeout, connection_failed, http_error or invalid_answer.
     */
    public function withOutcome(string $outcome): self
    {
        $self = clone $this;
        $self['outcome'] = $outcome;

        return $self;
    }

    /**
     * The test question exactly as it was sent.
     *
     * @param VoiceCallbackTestRequestInfo|VoiceCallbackTestRequestInfoShape|null $request
     */
    public function withRequest(
        VoiceCallbackTestRequestInfo|array|null $request
    ): self {
        $self = clone $this;
        $self['request'] = $request;

        return $self;
    }

    /**
     * What your endpoint answered.
     *
     * @param VoiceCallbackTestResponseInfo|VoiceCallbackTestResponseInfoShape|null $response
     */
    public function withResponse(
        VoiceCallbackTestResponseInfo|array|null $response
    ): self {
        $self = clone $this;
        $self['response'] = $response;

        return $self;
    }
}
