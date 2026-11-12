<?php

declare(strict_types=1);

namespace SentDm\Channels\Rcs\RcsAgent;

/**
 * Where the agent stands, in terms of who is holding it up — PROVISIONING, ACTION_NEEDED,
 * PENDING_REVIEW or ACTIVE.
 *
 * Resolved from both of the provider's axes rather than reported raw: an agent whose resubmission
 * we have asked for reads ACTION_NEEDED however its carrier status still reads, and an agent not
 * yet handed over reads PROVISIONING rather than pending a review nobody has started.
 */
enum Status: string
{
    case PROVISIONING = 'PROVISIONING';

    case ACTION_NEEDED = 'ACTION_NEEDED';

    case PENDING_REVIEW = 'PENDING_REVIEW';

    case ACTIVE = 'ACTIVE';

    case INACTIVE = 'INACTIVE';
}
