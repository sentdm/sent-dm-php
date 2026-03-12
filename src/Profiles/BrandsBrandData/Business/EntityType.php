<?php

declare(strict_types=1);

namespace SentDm\Profiles\BrandsBrandData\Business;

enum EntityType: string
{
    case PRIVATE_PROFIT = 'PRIVATE_PROFIT';

    case PUBLIC_PROFIT = 'PUBLIC_PROFIT';

    case NON_PROFIT = 'NON_PROFIT';

    case SOLE_PROPRIETOR = 'SOLE_PROPRIETOR';

    case GOVERNMENT = 'GOVERNMENT';
}
