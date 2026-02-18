<?php

declare(strict_types=1);

namespace SentDm\Brands\Campaigns\TcrCampaignWithUseCases;

enum Status: string
{
    case SENT_CREATED = 'SENT_CREATED';

    case ACTIVE = 'ACTIVE';

    case EXPIRED = 'EXPIRED';
}
