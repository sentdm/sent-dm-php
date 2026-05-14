<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns\CampaignUpdateResponse\Data;

enum SharingStatus: string
{
    case PENDING = 'PENDING';

    case ACCEPTED = 'ACCEPTED';

    case DECLINED = 'DECLINED';
}
