<?php

declare(strict_types=1);

namespace SentDm\Channels\Rcs\RcCreateParams;

/**
 * Which kind of traffic the agent carries. One of the accepted use cases; the error names the set.
 */
enum AgentUseCase: string
{
    case VERIFICATION = 'VERIFICATION';

    case NOTIFICATIONS = 'NOTIFICATIONS';

    case MARKETING = 'MARKETING';

    case MULTI_USE = 'MULTI_USE';
}
