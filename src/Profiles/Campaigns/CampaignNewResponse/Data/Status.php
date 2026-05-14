<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns\CampaignNewResponse\Data;

enum Status: string
{
    case SENT_CREATED = 'SENT_CREATED';

    case ACTIVE = 'ACTIVE';

    case EXPIRED = 'EXPIRED';
}
