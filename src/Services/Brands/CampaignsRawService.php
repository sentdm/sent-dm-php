<?php

declare(strict_types=1);

namespace SentDm\Services\Brands;

use SentDm\Client;
use SentDm\ServiceContracts\Brands\CampaignsRawContract;

final class CampaignsRawService implements CampaignsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
