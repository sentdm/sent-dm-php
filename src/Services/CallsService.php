<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\ServiceContracts\CallsContract;
use SentDm\Services\Calls\ParticipantsService;

final class CallsService implements CallsContract
{
    /**
     * @api
     */
    public CallsRawService $raw;

    /**
     * @api
     */
    public ParticipantsService $participants;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CallsRawService($client);
        $this->participants = new ParticipantsService($client);
    }
}
