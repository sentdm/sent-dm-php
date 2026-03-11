<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\ServiceContracts\LookupContract;

final class LookupService implements LookupContract
{
    /**
     * @api
     */
    public LookupRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new LookupRawService($client);
    }
}
