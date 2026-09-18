<?php

declare(strict_types=1);

namespace SentDm\Messages\MessageGetStatusResponse\Data\MessageBody;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * The media asset that rode a message's header, recorded as sent.
 *
 * @phpstan-type HeaderMediaShape = array{type?: string|null, url?: string|null}
 */
final class HeaderMedia implements BaseModel
{
    /** @use SdkModel<HeaderMediaShape> */
    use SdkModel;

    /**
     * "image", "video" or "document" — taken from the header's media variable.
     */
    #[Optional]
    public ?string $type;

    /**
     * The https URL the caller supplied for this send. Never the template's stored
     * props.sample, which is Meta's expiring header_handle rather than what was delivered.
     */
    #[Optional]
    public ?string $url;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $type = null, ?string $url = null): self
    {
        $self = new self;

        null !== $type && $self['type'] = $type;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * "image", "video" or "document" — taken from the header's media variable.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The https URL the caller supplied for this send. Never the template's stored
     * props.sample, which is Meta's expiring header_handle rather than what was delivered.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
