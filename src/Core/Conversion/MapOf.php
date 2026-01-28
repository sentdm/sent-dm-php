<?php

declare(strict_types=1);

namespace SentDm\Core\Conversion;

use SentDm\Core\Conversion\Concerns\ArrayOf;
use SentDm\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class MapOf implements Converter
{
    use ArrayOf;
}
