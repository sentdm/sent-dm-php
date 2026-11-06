<?php

declare(strict_types=1);

namespace SentDm\Compliance;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * One value a market expects in a channel call's compliance map.
 *
 * @phpstan-type ComplianceRequirementShape = array{
 *   format?: string|null,
 *   itemFields?: list<mixed>|null,
 *   key?: string|null,
 *   label?: string|null,
 *   maxItems?: int|null,
 *   minLength?: int|null,
 *   notes?: string|null,
 *   options?: list<string>|null,
 *   required?: bool|null,
 *   requiredWhen?: string|null,
 *   type?: string|null,
 * }
 */
final class ComplianceRequirement implements BaseModel
{
    /** @use SdkModel<ComplianceRequirementShape> */
    use SdkModel;

    /**
     * Refinement of type where the market demands a specific shape, e.g. e164,
     * url, email, iso3166_alpha2, csv_keywords.
     */
    #[Optional(nullable: true)]
    public ?string $format;

    /**
     * Shape of each entry, when this requirement is a list of objects rather than of scalars.
     *
     * The compliance value stays null in the setup body like every other blank —
     * a body that carries a half-filled object is one the endpoint refuses, which would break the promise
     * that the published body can be sent as it stands. So the shape is described here instead, and each
     * entry the caller composes has these keys.
     *
     * @var list<mixed>|null $itemFields
     */
    #[Optional('item_fields', list: ComplianceRequirement::class, nullable: true)]
    public ?array $itemFields;

    /**
     * Key to use in the compliance map.
     */
    #[Optional]
    public ?string $key;

    /**
     * Human label, suitable for a form field.
     */
    #[Optional(nullable: true)]
    public ?string $label;

    /**
     * Most entries this value accepts, where the market caps it.
     */
    #[Optional('max_items', nullable: true)]
    public ?int $maxItems;

    /**
     * Shortest acceptable value, where the market sets one. TCR refuses a consent narrative under 40
     * characters, and finding that out at submission time is the round trip this exists to save.
     */
    #[Optional('min_length', nullable: true)]
    public ?int $minLength;

    /**
     * Why the market asks for this.
     */
    #[Optional(nullable: true)]
    public ?string $notes;

    /**
     * Accepted values, when the type is an enum or a constrained array.
     *
     * @var list<string>|null $options
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $options;

    /**
     * Whether the market always demands this value.
     */
    #[Optional]
    public ?bool $required;

    /**
     * Condition that makes this value required, when it is only required in some cases —
     * e.g. brand.entity_type == PUBLIC_PROFIT. Evaluate it against your own payload to know
     * whether to collect the field.
     */
    #[Optional('required_when', nullable: true)]
    public ?string $requiredWhen;

    /**
     * Value type: string, number, boolean, date, enum,
     * object, array or document.
     */
    #[Optional]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<mixed>|null $itemFields
     * @param list<string>|null $options
     */
    public static function with(
        ?string $format = null,
        ?array $itemFields = null,
        ?string $key = null,
        ?string $label = null,
        ?int $maxItems = null,
        ?int $minLength = null,
        ?string $notes = null,
        ?array $options = null,
        ?bool $required = null,
        ?string $requiredWhen = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $format && $self['format'] = $format;
        null !== $itemFields && $self['itemFields'] = $itemFields;
        null !== $key && $self['key'] = $key;
        null !== $label && $self['label'] = $label;
        null !== $maxItems && $self['maxItems'] = $maxItems;
        null !== $minLength && $self['minLength'] = $minLength;
        null !== $notes && $self['notes'] = $notes;
        null !== $options && $self['options'] = $options;
        null !== $required && $self['required'] = $required;
        null !== $requiredWhen && $self['requiredWhen'] = $requiredWhen;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Refinement of type where the market demands a specific shape, e.g. e164,
     * url, email, iso3166_alpha2, csv_keywords.
     */
    public function withFormat(?string $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }

    /**
     * Shape of each entry, when this requirement is a list of objects rather than of scalars.
     *
     * The compliance value stays null in the setup body like every other blank —
     * a body that carries a half-filled object is one the endpoint refuses, which would break the promise
     * that the published body can be sent as it stands. So the shape is described here instead, and each
     * entry the caller composes has these keys.
     *
     * @param list<mixed>|null $itemFields
     */
    public function withItemFields(?array $itemFields): self
    {
        $self = clone $this;
        $self['itemFields'] = $itemFields;

        return $self;
    }

    /**
     * Key to use in the compliance map.
     */
    public function withKey(string $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    /**
     * Human label, suitable for a form field.
     */
    public function withLabel(?string $label): self
    {
        $self = clone $this;
        $self['label'] = $label;

        return $self;
    }

    /**
     * Most entries this value accepts, where the market caps it.
     */
    public function withMaxItems(?int $maxItems): self
    {
        $self = clone $this;
        $self['maxItems'] = $maxItems;

        return $self;
    }

    /**
     * Shortest acceptable value, where the market sets one. TCR refuses a consent narrative under 40
     * characters, and finding that out at submission time is the round trip this exists to save.
     */
    public function withMinLength(?int $minLength): self
    {
        $self = clone $this;
        $self['minLength'] = $minLength;

        return $self;
    }

    /**
     * Why the market asks for this.
     */
    public function withNotes(?string $notes): self
    {
        $self = clone $this;
        $self['notes'] = $notes;

        return $self;
    }

    /**
     * Accepted values, when the type is an enum or a constrained array.
     *
     * @param list<string>|null $options
     */
    public function withOptions(?array $options): self
    {
        $self = clone $this;
        $self['options'] = $options;

        return $self;
    }

    /**
     * Whether the market always demands this value.
     */
    public function withRequired(bool $required): self
    {
        $self = clone $this;
        $self['required'] = $required;

        return $self;
    }

    /**
     * Condition that makes this value required, when it is only required in some cases —
     * e.g. brand.entity_type == PUBLIC_PROFIT. Evaluate it against your own payload to know
     * whether to collect the field.
     */
    public function withRequiredWhen(?string $requiredWhen): self
    {
        $self = clone $this;
        $self['requiredWhen'] = $requiredWhen;

        return $self;
    }

    /**
     * Value type: string, number, boolean, date, enum,
     * object, array or document.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
