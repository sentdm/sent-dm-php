<?php

declare(strict_types=1);

namespace SentDm\Compliance;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One call to make, with a body that can be sent as it stands.
 *
 * The steps are ordered and the order is load-bearing: a channel that registers with a regime is filed
 * against a brand, so the brand call comes first and the channel call refuses until it has been made. Doing them
 * in order is the whole of setting a market up.
 *
 * @phpstan-import-type ComplianceAttachmentTemplateShape from \SentDm\Compliance\ComplianceAttachmentTemplate
 *
 * @phpstan-type ComplianceSetupStepShape = array{
 *   attachments?: list<ComplianceAttachmentTemplate|ComplianceAttachmentTemplateShape>|null,
 *   body?: mixed,
 *   method?: string|null,
 *   path?: string|null,
 *   resource?: string|null,
 *   step?: int|null,
 *   why?: string|null,
 * }
 */
final class ComplianceSetupStep implements BaseModel
{
    /** @use SdkModel<ComplianceSetupStepShape> */
    use SdkModel;

    /**
     * Files to attach as multipart, when this call takes any. Absent when it does not.
     *
     * @var list<ComplianceAttachmentTemplate>|null $attachments
     */
    #[Optional(list: ComplianceAttachmentTemplate::class, nullable: true)]
    public ?array $attachments;

    /**
     * The request body, with every key this market wants already present and the values left blank. Send it as
     * it stands and the response names each blank that still has to be filled.
     */
    #[Optional]
    public mixed $body;

    #[Optional]
    public ?string $method;

    /**
     * Path to call. Add the x-profile-id header with an organization key to make the same call for one of
     * your sender profiles — there is no separate path for that.
     */
    #[Optional]
    public ?string $path;

    /**
     * What this call sets up: brand or channel.
     */
    #[Optional]
    public ?string $resource;

    /**
     * Position in the sequence, from 1. Steps must be performed in this order.
     */
    #[Optional]
    public ?int $step;

    /**
     * Why this market needs this call, in one sentence.
     */
    #[Optional]
    public ?string $why;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ComplianceAttachmentTemplate|ComplianceAttachmentTemplateShape>|null $attachments
     */
    public static function with(
        ?array $attachments = null,
        mixed $body = null,
        ?string $method = null,
        ?string $path = null,
        ?string $resource = null,
        ?int $step = null,
        ?string $why = null,
    ): self {
        $self = new self;

        null !== $attachments && $self['attachments'] = $attachments;
        null !== $body && $self['body'] = $body;
        null !== $method && $self['method'] = $method;
        null !== $path && $self['path'] = $path;
        null !== $resource && $self['resource'] = $resource;
        null !== $step && $self['step'] = $step;
        null !== $why && $self['why'] = $why;

        return $self;
    }

    /**
     * Files to attach as multipart, when this call takes any. Absent when it does not.
     *
     * @param list<ComplianceAttachmentTemplate|ComplianceAttachmentTemplateShape>|null $attachments
     */
    public function withAttachments(?array $attachments): self
    {
        $self = clone $this;
        $self['attachments'] = $attachments;

        return $self;
    }

    /**
     * The request body, with every key this market wants already present and the values left blank. Send it as
     * it stands and the response names each blank that still has to be filled.
     */
    public function withBody(mixed $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    public function withMethod(string $method): self
    {
        $self = clone $this;
        $self['method'] = $method;

        return $self;
    }

    /**
     * Path to call. Add the x-profile-id header with an organization key to make the same call for one of
     * your sender profiles — there is no separate path for that.
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    /**
     * What this call sets up: brand or channel.
     */
    public function withResource(string $resource): self
    {
        $self = clone $this;
        $self['resource'] = $resource;

        return $self;
    }

    /**
     * Position in the sequence, from 1. Steps must be performed in this order.
     */
    public function withStep(int $step): self
    {
        $self = clone $this;
        $self['step'] = $step;

        return $self;
    }

    /**
     * Why this market needs this call, in one sentence.
     */
    public function withWhy(string $why): self
    {
        $self = clone $this;
        $self['why'] = $why;

        return $self;
    }
}
