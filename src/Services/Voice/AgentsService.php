<?php

declare(strict_types=1);

namespace SentDm\Services\Voice;

use SentDm\Client;
use SentDm\ServiceContracts\Voice\AgentsContract;

final class AgentsService implements AgentsContract
{
    /**
     * @api
     */
    public AgentsRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AgentsRawService($client);
    }
}
