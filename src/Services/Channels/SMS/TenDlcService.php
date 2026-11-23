<?php

declare(strict_types=1);

namespace SentDm\Services\Channels\SMS;

use SentDm\Client;
use SentDm\ServiceContracts\Channels\SMS\TenDlcContract;

final class TenDlcService implements TenDlcContract
{
    /**
     * @api
     */
    public TenDlcRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TenDlcRawService($client);
    }
}
