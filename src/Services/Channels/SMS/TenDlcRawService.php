<?php

declare(strict_types=1);

namespace SentDm\Services\Channels\SMS;

use SentDm\Client;
use SentDm\ServiceContracts\Channels\SMS\TenDlcRawContract;

final class TenDlcRawService implements TenDlcRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
