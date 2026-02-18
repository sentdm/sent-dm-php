<?php

declare(strict_types=1);

namespace SentDm\Brands;

use SentDm\Core\Attributes\Optional;
use SentDm\Core\Attributes\Required;
use SentDm\Core\Concerns\SdkModel;
use SentDm\Core\Concerns\SdkParams;
use SentDm\Core\Contracts\BaseModel;

/**
 * Creates a new brand and associated information. This endpoint automatically sets inheritTcrBrand=false when a brand is created.
 *
 * @see SentDm\Services\BrandsService::create()
 *
 * @phpstan-import-type BrandDataShape from \SentDm\Brands\BrandData
 *
 * @phpstan-type BrandCreateParamsShape = array{
 *   brand: BrandData|BrandDataShape,
 *   testMode?: bool|null,
 *   idempotencyKey?: string|null,
 * }
 */
final class BrandCreateParams implements BaseModel
{
    /** @use SdkModel<BrandCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Brand and KYC information.
     */
    #[Required]
    public BrandData $brand;

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    #[Optional('test_mode')]
    public ?bool $testMode;

    #[Optional]
    public ?string $idempotencyKey;

    /**
     * `new BrandCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandCreateParams::with(brand: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandCreateParams)->withBrand(...)
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
     * @param BrandData|BrandDataShape $brand
     */
    public static function with(
        BrandData|array $brand,
        ?bool $testMode = null,
        ?string $idempotencyKey = null
    ): self {
        $self = new self;

        $self['brand'] = $brand;

        null !== $testMode && $self['testMode'] = $testMode;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Brand and KYC information.
     *
     * @param BrandData|BrandDataShape $brand
     */
    public function withBrand(BrandData|array $brand): self
    {
        $self = clone $this;
        $self['brand'] = $brand;

        return $self;
    }

    /**
     * Test mode flag - when true, the operation is simulated without side effects
     * Useful for testing integrations without actual execution.
     */
    public function withTestMode(bool $testMode): self
    {
        $self = clone $this;
        $self['testMode'] = $testMode;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
