<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\ServiceContracts\VoiceContract;
use SentDm\Services\Voice\AgentsService;
use SentDm\Services\Voice\CallsService;
use SentDm\Services\Voice\CatalogueService;
use SentDm\Services\Voice\TokensService;

final class VoiceService implements VoiceContract
{
    /**
     * @api
     */
    public VoiceRawService $raw;

    /**
     * @api
     */
    public CallsService $calls;

    /**
     * @api
     */
    public TokensService $tokens;

    /**
     * @api
     */
    public AgentsService $agents;

    /**
     * @api
     */
    public CatalogueService $catalogue;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new VoiceRawService($client);
        $this->calls = new CallsService($client);
        $this->tokens = new TokensService($client);
        $this->agents = new AgentsService($client);
        $this->catalogue = new CatalogueService($client);
    }
}
