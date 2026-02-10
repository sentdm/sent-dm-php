<?php

declare(strict_types=1);

namespace SentDm\Services\Organizations;

use SentDm\Client;
use SentDm\ServiceContracts\Organizations\UsersRawContract;

final class UsersRawService implements UsersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
