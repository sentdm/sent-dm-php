<?php

declare(strict_types=1);

namespace SentDm\Brands;

use SentDm\Brands\BrandDeleteParams\Body;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Delete a brand by ID. The brand must belong to the authenticated customer.
 *
 * @see SentDm\Services\BrandsService::delete()
 *
 * @phpstan-import-type BodyShape from \SentDm\Brands\BrandDeleteParams\Body
 *
 * @phpstan-type BrandDeleteParamsShape = array{body: Body|BodyShape}
 */
final class BrandDeleteParams implements BaseModel
{
    /** @use SdkModel<BrandDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Request to delete a brand.
     */
    #[Required]
    public Body $body;

    /**
     * `new BrandDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandDeleteParams::with(body: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandDeleteParams)->withBody(...)
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
     * @param Body|BodyShape $body
     */
    public static function with(Body|array $body): self
    {
        $self = new self;

        $self['body'] = $body;

        return $self;
    }

    /**
     * Request to delete a brand.
     *
     * @param Body|BodyShape $body
     */
    public function withBody(Body|array $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }
}
