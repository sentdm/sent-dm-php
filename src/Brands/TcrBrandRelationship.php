<?php

declare(strict_types=1);

namespace SentDm\Brands;

enum TcrBrandRelationship: string
{
    case BASIC_ACCOUNT = 'BASIC_ACCOUNT';

    case MEDIUM_ACCOUNT = 'MEDIUM_ACCOUNT';

    case LARGE_ACCOUNT = 'LARGE_ACCOUNT';

    case SMALL_ACCOUNT = 'SMALL_ACCOUNT';

    case KEY_ACCOUNT = 'KEY_ACCOUNT';
}
