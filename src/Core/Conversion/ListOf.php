<?php

declare(strict_types=1);

namespace SentDm\Core\Conversion;

use SentDm\Core\Conversion\Concerns\ArrayOf;
use SentDm\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class ListOf implements Converter
{
    use ArrayOf;

    // @phpstan-ignore-next-line missingType.iterableValue
    private function empty(): array|object
    {
        return [];
    }
}
