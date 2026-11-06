<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\MarketCompliance\Brand;

/**
 * Entity type. TCR entityType. Decides which vetting TCR applies and, for SOLE_PROPRIETOR, fixes the campaign fee regardless of volume. Also refused at submission if absent. Required when `compliance.brand.inherit != true`.
 */
enum EntityType: string
{
    case PRIVATE_PROFIT = 'PRIVATE_PROFIT';

    case PUBLIC_PROFIT = 'PUBLIC_PROFIT';

    case NON_PROFIT = 'NON_PROFIT';

    case SOLE_PROPRIETOR = 'SOLE_PROPRIETOR';

    case GOVERNMENT = 'GOVERNMENT';
}
