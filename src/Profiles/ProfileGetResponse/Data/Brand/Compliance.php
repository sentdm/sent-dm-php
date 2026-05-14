<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileGetResponse\Data\Brand;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;
use SentDm\Profiles\ProfileGetResponse\Data\Brand\Compliance\BrandRelationship;
use SentDm\Profiles\ProfileGetResponse\Data\Brand\Compliance\DestinationCountry;
use SentDm\Profiles\ProfileGetResponse\Data\Brand\Compliance\Vertical;

/**
 * Compliance and TCR-related information.
 *
 * @phpstan-import-type DestinationCountryShape from \SentDm\Profiles\ProfileGetResponse\Data\Brand\Compliance\DestinationCountry
 *
 * @phpstan-type ComplianceShape = array{
 *   brandRelationship?: null|BrandRelationship|value-of<BrandRelationship>,
 *   destinationCountries?: list<DestinationCountry|DestinationCountryShape>|null,
 *   expectedMessagingVolume?: string|null,
 *   isTcrApplication?: bool|null,
 *   notes?: string|null,
 *   phoneNumberPrefix?: string|null,
 *   primaryUseCase?: string|null,
 *   vertical?: null|Vertical|value-of<Vertical>,
 * }
 */
final class Compliance implements BaseModel
{
    /** @use SdkModel<ComplianceShape> */
    use SdkModel;

    /** @var value-of<BrandRelationship>|null $brandRelationship */
    #[Optional(
        'brand_relationship',
        enum: BrandRelationship::class,
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
     * Expected daily messaging volume.
     */
    #[Optional('expected_messaging_volume', nullable: true)]
    public ?string $expectedMessagingVolume;

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
     * Primary messaging use case description.
     */
    #[Optional('primary_use_case', nullable: true)]
    public ?string $primaryUseCase;

    /** @var value-of<Vertical>|null $vertical */
    #[Optional(enum: Vertical::class, nullable: true)]
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
     * @param BrandRelationship|value-of<BrandRelationship>|null $brandRelationship
     * @param list<DestinationCountry|DestinationCountryShape>|null $destinationCountries
     * @param Vertical|value-of<Vertical>|null $vertical
     */
    public static function with(
        BrandRelationship|string|null $brandRelationship = null,
        ?array $destinationCountries = null,
        ?string $expectedMessagingVolume = null,
        ?bool $isTcrApplication = null,
        ?string $notes = null,
        ?string $phoneNumberPrefix = null,
        ?string $primaryUseCase = null,
        Vertical|string|null $vertical = null,
    ): self {
        $self = new self;

        null !== $brandRelationship && $self['brandRelationship'] = $brandRelationship;
        null !== $destinationCountries && $self['destinationCountries'] = $destinationCountries;
        null !== $expectedMessagingVolume && $self['expectedMessagingVolume'] = $expectedMessagingVolume;
        null !== $isTcrApplication && $self['isTcrApplication'] = $isTcrApplication;
        null !== $notes && $self['notes'] = $notes;
        null !== $phoneNumberPrefix && $self['phoneNumberPrefix'] = $phoneNumberPrefix;
        null !== $primaryUseCase && $self['primaryUseCase'] = $primaryUseCase;
        null !== $vertical && $self['vertical'] = $vertical;

        return $self;
    }

    /**
     * @param BrandRelationship|value-of<BrandRelationship>|null $brandRelationship
     */
    public function withBrandRelationship(
        BrandRelationship|string|null $brandRelationship
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
     * Primary messaging use case description.
     */
    public function withPrimaryUseCase(?string $primaryUseCase): self
    {
        $self = clone $this;
        $self['primaryUseCase'] = $primaryUseCase;

        return $self;
    }

    /**
     * @param Vertical|value-of<Vertical>|null $vertical
     */
    public function withVertical(Vertical|string|null $vertical): self
    {
        $self = clone $this;
        $self['vertical'] = $vertical;

        return $self;
    }
}
