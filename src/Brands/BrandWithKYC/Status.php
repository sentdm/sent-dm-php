<?php

declare(strict_types=1);

namespace SentDm\Brands\BrandWithKYC;

/**
 * TCR brand status.
 */
enum Status: string
{
    case ACTIVE = 'ACTIVE';

    case INACTIVE = 'INACTIVE';

    case SUSPENDED = 'SUSPENDED';
}
