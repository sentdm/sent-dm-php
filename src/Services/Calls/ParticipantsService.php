<?php

declare(strict_types=1);

namespace SentDm\Services\Calls;

use SentDm\Client;
use SentDm\ServiceContracts\Calls\ParticipantsContract;

final class ParticipantsService implements ParticipantsContract
{
    /**
     * @api
     */
    public ParticipantsRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ParticipantsRawService($client);
    }
}
