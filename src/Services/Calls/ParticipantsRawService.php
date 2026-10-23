<?php

declare(strict_types=1);

namespace SentDm\Services\Calls;

use SentDm\Client;
use SentDm\ServiceContracts\Calls\ParticipantsRawContract;

final class ParticipantsRawService implements ParticipantsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
