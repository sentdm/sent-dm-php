<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\SMSMarket;

/**
 * Where this market's sender stands, in terms of who is holding it up — PROVISIONING,
 * ACTION_NEEDED, PENDING_REVIEW or ACTIVE. Read-only.
 *
 * Resolved rather than reported raw: a live sender reads ACTIVE whatever it still owes, a
 * market with outstanding requirements or an open resubmission request reads ACTION_NEEDED, and a
 * market that registers with a regime reads PENDING_REVIEW once its brand exists — filing to The
 * Campaign Registry is ours to do and need not have happened yet, so a dedicated brand created through
 * this API reads PENDING_REVIEW from the moment it is stored.
 *
 * Describes whether the market can send, not each number: a market holding several numbers reads
 * ACTIVE as soon as one of them is, whatever the others are doing. Each number's own status is in
 * numbers.
 */
enum Status: string
{
    case PROVISIONING = 'PROVISIONING';

    case ACTION_NEEDED = 'ACTION_NEEDED';

    case PENDING_REVIEW = 'PENDING_REVIEW';

    case ACTIVE = 'ACTIVE';

    case INACTIVE = 'INACTIVE';
}
