<?php

declare(strict_types=1);

namespace SentDm\Profiles\BrandsBrandData;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
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
 *   brandRelationship: TcrBrandRelationship|value-of<TcrBrandRelationship>,
 *   vertical: TcrVertical|value-of<TcrVertical>,
 *   destinationCountries?: list<DestinationCountry|DestinationCountryShape>|null,
 *   expectedMessagingVolume?: string|null,
 *   isTcrApplication?: bool|null,
 *   notes?: string|null,
 *   phoneNumberPrefix?: string|null,
 *   primaryUseCase?: string|null,
 * }
 */
final class Compliance implements BaseModel
{
    /** @use SdkModel<ComplianceShape> */
    use SdkModel;

    /**
     * Brand relationship level with TCR (required for TCR).
     *
     * @var value-of<TcrBrandRelationship> $brandRelationship
     */
    #[Required(enum: TcrBrandRelationship::class)]
    public string $brandRelationship;

    /**
     * Business vertical/industry category (required for TCR).
     *
     * @var value-of<TcrVertical> $vertical
     */
    #[Required(enum: TcrVertical::class)]
    public string $vertical;

    /**
     * List of destination countries for messaging.
     *
     * @var list<DestinationCountry>|null $destinationCountries
     */
    #[Optional(list: DestinationCountry::class, nullable: true)]
    public ?array $destinationCountries;

    /**
     * Expected daily messaging volume.
     */
    #[Optional(nullable: true)]
    public ?string $expectedMessagingVolume;

    /**
     * Whether this is a TCR (Campaign Registry) application.
     */
    #[Optional(nullable: true)]
    public ?bool $isTcrApplication;

    /**
     * Additional notes about the business or use case.
     */
    #[Optional(nullable: true)]
    public ?string $notes;

    /**
     * Phone number prefix for messaging (e.g., "+1").
     */
    #[Optional(nullable: true)]
    public ?string $phoneNumberPrefix;

    /**
     * Primary messaging use case description.
     */
    #[Optional(nullable: true)]
    public ?string $primaryUseCase;

    /**
     * `new Compliance()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Compliance::with(brandRelationship: ..., vertical: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Compliance)->withBrandRelationship(...)->withVertical(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TcrBrandRelationship|value-of<TcrBrandRelationship> $brandRelationship
     * @param TcrVertical|value-of<TcrVertical> $vertical
     * @param list<DestinationCountry|DestinationCountryShape>|null $destinationCountries
     */
    public static function with(
        TcrBrandRelationship|string $brandRelationship,
        TcrVertical|string $vertical,
        ?array $destinationCountries = null,
        ?string $expectedMessagingVolume = null,
        ?bool $isTcrApplication = null,
        ?string $notes = null,
        ?string $phoneNumberPrefix = null,
        ?string $primaryUseCase = null,
    ): self {
        $self = new self;

        $self['brandRelationship'] = $brandRelationship;
        $self['vertical'] = $vertical;

        null !== $destinationCountries && $self['destinationCountries'] = $destinationCountries;
        null !== $expectedMessagingVolume && $self['expectedMessagingVolume'] = $expectedMessagingVolume;
        null !== $isTcrApplication && $self['isTcrApplication'] = $isTcrApplication;
        null !== $notes && $self['notes'] = $notes;
        null !== $phoneNumberPrefix && $self['phoneNumberPrefix'] = $phoneNumberPrefix;
        null !== $primaryUseCase && $self['primaryUseCase'] = $primaryUseCase;

        return $self;
    }

    /**
     * Brand relationship level with TCR (required for TCR).
     *
     * @param TcrBrandRelationship|value-of<TcrBrandRelationship> $brandRelationship
     */
    public function withBrandRelationship(
        TcrBrandRelationship|string $brandRelationship
    ): self {
        $self = clone $this;
        $self['brandRelationship'] = $brandRelationship;

        return $self;
    }

    /**
     * Business vertical/industry category (required for TCR).
     *
     * @param TcrVertical|value-of<TcrVertical> $vertical
     */
    public function withVertical(TcrVertical|string $vertical): self
    {
        $self = clone $this;
        $self['vertical'] = $vertical;

        return $self;
    }

    /**
     * List of destination countries for messaging.
     *
     * @param list<DestinationCountry|DestinationCountryShape>|null $destinationCountries
     */
    public function withDestinationCountries(?array $destinationCountries): self
    {
        $self = clone $this;
        $self['destinationCountries'] = $destinationCountries;

        return $self;
    }

    /**
     * Expected daily messaging volume.
     */
    public function withExpectedMessagingVolume(
        ?string $expectedMessagingVolume
    ): self {
        $self = clone $this;
        $self['expectedMessagingVolume'] = $expectedMessagingVolume;

        return $self;
    }

    /**
     * Whether this is a TCR (Campaign Registry) application.
     */
    public function withIsTcrApplication(?bool $isTcrApplication): self
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
     * Primary messaging use case description.
     */
    public function withPrimaryUseCase(?string $primaryUseCase): self
    {
        $self = clone $this;
        $self['primaryUseCase'] = $primaryUseCase;

        return $self;
    }
}
