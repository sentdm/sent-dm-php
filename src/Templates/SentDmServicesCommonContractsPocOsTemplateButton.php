<?php

declare(strict_types=1);

namespace SentDm\Templates;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Contracts\BaseModel;

/**
 * Interactive button in a message template.
 *
 * @phpstan-import-type SentDmServicesCommonContractsPocOsTemplateButtonPropsShape from \SentDm\Templates\SentDmServicesCommonContractsPocOsTemplateButtonProps
 *
 * @phpstan-type SentDmServicesCommonContractsPocOsTemplateButtonShape = array{
 *   id?: int|null,
 *   props?: null|SentDmServicesCommonContractsPocOsTemplateButtonProps|SentDmServicesCommonContractsPocOsTemplateButtonPropsShape,
 *   type?: string|null,
 * }
 */
final class SentDmServicesCommonContractsPocOsTemplateButton implements BaseModel
{
    /** @use SdkModel<SentDmServicesCommonContractsPocOsTemplateButtonShape> */
    use SdkModel;

    /**
     * The unique identifier of the button (1-based index).
     */
    #[Optional]
    public ?int $id;

    /**
     * Properties specific to the button type.
     */
    #[Optional]
    public ?SentDmServicesCommonContractsPocOsTemplateButtonProps $props;

    /**
     * The type of button (e.g., QUICK_REPLY, URL, PHONE_NUMBER, VOICE_CALL, COPY_CODE).
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
     * @param SentDmServicesCommonContractsPocOsTemplateButtonProps|SentDmServicesCommonContractsPocOsTemplateButtonPropsShape|null $props
     */
    public static function with(
        ?int $id = null,
        SentDmServicesCommonContractsPocOsTemplateButtonProps|array|null $props = null,
        ?string $type = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $props && $self['props'] = $props;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * The unique identifier of the button (1-based index).
     */
    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Properties specific to the button type.
     *
     * @param SentDmServicesCommonContractsPocOsTemplateButtonProps|SentDmServicesCommonContractsPocOsTemplateButtonPropsShape $props
     */
    public function withProps(
        SentDmServicesCommonContractsPocOsTemplateButtonProps|array $props
    ): self {
        $self = clone $this;
        $self['props'] = $props;

        return $self;
    }

    /**
     * The type of button (e.g., QUICK_REPLY, URL, PHONE_NUMBER, VOICE_CALL, COPY_CODE).
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
