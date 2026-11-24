<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\TenDlc\TenDlcUpdateCampaignParams\UseCase1;

/**
 * Use case. What this entry sends. MIXED and LOW_VOLUME are refused — volume decides those.
 */
enum UseCase: string
{
    case MARKETING = 'MARKETING';

    case ACCOUNT_NOTIFICATION = 'ACCOUNT_NOTIFICATION';

    case CUSTOMER_CARE = 'CUSTOMER_CARE';

    case FRAUD_ALERT = 'FRAUD_ALERT';

    case _2_FA = '2FA';

    case DELIVERY_NOTIFICATION = 'DELIVERY_NOTIFICATION';

    case SECURITY_ALERT = 'SECURITY_ALERT';

    case M2_M = 'M2M';

    case HIGHER_EDUCATION = 'HIGHER_EDUCATION';

    case POLLING_VOTING = 'POLLING_VOTING';

    case PUBLIC_SERVICE_ANNOUNCEMENT = 'PUBLIC_SERVICE_ANNOUNCEMENT';
}
