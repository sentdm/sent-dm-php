<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\ServiceContracts\VoiceRawContract;

final class VoiceRawService implements VoiceRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
