<?php

declare(strict_types=1);

namespace SentDm\Channels\Voice\VoiceUpdateParams;

/**
 * ACTIVE turns calls on for the number again, INACTIVE turns them off. Matched
 * ignoring case. Turning the default line off is refused while other active voice numbers remain.
 */
enum Status: string
{
    case ACTIVE = 'ACTIVE';

    case INACTIVE = 'INACTIVE';
}
