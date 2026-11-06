<?php

declare(strict_types=1);

namespace SentDm\Profiles;

enum TcrBrandIdentityStatus: string
{
    case SELF_DECLARED = 'SELF_DECLARED';

    case UNVERIFIED = 'UNVERIFIED';

    case VERIFIED = 'VERIFIED';

    case VETTED_VERIFIED = 'VETTED_VERIFIED';
}
