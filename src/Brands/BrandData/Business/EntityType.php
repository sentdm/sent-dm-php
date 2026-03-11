<?php

declare(strict_types=1);

namespace SentDm\Brands\BrandData\Business;

/**
 * Business entity type.
 */
enum EntityType: string
{
    case PRIVATE_PROFIT = 'PRIVATE_PROFIT';

    case PUBLIC_PROFIT = 'PUBLIC_PROFIT';

    case NON_PROFIT = 'NON_PROFIT';

    case SOLE_PROPRIETOR = 'SOLE_PROPRIETOR';

    case GOVERNMENT = 'GOVERNMENT';
}
