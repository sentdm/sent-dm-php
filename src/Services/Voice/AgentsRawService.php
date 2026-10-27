<?php

declare(strict_types=1);

namespace SentDm\Services\Voice;

use SentDm\Client;
use SentDm\ServiceContracts\Voice\AgentsRawContract;

final class AgentsRawService implements AgentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
