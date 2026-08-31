<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileNewResponse\Data\Brand;

enum Status: string
{
    case ACTIVE = 'ACTIVE';

    case INACTIVE = 'INACTIVE';

    case SUSPENDED = 'SUSPENDED';
}
