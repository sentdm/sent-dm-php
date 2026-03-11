<?php

declare(strict_types=1);

namespace SentDm\Services\Brands;

use SentDm\Client;
use SentDm\ServiceContracts\Brands\CampaignsContract;

final class CampaignsService implements CampaignsContract
{
    /**
     * @api
     */
    public CampaignsRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CampaignsRawService($client);
    }
}
