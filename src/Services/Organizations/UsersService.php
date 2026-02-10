<?php

declare(strict_types=1);

namespace SentDm\Services\Organizations;

use SentDm\Client;
use SentDm\ServiceContracts\Organizations\UsersContract;

final class UsersService implements UsersContract
{
    /**
     * @api
     */
    public UsersRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new UsersRawService($client);
    }
}
