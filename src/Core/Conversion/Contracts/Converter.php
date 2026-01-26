<?php

declare(strict_types=1);

namespace SentDm\Core\Conversion\Contracts;

use SentDm\Core\Conversion\CoerceState;
use SentDm\Core\Conversion\DumpState;

/**
 * @internal
 */
interface Converter
{
    /**
     * @internal
     */
    public function coerce(mixed $value, CoerceState $state): mixed;

    /**
     * @internal
     */
    public function dump(mixed $value, DumpState $state): mixed;
}
