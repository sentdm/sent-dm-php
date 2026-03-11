<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\ServiceContracts\BrandsContract;
use SentDm\Services\Brands\CampaignsService;

final class BrandsService implements BrandsContract
{
    /**
     * @api
     */
    public BrandsRawService $raw;

    /**
     * @api
     */
    public CampaignsService $campaigns;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BrandsRawService($client);
        $this->campaigns = new CampaignsService($client);
    }
}
