<?php

declare(strict_types=1);

namespace SentDm\Brands\Campaigns\TcrCampaignWithUseCases;

enum SharingStatus: string
{
    case PENDING = 'PENDING';

    case ACCEPTED = 'ACCEPTED';

    case DECLINED = 'DECLINED';
}
