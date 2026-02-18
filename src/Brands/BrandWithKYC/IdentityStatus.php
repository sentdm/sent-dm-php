<?php

declare(strict_types=1);

namespace SentDm\Brands\BrandWithKYC;

/**
 * TCR brand identity verification status.
 */
enum IdentityStatus: string
{
    case SELF_DECLARED = 'SELF_DECLARED';

    case UNVERIFIED = 'UNVERIFIED';

    case VERIFIED = 'VERIFIED';

    case VETTED_VERIFIED = 'VETTED_VERIFIED';
}
