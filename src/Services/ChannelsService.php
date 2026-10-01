<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\ServiceContracts\ChannelsContract;
use SentDm\Services\Channels\VoiceService;

final class ChannelsService implements ChannelsContract
{
    /**
     * @api
     */
    public ChannelsRawService $raw;

    /**
     * @api
     */
    public VoiceService $voice;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ChannelsRawService($client);
        $this->voice = new VoiceService($client);
    }
}
