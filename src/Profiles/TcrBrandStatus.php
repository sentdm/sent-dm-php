<?php

declare(strict_types=1);

namespace SentDm\Profiles;

enum TcrBrandStatus: string
{
    case ACTIVE = 'ACTIVE';

    case INACTIVE = 'INACTIVE';

    case SUSPENDED = 'SUSPENDED';
}
