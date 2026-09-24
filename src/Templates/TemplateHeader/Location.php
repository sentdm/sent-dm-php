<?php

declare(strict_types=1);

namespace SentDm\Templates\TemplateHeader;

use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The map pin a location header drops. Meta wants none of this at creation — the component is just
 * {"type":"header","format":"location"} — so these values exist for Sent: a preview, and the
 * default a StaticResource header falls back to at send.
 *
 * @phpstan-type LocationShape = array{
 *   address: string, latitude: string, longitude: string, name: string
 * }
 */
final class Location implements BaseModel
{
    /** @use SdkModel<LocationShape> */
    use SdkModel;

    #[Required]
    public string $address;

    #[Required]
    public string $latitude;

    #[Required]
    public string $longitude;

    #[Required]
    public string $name;

    /**
     * `new Location()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Location::with(address: ..., latitude: ..., longitude: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Location)
     *   ->withAddress(...)
     *   ->withLatitude(...)
     *   ->withLongitude(...)
     *   ->withName(...)
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
     */
    public static function with(
        string $address,
        string $latitude,
        string $longitude,
        string $name
    ): self {
        $self = new self;

        $self['address'] = $address;
        $self['latitude'] = $latitude;
        $self['longitude'] = $longitude;
        $self['name'] = $name;

        return $self;
    }

    public function withAddress(string $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }

    public function withLatitude(string $latitude): self
    {
        $self = clone $this;
        $self['latitude'] = $latitude;

        return $self;
    }

    public function withLongitude(string $longitude): self
    {
        $self = clone $this;
        $self['longitude'] = $longitude;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
