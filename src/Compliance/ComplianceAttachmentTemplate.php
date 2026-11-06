<?php

declare(strict_types=1);

namespace SentDm\Compliance;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * A file this market wants, and the multipart field to send it as.
 *
 * Separate from compliance because a file is not JSON: the channel call accepts multipart, and
 * each file is named after the key it satisfies. Listing documents among the JSON entries would describe a
 * request nobody could send.
 *
 * @phpstan-type ComplianceAttachmentTemplateShape = array{
 *   fieldName?: string|null, label?: string|null, required?: bool|null
 * }
 */
final class ComplianceAttachmentTemplate implements BaseModel
{
    /** @use SdkModel<ComplianceAttachmentTemplateShape> */
    use SdkModel;

    /**
     * The multipart field name to attach the file under.
     */
    #[Optional('field_name')]
    public ?string $fieldName;

    #[Optional(nullable: true)]
    public ?string $label;

    #[Optional]
    public ?bool $required;

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
        ?string $fieldName = null,
        ?string $label = null,
        ?bool $required = null
    ): self {
        $self = new self;

        null !== $fieldName && $self['fieldName'] = $fieldName;
        null !== $label && $self['label'] = $label;
        null !== $required && $self['required'] = $required;

        return $self;
    }

    /**
     * The multipart field name to attach the file under.
     */
    public function withFieldName(string $fieldName): self
    {
        $self = clone $this;
        $self['fieldName'] = $fieldName;

        return $self;
    }

    public function withLabel(?string $label): self
    {
        $self = clone $this;
        $self['label'] = $label;

        return $self;
    }

    public function withRequired(bool $required): self
    {
        $self = clone $this;
        $self['required'] = $required;

        return $self;
    }
}
