<?php

declare(strict_types=1);

namespace SentDm\Services;

use SentDm\Client;
use SentDm\ServiceContracts\OrganizationsContract;
use SentDm\Services\Organizations\UsersService;

final class OrganizationsService implements OrganizationsContract
{
    /**
     * @api
     */
    public OrganizationsRawService $raw;

    /**
     * @api
     */
    public UsersService $users;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new OrganizationsRawService($client);
        $this->users = new UsersService($client);
    }
}
