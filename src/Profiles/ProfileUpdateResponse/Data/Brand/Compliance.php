<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileUpdateResponse\Data\Brand;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\DestinationCountry;
use SentDm\Profiles\TcrBrandRelationship;
use SentDm\Profiles\TcrVertical;

/**
 * Compliance and TCR-related information.
 *
 * @phpstan-import-type DestinationCountryShape from \SentDm\Profiles\DestinationCountry
 *
 * @phpstan-type ComplianceShape = array{
 *   brandRelationship?: null|TcrBrandRelationship|value-of<TcrBrandRelationship>,
 *   destinationCountries?: list<DestinationCountry|DestinationCountryShape>|null,
 *   isTcrApplication?: bool|null,
 *   notes?: string|null,
 *   phoneNumberPrefix?: string|null,
 *   primaryUseCase?: string|null,
 *   vertical?: null|TcrVertical|value-of<TcrVertical>,
 * }
 */
final class Compliance implements BaseModel
{
    /** @use SdkModel<ComplianceShape> */
    use SdkModel;

    /** @var value-of<TcrBrandRelationship>|null $brandRelationship */
    #[Optional(
        'brand_relationship',
        enum: TcrBrandRelationship::class,
        nullable: true
    )]
    public ?string $brandRelationship;

    /**
     * List of destination countries for messaging.
     *
     * @var list<DestinationCountry>|null $destinationCountries
     */
    #[Optional('destination_countries', list: DestinationCountry::class)]
    public ?array $destinationCountries;

    /**
     * Whether this is a TCR (Campaign Registry) application.
     */
    #[Optional('is_tcr_application')]
    public ?bool $isTcrApplication;

    /**
     * Additional notes about the business or use case.
     */
    #[Optional(nullable: true)]
    public ?string $notes;

    /**
     * Phone number prefix for messaging (e.g., "+1").
     */
    #[Optional('phone_number_prefix', nullable: true)]
    public ?string $phoneNumberPrefix;

    /**
     * @deprecated
     *
     * Always null. The brand's free-text primary use case is no longer stored: it reached neither
     * TCR nor any decision, and its column is dropped with no backfill, because the values were prose and
     * the typed equivalent is the campaign's MessagingUseCaseUS.
     *
     * Retained so existing v3 clients reading primary_use_case keep deserializing. Unlike the
     * profile sharing flags, which can answer false truthfully, there is no value to report here —
     * the field is present and empty rather than present and wrong.
     */
    #[Optional('primary_use_case', nullable: true)]
    public ?string $primaryUseCase;

    /** @var value-of<TcrVertical>|null $vertical */
    #[Optional(enum: TcrVertical::class, nullable: true)]
    public ?string $vertical;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TcrBrandRelationship|value-of<TcrBrandRelationship>|null $brandRelationship
     * @param list<DestinationCountry|DestinationCountryShape>|null $destinationCountries
     * @param TcrVertical|value-of<TcrVertical>|null $vertical
     */
    public static function with(
        TcrBrandRelationship|string|null $brandRelationship = null,
        ?array $destinationCountries = null,
        ?bool $isTcrApplication = null,
        ?string $notes = null,
        ?string $phoneNumberPrefix = null,
        ?string $primaryUseCase = null,
        TcrVertical|string|null $vertical = null,
    ): self {
        $self = new self;

        null !== $brandRelationship && $self['brandRelationship'] = $brandRelationship;
        null !== $destinationCountries && $self['destinationCountries'] = $destinationCountries;
        null !== $isTcrApplication && $self['isTcrApplication'] = $isTcrApplication;
        null !== $notes && $self['notes'] = $notes;
        null !== $phoneNumberPrefix && $self['phoneNumberPrefix'] = $phoneNumberPrefix;
        null !== $primaryUseCase && $self['primaryUseCase'] = $primaryUseCase;
        null !== $vertical && $self['vertical'] = $vertical;

        return $self;
    }

    /**
     * @param TcrBrandRelationship|value-of<TcrBrandRelationship>|null $brandRelationship
     */
    public function withBrandRelationship(
        TcrBrandRelationship|string|null $brandRelationship
    ): self {
        $self = clone $this;
        $self['brandRelationship'] = $brandRelationship;

        return $self;
    }

    /**
     * List of destination countries for messaging.
     *
     * @param list<DestinationCountry|DestinationCountryShape> $destinationCountries
     */
    public function withDestinationCountries(array $destinationCountries): self
    {
        $self = clone $this;
        $self['destinationCountries'] = $destinationCountries;

        return $self;
    }

    /**
     * Whether this is a TCR (Campaign Registry) application.
     */
    public function withIsTcrApplication(bool $isTcrApplication): self
    {
        $self = clone $this;
        $self['isTcrApplication'] = $isTcrApplication;

        return $self;
    }

    /**
     * Additional notes about the business or use case.
     */
    public function withNotes(?string $notes): self
    {
        $self = clone $this;
        $self['notes'] = $notes;

        return $self;
    }

    /**
     * Phone number prefix for messaging (e.g., "+1").
     */
    public function withPhoneNumberPrefix(?string $phoneNumberPrefix): self
    {
        $self = clone $this;
        $self['phoneNumberPrefix'] = $phoneNumberPrefix;

        return $self;
    }

    /**
     * Always null. The brand's free-text primary use case is no longer stored: it reached neither
     * TCR nor any decision, and its column is dropped with no backfill, because the values were prose and
     * the typed equivalent is the campaign's MessagingUseCaseUS.
     *
     * Retained so existing v3 clients reading primary_use_case keep deserializing. Unlike the
     * profile sharing flags, which can answer false truthfully, there is no value to report here —
     * the field is present and empty rather than present and wrong.
     */
    public function withPrimaryUseCase(?string $primaryUseCase): self
    {
        $self = clone $this;
        $self['primaryUseCase'] = $primaryUseCase;

        return $self;
    }

    /**
     * @param TcrVertical|value-of<TcrVertical>|null $vertical
     */
    public function withVertical(TcrVertical|string|null $vertical): self
    {
        $self = clone $this;
        $self['vertical'] = $vertical;

        return $self;
    }
}
