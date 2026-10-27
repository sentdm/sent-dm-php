<?php

declare(strict_types=1);

namespace SentDm\Services\Voice;

use SentDm\Client;
use SentDm\ServiceContracts\Voice\VoicesRawContract;

final class VoicesRawService implements VoicesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
