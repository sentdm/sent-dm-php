<?php

declare(strict_types=1);

namespace SentDm\Channels\Whatsapp\WhatsappChannel;

/**
 * Read-only. Never carries a token — the row holds that and it is not returned. ACTION_NEEDED when
 * no account is connected or the account has no phone number: both are yours to do.
 */
enum Status: string
{
    case PROVISIONING = 'PROVISIONING';

    case ACTION_NEEDED = 'ACTION_NEEDED';

    case PENDING_REVIEW = 'PENDING_REVIEW';

    case ACTIVE = 'ACTIVE';

    case INACTIVE = 'INACTIVE';
}
