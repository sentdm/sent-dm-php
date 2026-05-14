<?php

declare(strict_types=1);

namespace SentDm\Profiles\Campaigns;

enum MessagingUseCaseUs: string
{
    case MARKETING = 'MARKETING';

    case ACCOUNT_NOTIFICATION = 'ACCOUNT_NOTIFICATION';

    case CUSTOMER_CARE = 'CUSTOMER_CARE';

    case FRAUD_ALERT = 'FRAUD_ALERT';

    case TWO_FA = 'TWO_FA';

    case DELIVERY_NOTIFICATION = 'DELIVERY_NOTIFICATION';

    case SECURITY_ALERT = 'SECURITY_ALERT';

    case M2_M = 'M2M';

    case MIXED = 'MIXED';

    case HIGHER_EDUCATION = 'HIGHER_EDUCATION';

    case POLLING_VOTING = 'POLLING_VOTING';

    case PUBLIC_SERVICE_ANNOUNCEMENT = 'PUBLIC_SERVICE_ANNOUNCEMENT';

    case LOW_VOLUME = 'LOW_VOLUME';
}
