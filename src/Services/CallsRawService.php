<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\ServiceContracts\CallsRawContract;

final class CallsRawService implements CallsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
